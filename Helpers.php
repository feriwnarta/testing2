<?php

class Helpers
{

    public function getUserInfo()
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    

        $url = "http://ip-api.com/batch";
        $data = [
            [
                "query" => $ip_address,
                "fields" => "city,country,countryCode,query"
            ],
            "8.8.8.8"
        ];
        $json_data = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            return [];
        }


        $data = json_decode($response);
        curl_close($ch);
        
        


        $country = $data[0]->country;
        $device = $this->getDeviceInfo();

        return array(
            'country' => $country,
            'device' => $device
        );
        
    }

    public function getDeviceInfo()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];



        $devices = array(
            'Windows Phone' => 'windows phone',
            'iPad' => 'ipad',
            'iPod' => 'ipod',
            'iPhone' => 'iphone',
            'Android' => 'android',
            'BlackBerry' => 'blackberry',
            'Macintosh' => 'macintosh',
            'Windows' => 'windows'
        );

        foreach ($devices as $device => $value) {
            if (stripos($user_agent, $value) !== false) {
                return $device;
            }
        }

        return 'Unknown';
    }
}
