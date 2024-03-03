<?php

namespace App\Http\Repositories;


use App\Models\Payment;
use Carbon\Carbon;
use GuzzleHttp\Client;
use PHPUnit\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class MainInfoRepository
{
    public function getUserIp()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.bigdatacloud.net/data/client-ip');

        $data = json_decode($response->getBody(), true);

        return $data['ipString'] ?? null;
    }


    function getCurrencyByIP($ip) {

        $currency = env('CURRENCY_DEFAULT','USD');

        try {
            $ipinfo_url = "https://ipinfo.io/$ip?token=" . env('IP_INFO_TOKEN');

            $curl_session = curl_init();
            curl_setopt($curl_session, CURLOPT_URL, $ipinfo_url);
            curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);

            $ipinfo_response = curl_exec($curl_session);

            if ($ipinfo_response === false) {
                curl_close($curl_session);
                throw new \Exception("Error obtaining IP information");
            }


            $ipinfo_data = json_decode($ipinfo_response, true);
            $country_code = $ipinfo_data['country'];


            $restcountries_url = "https://restcountries.com/v3.1/alpha/$country_code";

            curl_setopt($curl_session, CURLOPT_URL, $restcountries_url);

            $restcountries_response = curl_exec($curl_session);
            curl_close($curl_session);

            if ($restcountries_response === false) {
                throw new \Exception("Error obtaining country information");
            }

            $restcountries_data = json_decode($restcountries_response, true);

            $currencies = array_keys($restcountries_data[0]['currencies']);
            $currency = $currencies[0];

        }catch (Exception $e){
            $currency = env('CURRENCY_DEFAULT','USD');
        }

        return $currency;


    }


    public function isPremium(): bool
    {

        try {
            if ($token = JWTAuth::getToken()) {
                $user = JWTAuth::parseToken()->authenticate();

                $isPremium = false;
                $paymentId = $user->payment_id;

                if($paymentId){
                    $payment = Payment::find($user->payment_id);
                    if($payment->subscription_end_date){
                        $dateExpiration = Carbon::createFromFormat('Y-m-d H:i:s',$payment->subscription_end_date);
                        $currentDate = Carbon::now();
                        $isPremium = $dateExpiration->gt($currentDate);
                    }else{
                        return true;
                    }
                }

                return $isPremium;

            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return false;
        }

        return false;

    }



}
