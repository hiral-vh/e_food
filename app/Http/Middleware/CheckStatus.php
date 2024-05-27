<?php

namespace App\Http\Middleware;

use App\Models\admin\Owner;
use App\Models\admin\Ownerrecuringhistory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TotalOrderNotification;
use Carbon\Carbon;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ownerData = Owner::find(Auth::user()->id);

        $ownerRecurringPaymentData = Ownerrecuringhistory::where('user_id', $ownerData->id)->orderBy('id', 'DESC')->first();
        $currentDate = strtotime(date('Y-m-d', strtotime(now())));
        $endDate = strtotime(date('Y-m-d', strtotime($ownerRecurringPaymentData->end_date)));

        if ($ownerData->plan_id == 1) {
            if ($currentDate >= $endDate || $ownerData->total_orders == 0) {
                Owner::where('id', $ownerData->id)->update(['subscription_flag' => '0', 'total_orders' => 0]);
            }
        } else {
            if ($ownerData->total_orders == 0) {
                Owner::where('id', $ownerData->id)->update(['subscription_flag' => '0', 'total_orders' => 0]);
            }
        }


        if ($ownerData) {
            if ($ownerData->subscription_flag == '0') {
                return redirect('subscription');
            }

            return $next($request);
        }
    }
}
