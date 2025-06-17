<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;

trait SendPushNotification
{
    protected function sendAsbroadcast($notification, $data)
    {
        
        $url = 'https://fcm.googleapis.com/v1/projects/dd/messages:send';
        $serverKey = $this->getAccessToken();
        \Log::channel("fcm_token")->info("data => " ,[$data,$notification]);
        \Log::channel("fcm_token")->info("fcm_token toke => " ,[$serverKey]);
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$serverKey}",
            'Content-Type' => 'application/json'
        ])->post(
                $url,
                [
                    "message" => [
                        "topic" => "all_users",
                        "notification" => $notification,
                        "data" => $data
                    ]
                ]
            );

        if ($response->failed()) {
           // \Log::info($response->body());
            // dd( ['response' => $response->body()]);
        }
        \Log::channel("fcm_token")->info("fcm res => ", $response->json());
        // dd($response->json());
    }

    protected function sendAsUnicast($token, $notification, $data)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/dd/messages:send';
        $serverKey = $this->getAccessToken();
        //\Log::info($serverKey);
        $iosNotification = [
            'alert' => [
                'title' => $notification['title'],
                'body' => $notification['body'],
            ],
        ];
        Http::withHeaders([
            'Authorization' => "Bearer {$serverKey}",
            'Content-Type' => 'application/json'
        ])->post(
                $url,
                [
                    'message' => [
                        'token' => $token,
                        'android' => [
                            'notification' => $notification,
                            'data' => $data
                        ],
                        // 'ios' => [
                        //     // 'token' => $token,
                        //     'notification' => $iosNotification,
                        //     'data' => $data
                        // ]
                    ]
                ]
            );
    }



    protected function sendAsUnicastDataOnly($token, $data)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/dd/messages:send';
        $serverKey = $this->getAccessToken();
        Http::withHeaders([
            'Authorization' => "Bearer {$serverKey}",
            'Content-Type' => 'application/json'
        ])->post(
                $url,
                [
                    "to" => $token,
                    "priority" => "high",
                    // "notification" => $notification,
                    "data" => $data
                ]
            );
    }

    public function getAccessToken()
    {
        $jwt = $this->createJwt();

        // Prepare the token request payload
        $data = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ];

        $ch = curl_init('https://oauth2.googleapis.com/token'); // Initialize cURL session
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch); // Execute cURL request
        curl_close($ch);

        $tokenInfo = json_decode($response, true); // Decode the response

        if (isset($tokenInfo['access_token'])) {
            return $tokenInfo['access_token'];
        } else {
            throw new \Exception('Error fetching access token:');
        }
    }

    private function createJwt()
    {
        $serviceAccount = json_decode(file_get_contents(__DIR__ . '/firebase-adminsdk.json'), true);
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];
        $now = time();
        $claims = [
            'iss' => $serviceAccount['client_email'], // Issuer claim (Service account email)
            'scope' => 'https://www.googleapis.com/auth/cloud-platform', // Firebase scope
            'aud' => 'https://oauth2.googleapis.com/token', // Audience claim (Token endpoint)
            'iat' => $now, // Issued at time
            'exp' => $now + 3600, // Expiry time (1 hour)
        ];

        // Encode header and claims
        $encodedHeader = $this->base64UrlEncode(json_encode($header));
        $encodedClaims = $this->base64UrlEncode(json_encode($claims));

        // Concatenate header and claims with a period
        $unsignedJwt = $encodedHeader . '.' . $encodedClaims;

        // Sign the JWT using the private key
        $privateKey = openssl_pkey_get_private($serviceAccount['private_key']);
        openssl_sign($unsignedJwt, $signature, $privateKey, 'SHA256');
        openssl_free_key($privateKey);

        // Encode the signature
        $encodedSignature = $this->base64UrlEncode($signature);

        // Return the complete JWT
        return $unsignedJwt . '.' . $encodedSignature;
    }

    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}