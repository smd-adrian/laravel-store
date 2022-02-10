<?php
namespace App\Evertec;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class Evertec
{
    /**
     * Send request to web service
     * @param $order_data <Array>
     * @param $total <Integer>
     * @param $verify <Boolen>
     */
    public static function createSession($order_data, $total, $order_token, $verify = false)
    {
        $trankey = config('app.evertec.trankey');
        $nonce_string = Str::random(16);
        $current_date = Carbon::now();
        $nonce = base64_encode($nonce_string);
        $trankey_encode = base64_encode(sha1($nonce_string . $current_date->toIso8601String() . $trankey, true));

        $data_service = [
            "locale" => "es_CO",
            "auth" => [
                "login" => config('app.evertec.login'),
                "nonce" => $nonce,
                "tranKey" => $trankey_encode,
                "seed" => $current_date->toIso8601String()
            ],
            "buyer" => [
                'name' => $order_data['customer_name'],
                'email' => $order_data['customer_email'],
                'mobile' => $order_data['customer_mobile']
            ],
            "payment" => [
                "reference" => "1122334455",
                "description" => "Compra en ShopByEvertec",
                "amount" => [
                    "currency" => "COP",
                    "total" => intval($total)
                ],
                "allowPartial" => false
            ],
            "expiration" => $current_date->addHours(1),
            "returnUrl" => "https://evertec-store.test/orden/confirmar/" . $order_token,
            "ipAddress" => $_SERVER['SERVER_ADDR'],
            "userAgent" => $_SERVER['HTTP_USER_AGENT']
        ];

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $data = [
            'json' => $data_service,
            'verify' => $verify
        ];

        $response = $client->post(config('app.evertec.base_url'). 'api/session', $data);
        
        return json_decode($response->getBody());

    }

    /**
     * 
     */
    public static function checkSession($request_id, $verify = false)
    {
        $trankey = config('app.evertec.trankey');
        $nonce_string = Str::random(16);
        $current_date = Carbon::now();
        $nonce = base64_encode($nonce_string);
        $trankey_encode = base64_encode(sha1($nonce_string . $current_date->toIso8601String() . $trankey, true));

        $data_service = [
            "locale" => "es_CO",
            "auth" => [
                "login" => config('app.evertec.login'),
                "nonce" => $nonce,
                "tranKey" => $trankey_encode,
                "seed" => $current_date->toIso8601String()
            ]
        ];

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $data = [
            'json' => $data_service,
            'verify' => $verify
        ];

        $response = $client->post(config('app.evertec.base_url'). 'api/session/' . $request_id, $data);
        
        return json_decode($response->getBody());
    }

}
