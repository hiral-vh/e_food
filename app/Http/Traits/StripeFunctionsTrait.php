<?php

namespace App\Http\Traits;

use App\Models\Events;
use App\Models\Lr_business_login;
use App\Models\BusinessPackages;
use App\Models\admin\Owner;
use App\Models\admin\Subcription;
use App\Models\admin\Ownerpayment;
use App\Models\admin\SiteSetting;
use App\Models\Payments;
use Stripe\Stripe;

trait StripeFunctionsTrait
{
    public function addStripeCustomer($ownerid, $businessPackageId)
    {
        $businessStripe = Owner::where('id', $ownerid);
        if ($businessStripe->count()) {
            $businessStripe = $businessStripe->first();
            if ($businessStripe->stripe_customer_id)
                return $businessPackageId;
        }

        $business = Owner::find($ownerid);

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $customer = $stripe->customers->create([
            'description' => $business->restaurant_name,
            'email' => $business->email,
        ]);
        if ($customer->object = 'customer') {
            $businessPackage = Subcription::find($businessPackageId);
            $data = array();
            $data['stripe_customer_id'] = $customer->id;
            $data['stripe_invoice_prefix'] = $customer->invoice_prefix;
            //$data['stripe_subscription_id'] = $businessPackage->stripe_plan_id;

            $businessStripe = Owner::where('id', $ownerid)->update($data);
            return $businessPackageId;
        } else
            return false;
    }
    public function CreateBusinessPaymentSession($businessId, $businessStripeId)
    {
        $business = Owner::find($businessId);
        $businessStripe = Subcription::find($businessStripeId);

        $insertArray = array(
            'plan_id' => $businessStripeId,
            'owner_id' => $businessId,
            'payment_type' => 'subscription',
            'created_at' => date('Y-m-d H:i:s')
        );
        $insert = new Ownerpayment($insertArray);
        $insert->save();
        $payment = $insert->id;
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session =  \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $businessStripe->stripe_plan_id,
                'quantity' => 1,
            ]],
            'metadata' => [
                'business_id' => $business->id,
                'business_stripe_id' => $businessStripeId
            ],
            'mode' => 'subscription',
            'success_url' => route('paymentSuccess', $payment),
            'cancel_url' => route('paymentFailed', $payment),
        ]);


        $udpate = Ownerpayment::where('id', $payment)->update(array('payment_request_id' => $session->id));
        return $session->id;
    }

    public function topAmountCustomer($resturentid, $paymentid)
    {

        $userData = Owner::find($resturentid);
        $stripePaymentData = Ownerpayment::find($paymentid);

        $getTopupAmount = SiteSetting::find(1);
        $topupAmount = 0;
        if ($getTopupAmount->top_up_amount != '') {
            $topupAmount = $getTopupAmount->top_up_amount;
        }
        $totalAmount = $stripePaymentData->total_order * $topupAmount;

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session =  \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Payment for Topup of extra order ' . $stripePaymentData->total_order . ' to total days' . $stripePaymentData->total_days,
                    ],
                    'unit_amount' => $totalAmount,
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'First Name' => $userData->restaurant_name,
                'Last Name' => $userData->owner_name,
                'Email' => $userData->email,
            ],
            'mode' => 'payment',
            'success_url' => route('paymentSuccessTopup', [$paymentid]),
            'cancel_url' => route('paymentFailedTopup', [$paymentid]),
        ]);
        $udpate = Ownerpayment::where('id', $paymentid)->update(array('payment_request_id' => $session->id));
        return $session->id;
    }
}
