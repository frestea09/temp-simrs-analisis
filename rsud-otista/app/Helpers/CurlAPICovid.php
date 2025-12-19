<?php 

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;

class CurlAPICovid
{
    protected $client;

    public function __construct()
    {
        //Get Timestamp
        $dt = new DateTime(null, new DateTimeZone("UTC"));
        $timestamp = $dt->getTimestamp();

        $header = array(
            'X-rs-id: ' . config('app.covid_rs_id'),
            'X-pass: ' . config('app.covid_rs_pass'),
            'X-Timestamp: ' . $timestamp,
			'Content-Type: application/json',
        );
        $this->header = $header;
    }

    public function get($path)
    {
        try{
            $completeurl =  config('app.covid_base_url') . $path;
            $session = curl_init($completeurl);
            
            curl_setopt($session, CURLOPT_HTTPHEADER, $this->header);
            curl_setopt($session, CURLOPT_HTTPGET, 1);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

            $response = curl_exec($session);
            $httpcode = curl_getinfo($session, CURLINFO_HTTP_CODE);
            $result['data'] = json_decode($response, true);
            $result['status'] = $httpcode;
            return $result;

        }catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function post($path, $body)
    {
        try{
            $completeurl =  config('app.covid_base_url') . $path;
            $session = curl_init($completeurl);

            // curl_setopt($session, CURLOPT_SSLVERSION, 3);
            // curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);
            // curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($session, CURLOPT_HTTPHEADER, $this->header);
            curl_setopt($session, CURLOPT_POSTFIELDS, $body);
            curl_setopt($session, CURLOPT_POST, TRUE);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

            $response = curl_exec($session);

            if ($response === false) {
                dd(curl_error($session), curl_errno($session));
            } 

            $httpcode = curl_getinfo($session, CURLINFO_HTTP_CODE);
            $result['data'] = json_decode($response, true);
            $result['status'] = $httpcode;
            return $result;

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function put($path, $body)
    {
        try{
            $completeurl =  config('app.covid_base_url') . $path;
            $session = curl_init($completeurl);

            curl_setopt($session, CURLOPT_HTTPHEADER, $this->header);
            curl_setopt($session, CURLOPT_POSTFIELDS, $body);
            curl_setopt($session, CURLOPT_POST, TRUE);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");

            $response = curl_exec($session);
            $httpcode = curl_getinfo($session, CURLINFO_HTTP_CODE);
            $result['data'] = json_decode($response, true);
            $result['status'] = $httpcode;
            return $result;

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($path, $body)
    {
        try{
            $completeurl =  config('app.covid_base_url') . $path;
            $session = curl_init($completeurl);

            curl_setopt($session, CURLOPT_HTTPHEADER, $this->header);
            curl_setopt($session, CURLOPT_POSTFIELDS, $body);
            curl_setopt($session, CURLOPT_POST, TRUE);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");

            $response = curl_exec($session);
            $httpcode = curl_getinfo($session, CURLINFO_HTTP_CODE);
            $result['data'] = json_decode($response, true);
            $result['status'] = $httpcode;
            return $result;

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
