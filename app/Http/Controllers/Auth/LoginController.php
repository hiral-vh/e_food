<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Interfaces\admin\LoginRepositoryInterface;
use App\Interfaces\admin\SubcriptionRepositoryInterface;
use App\Interfaces\admin\CuisineRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helpers\MailHelper;
use App\Http\Traits\StripeFunctionsTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
use App\Models\admin\Owner;
use App\Models\admin\Subcription;
use App\Models\admin\Ownerpayment;
use App\Models\admin\Ownerrecuringhistory;
use URL;
use Mail;
use App\Mail\SendMailable;
use App\Models\admin\Owner as AdminOwner;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $subcriptionRepository = "", $loginRepository = "",  $cuisineRepository = "";
    private $authId;
    use StripeFunctionsTrait;
    public function __construct(LoginRepositoryInterface $loginRepository, SubcriptionRepositoryInterface $subcriptionRepository, CuisineRepositoryInterface $cuisineRepository)
    {
        $this->loginRepository = $loginRepository;
        $this->subcriptionRepository = $subcriptionRepository;
        $this->cuisineRepository = $cuisineRepository;
    }

    public function verify_register(Request $request)
    {
        $insert =  $this->loginRepository->insertOwnerdata($request);
        if ($insert) {

            $startDate = date('Y-m-d H:i:s');
            $endDate = date('Y-m-d H:i:s', strtotime("+1 months", strtotime($startDate)));
            $insertArray = array(
                'user_id' => $insert->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'created_at' => date('Y-m-d H:i:s')
            );
            $insert = new Ownerrecuringhistory($insertArray);
            $insert->save();

            $update = Owner::where('id', $insert->id)->update(array('restaurant_id' =>  $insert->id));
            Session::flash('success', 'Register successfully. Please do login and purchase the subscription');
            return redirect('/login');
        } else {
            return redirect()->route('register-owner')
                ->with('error', 'Something went wrong');
        }
    }

    public function subscription(Request $request)
    {

        $ownerData = Owner::find(Auth::user()->id);
        /*if ($ownerData) {
            if ($ownerData->subscription_flag == '1') {
                Session::flash('error', 'Already purchased subscription');
                return redirect('restaurant-dashboard');
            }
        }*/
        $data['getAllsubscription'] = $this->subcriptionRepository->getAllsubscription();
        return view('admin.subscription', $data);
    }
    public function upgradeSubscription(Request $request)
    {

        $restaurantId = Auth::user()->id;
        $data['getAllsubscription'] = $this->subcriptionRepository->getAllsubscription();

        $getPlans = Owner::where('id', $restaurantId)->first();
        $data['plan_id'] = '';
        if ($getPlans) {
            $data['plan_id'] = $getPlans->plan_id;
        }
        // echo '<pre>';
        // print_r($data['getAllsubscription']);
        // die();

        return view('admin.upgrade-subscription', $data);
    }
    public function cancelSubscription(Request $request)
    {
        $restaurantId = Auth::user()->id;

        $getPayment = Ownerpayment::where('owner_id', $restaurantId)->orderBy('id', 'desc')->first();

        


        if ($getPayment->subscription_id == '') {
            Session::flash('error', 'No Subscription Found');
            return redirect()->back();
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        try {
            $customer = $stripe->subscriptions->cancel(
                $getPayment->subscription_id,
                []
            );
            if ($customer) {
                $update = Ownerpayment::where('subscription_id', $getPayment->subscription_id)->update(array('subscriptionCancel' => 'Cancel'));

                $updatePayment = Ownerrecuringhistory::where('user_id', $getPayment->owner_id)->where('plan_id', $getPayment->plan_id)->update(array('cancel_subscription' => 'cancel'));

                Session::flash('success', 'Successfully Cancelled Subscription');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Session::flash('error', 'Something went Wrong.');
            return redirect()->back();
        }
    }
    public function subscription_purchase(Request $request)
    {
        $restarantId = Auth::user()->id;
        $ownerData = Owner::find($restarantId);
        /*if ($ownerData) {
            if ($ownerData->subscription_flag == '1') {
                Session::flash('error', 'Already purchased subscription');
                return redirect('restaurant-dashboard');
            }
        }*/
        $businessStripe = $this->addStripeCustomer($restarantId, $request->id);
        return redirect()->route('makePayment', [$restarantId, $businessStripe]);
    }

    public function createPaymentSession(Request $request)
    {
        $sessionId = $this->CreateBusinessPaymentSession($request->business_id, $request->business_stripe_id);
        return response()->json(['id' => $sessionId]);
    }

    public function makePayment($businessId, $businessStripeId)
    {
        $businessStripe = Owner::find($businessId);
        /*if ($businessStripe) {
            if ($businessStripe->subscription_flag == '1') {
                Session::flash('error', 'Already purchased subscription');
                return redirect('restaurant-dashboard');
            }
        }*/
        return view('admin.make-payment', ['businessId' => $businessId, 'businessStripe' => $businessStripeId]);
    }

    public function paymentSuccess($paymentId)
    {
        $restarantId = Auth::user()->id;
        $payment = Ownerpayment::find($paymentId);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $paymentResponse = $stripe->checkout->sessions->retrieve(
            $payment->payment_request_id,
            []
        );

        $update = Ownerpayment::where('id', $paymentId)->update(array('payment_status' => $paymentResponse->payment_status, 'payment_date' => date('Y-m-d'), 'subscription_id' => $paymentResponse->subscription, 'gateway_response' => $paymentResponse));
        $startDate = date('Y-m-d H:i:s');
        $subscription = Subcription::find($payment->plan_id);
        $endDate = date('Y-m-d H:i:s', strtotime("+" . $subscription->plan_duration . " months", strtotime($startDate)));
        $insertArray = array(
            'user_id' => $restarantId,
            'plan_id' => $payment->plan_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'created_at' => date('Y-m-d H:i:s')
        );
        $insert = new Ownerrecuringhistory($insertArray);
        $insert->save();

        $allowed_order = $subscription->allowed_order;

        // $remainingOrder = Auth::user()->total_orders;
        // $totalOrder = $remainingOrder + $allowed_order;

        $updateUser = Owner::where('id', $restarantId)->update(array('subscription_flag' => '1', 'total_orders' => $allowed_order, 'stripe_subscription_id' => $paymentResponse->subscription, 'plan_id' => $payment->plan_id));
        Session::flash('success', 'Subscription purchased successfully');
        return redirect('restaurant-dashboard');
    }

    public function paymentFailed($paymentId)
    {
        $payment = Ownerpayment::find($paymentId);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $paymentResponse = $stripe->checkout->sessions->retrieve(
            $payment->payment_request_id,
            []
        );

        $update = Ownerpayment::where('id', $paymentId)->update(array('payment_status' => $paymentResponse->payment_status, 'gateway_response' => $paymentResponse));
        Session::flash('error', 'Payment Failed');
        return redirect('subscription');
    }

    public function register_owner(Request $request)
    {
        $data['crusineData'] = $this->cuisineRepository->getCuisindata();
        return view('auth.register', $data);
    }
    public function check_owner_register_email(Request $request)
    {
        $query = $this->loginRepository->checkForgotEmail($request['email']);
        if ($query) {
            echo 0;
        } else {
            echo 1;
        }
    }
    public function check_owner_register_business_number(Request $request)
    {
        $query = $this->loginRepository->checkForgotBusinessnumber($request['business_number']);
        if ($query) {
            echo 0;
        } else {
            echo 1;
        }
    }
    public function check_owner_register_phone(Request $request)
    {
        $query = $this->loginRepository->checkForgotPhoneno($request['phone_no']);
        if ($query) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function verify_login(Request $request)
    {   
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('restaurantportal')->attempt($credentials)) {
            $request->session()->regenerate();
            $userid = \Auth::guard('restaurantportal')->user()->id;
            // $getUserData = Owner::find($userid);
            // if ($getUserData->stripeflag == '0') {

            //     $token =  response()->json(['route' => url('profile'),'status'=>'1','message'=>'Please fill all information in profile.']);
            //     // Session::flash('success', 'Please fill all information in profile');
            //     // return redirect('profile');
            // } else {
                
            //     $token = response()->json(['route' =>route('dashboard'),'status'=>'1','message'=>'You are successfully logged in.']);
            // }
            // return $token;
            Session::flash('success', 'Successfully Logged In');
                return redirect('restaurant-dashboard');
        } else {
            return redirect()->route('login')
                ->with('error', 'Email or Password is incorrect');
        }
    }
    public function verify_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect("forgot-password")
                ->withErrors($validator, 'auth.forgot-password')
                ->withInput();
        } else {
            $email = request('email');
            $checkEmail = $this->loginRepository->checkForgotEmail($email);

            if ($checkEmail) {

                $string = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
                $rand =  substr(str_shuffle($string), 0, 8);
                $encrypted = Crypt::encrypt($rand);


                $html = '<p>A request to reset your Admin password has been made. If you did not make this request, simply ignore this email. If you did make this request, please reset your password:</p>
                <center>
                    <a href="' . URL::to('/reset_password_view/' . $encrypted) . '" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; border-color: #ef5c6a; background: #ef5c6a; border-radius: 60px; text-decoration:none;">Reset Password</a>
                </center>';

                $subject = __('emails.forgot_email');
                $BODY = __('emails.forgot_email_body', ['USERNAME' => $checkEmail->name, 'HTMLTABLE' => $html]);
                $body_email = __('emails.template', ['BODYCONTENT' => $BODY]);

                $mail = MailHelper::mail_send($body_email, $email, $subject);
                $data = array('otp' => $rand);
                $update = $this->loginRepository->updateAdmin($email, $data);
                if ($update) {
                    Session::flash('success', 'Email send successfully');
                    return redirect('/login');
                }
            } else {
                Session::flash('error', 'There isn’t any account associated with this email');
                return redirect('forgot-password');
            }
        }
    }
    public function reset_password_view(Request $request, $otp)
    {

        $this->data['otp'] = $otp;

        $otpchange = Crypt::decrypt($otp);
        $checkOtp = $this->loginRepository->getbyOTP($otpchange);
        if ($checkOtp) {
            return view('auth.reset_password', $this->data);
        } else {
            return view('admin.error');
        }
    }
    public function success_password(Request $request)
    {
        return view('auth.sucesspassword');
    }
    public function reset_password(Request $request, $otpen)
    {
        $otp = Crypt::decrypt($otpen);

        $password = request('password');
        $cpassword = request('confirm_password');


        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return redirect("reset_password_view/" . $otpen)
                ->withErrors($validator, 'reset')
                ->withInput();
        } else {

            $checkdata = $this->loginRepository->getByOTP($otp);


            if ($checkdata) {
                $data = array('password' => Hash::make($password), 'otp' => null);

                $update = Owner::where('otp', $otp)->update($data);
                if ($update) {
                    //die('123');
                    Session::flash('success', 'Password reset successfully');
                    return redirect('/login');
                } else {

                    Session::flash('error', 'Sorry, something went wrong. Please try again');
                    return redirect()->back();
                }
            } else {

                Session::flash('error', 'Sorry, something went wrong. Please try again');
                return redirect('/reset_password');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('restaurantportal')->logout();
        return redirect('/login')->with('success', 'Successfully Logged Out');
    }
}
