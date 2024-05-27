<?php

namespace App\Http\Controllers\Cronjob;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\Userbooktable;
use App\Interfaces\admin\UserbooktableRepositoryInterface;
use App\Interfaces\admin\NotificationRepositoryInterface;
use App\Interfaces\admin\UserRepositoryInterface;
use App\Helpers\NotificationHelper;
use App\Models\admin\Owner;
use App\Models\admin\Ownerrecuringhistory;
use App\Models\admin\Subcription;
use Stripe\Stripe;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TotalOrderNotification;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class CronJobController extends Controller
{
	protected  $userbooktableRepository = '', $userRepository = '', $notificationRepository = '';
	public function __construct(UserbooktableRepositoryInterface $userbooktableRepository, UserRepositoryInterface $userRepository, NotificationRepositoryInterface $notificationRepository)
	{
		$this->userbooktableRepository = $userbooktableRepository;
		$this->userRepository = $userRepository;
		$this->notificationRepository = $notificationRepository;
	}
	function tableFiveHoursNotification()
	{
		$getUsertablereadyData = $this->userbooktableRepository->getFiveHoursBookTable();

		if (count($getUsertablereadyData) > 0) {
			foreach ($getUsertablereadyData as $ckey) {
				// send notification to user book table
				$updateArray = array(
					'send_notification' => '1',
					'updated_at' => date('Y-m-d H:i:s')
				);
				$update = Userbooktable::where('id', $ckey->id)->update($updateArray);
				$did = $ckey->user_id;
				$title = 'Just A Reminder!';
				$msg = 'Your Table is ready in 5 hours.';
				$notifications = self::sendNotification($did, $title, $msg, '1', $ckey->id);
			}
		}
		 
	}
	function tableOneDayNotification()
	{
		$getUsertablereadyData = $this->userbooktableRepository->getOneDayBookTable();
		
		if (count($getUsertablereadyData) > 0) {
			foreach ($getUsertablereadyData as $ckey) {

			
				// send notification to user book table
				$updateArray = array(
					'send_notification' => '1',
					'updated_at' => date('Y-m-d H:i:s')
				);
				$update = Userbooktable::where('id', $ckey->id)->update($updateArray);
				$did = $ckey->user_id;
				$title = 'Just A Reminder!';
				$msg = 'Your Table is ready in 24 hours.';
				$notifications = self::sendNotification($did, $title, $msg, '1', $ckey->id);
			}
		}
	
	}
	function usertableReady()
	{
		$getUsertablereadyData = $this->userbooktableRepository->getUserBooktimetable();

		if (count($getUsertablereadyData) > 0) {
			foreach ($getUsertablereadyData as $ckey) {
				// send notification to user book table
				$updateArray = array(
					'send_notification' => '1',
					'updated_at' => date('Y-m-d H:i:s')
				);
				$update = Userbooktable::where('id', $ckey->id)->update($updateArray);
				$did = $ckey->user_id;
				$title = 'Your table is ready!';
				$msg = 'Have you been seated?';
				$notifications = self::sendNotification($did, $title, $msg, '1', $ckey->id);
			}
		}
	}
	function checkResturentsubscription()
	{
		$date = date('Y-m-d');
		$getAllResturentdata = Owner::whereNull('deleted_at')->where('subscription_flag', '1')->get();
		if (count($getAllResturentdata) > 0) {
			foreach ($getAllResturentdata as $key) {

				$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
				$subscriptionData = $stripe->subscriptions->retrieve(
					$key->stripe_subscription_id,
					[]
				);

				if (!empty($subscriptionData)) {
					if ($subscriptionData->cancel_at == '') {
						$current_period_start = date('Y-m-d', $subscriptionData->current_period_start);
						if ($date == $current_period_start) {
							$checkEntryInhistory = Ownerrecuringhistory::where('user_id', $key->id)->whereRaw('DATE_FORMAT(start_date, "%Y-%m-%d")', date('Y-m-d', $subscriptionData->current_period_start))->whereRaw('DATE_FORMAT(end_date, "%Y-%m-%d")', date('Y-m-d', $subscriptionData->current_period_end))->get();
							if (count($checkEntryInhistory) == 0) {
								// update order
								$subscription = Subcription::find($key->plan_id);
								$allowed_order = $subscription->allowed_order;

								$update = Owner::where('id', $key->id)->update(array('total_orders' => $allowed_order));

								$insertArray = array(
									'user_id' => $key->id,
									'start_date' => date('Y-m-d H:i:s', $subscriptionData->current_period_start),
									'end_date' => date('Y-m-d H:i:s', $subscriptionData->current_period_end),
									'created_at' => date('Y-m-d H:i:s')
								);
								$insert = new Ownerrecuringhistory($insertArray);
								$insert->save();
							}
						}
					}
				}
			}
		}
	}
	/* API Notification sent */
	public function sendNotification($userid, $title, $msg, $type = '', $user_book_table_id)
	{

		$getDrivertoken = $this->userRepository->getByIddata($userid);
		date_default_timezone_set('UTC');
		$insarray = array(
			"user_id" => $userid,
			"user_book_table_id" => $user_book_table_id,
			"notification_title" => $title,
			"notification_description" => $msg,
			"notification_type" => $type,
			"notification_datetime" =>  date('Y-m-d H:i:s'),
			"created_date" => date('Y-m-d H:i:s')
		);
		$insert = $this->notificationRepository->storeNotification($insarray);

		$NotificationData =  array('message' => $msg, 'body' => $msg, "title" => $title, "user_book_table_id" => $user_book_table_id);
		if ($getDrivertoken) {
			NotificationHelper::pushToGoogle(array($getDrivertoken->device_token), $NotificationData);
		}
	}

	public function sendOrderNotification()
	{
		$query = Owner::where('total_orders', 10)->whereNull('deleted_at')->get();

		if (count($query) > 0) {
			foreach ($query as $rwData) {
				if ($rwData->total_orders == 10) {
					$details = [
						"type" => 1,
						"total_orders" => $rwData->total_orders,
						"message" => 'Dear ' . $rwData->owner_name . ', You have used 90% of your free trial. Please subscribe the best plans to continue your access.',
						"date&time" => Carbon::now(),
						"url" => route('subscription'),
					];

					Notification::send($rwData, new TotalOrderNotification($details));
				}
			}
		}
	}

	public function sendDateNotification()
	{
		$data = Owner::getAllData()->get();
		$dateTime = Carbon::now();
		$dateToday = date('Y-m-d', strtotime($dateTime));

		if (count($data) > 0) {
			$date = array();
			foreach ($data as $rwData) {
				$dates = date('Y-m-d', strtotime($rwData->end_date . ' - 3 days'));
				if ($dateToday == $dates) {
					$details = [
						"type" => 3,
						"total_orders" => $rwData->end_date,
						"message" => 'You have 3 days left to subscription.',
						"date&time" => Carbon::now(),
					];

					Notification::send($rwData, new TotalOrderNotification($details));
				}
			}
		}
	}
}
