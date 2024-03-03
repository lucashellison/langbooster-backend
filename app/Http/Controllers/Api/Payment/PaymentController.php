<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Mailgun\Mailgun;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Tymon\JWTAuth\Facades\JWTAuth;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request) {

        $validated = $request->validate([
            'amount' => 'required|numeric',
            'currencyId' => 'required|integer|exists:currencies,id'
        ]);

        $currencyId = $validated['currencyId'];
        $amount = (float) $validated['amount'];


        $currentAmount = null;
        $currencyCode = null;

        $currency = Currency::find($currencyId);

        if($currency){
            $currentAmount = (float) $currency->premium_price;
            $currencyCode = strtolower($currency->code);
            if($amount !== $currentAmount){
                return response()->json(['msgError' => 'Please note that the price has been recently updated. Refresh the page and try again to proceed with the current pricing.'], 400);
            }
        }

        try {

            if($currency->enable_decimal_places){
                $currentAmount = $currentAmount * 100;
            }



            Stripe::setApiKey(env('STRIPE_SECRET'));

            $user = JWTAuth::parseToken()->authenticate();
            $userId = $user->id;

            $customerId = $userId;
            $customerName =  $user->name;
            $customerEmail =  $user->email;

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $currentAmount,
                'currency' => $currencyCode,
                'payment_method_types' => ['card'],
                'receipt_email' => $customerEmail,
                'metadata' => [
                    'customer_id' => $customerId,
                    'customer_name' => $customerName
                ]
            ]);

            $paymentModel = new Payment();

            $paymentModel->user_id = $userId;
            $paymentModel->stripe_payment_id = $paymentIntent->id;
            $paymentModel->amount = ($paymentIntent->amount / 100);
            $paymentModel->currency = $paymentIntent->currency;
            $paymentModel->payment_status = $paymentIntent->status;


            $paymentModel->save();

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (ApiErrorException $e) {
            return response()->json(['msgError' => $e->getMessage()], 500);
        }


    }


    public function paymentUpdateStatus(Request $request)
    {

        $validated = $request->validate([
            'stripePaymentId' => 'required|string',
            'status' => 'required|string'
        ]);

        $stripePaymentId = $validated['stripePaymentId'];
        $status = $validated['status'];


        $payment = Payment::where('stripe_payment_id', $stripePaymentId)->first();

        if ($payment) {
            $payment->payment_status = $status;

            if($status === 'succeeded'){
                $payment->payment_date = Carbon::now();
                $payment->subscription_end_date = Carbon::now()->addYear();
            }

            $payment->save();

            if($status === 'succeeded'){
                $user = JWTAuth::parseToken()->authenticate();
                $userId = $user->id;

                $userModel = User::find($userId);
                $userModel->payment_id = $payment->id;
                $userModel->save();



                $names = explode(' ',$user->name);
                $firstName = $names[0];


                $mgClient = Mailgun::create(env('MAILGUN_API_KEY'));
                $domain = env('MAILGUN_DOMAIN');
                $url = env('APP_URL_PAGE');

                # Render the email body from a Blade view.
                $markdown = new Markdown(view(), config('mail.markdown'));
                $html = $markdown->render('emails.premium', ['firstName' => $firstName,'url' => $url]);

                # Make the call to the client.
                $result = $mgClient->messages()->send($domain, [
                    'from'    => 'LangBooster <'.env('EMAIL_ADDRESS_CONTACT').'>',
                    'to'      => $user->email,
                    'subject' => "✨ Congratulations! You're Now a LangBooster Premium Member!",
                    'html'    => $html
                ]);




            }



            return response()->json(['message' => 'Payment status updated successfully.']);
        }

        return response()->json(['error' => 'Payment not found.'], 404);


    }

}
