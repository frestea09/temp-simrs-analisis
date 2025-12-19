<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrivaController extends Controller
{
    public function getToken()
    {
		$path = "https://sandbox.partner.api.bri.co.id/oauth/client_credential/accesstoken?grant_type=client_credentials";
		$client_id = 'Cy0MUWxyoKFAGLItZ4RA9a6KUdkWIvdV';
		$client_secret = 'RcHGAYaIvXJroKyL';

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $path,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "client_id=".$client_id."&client_secret=".$client_secret,
		  CURLOPT_HTTPHEADER => array(
		    "Accept: */*",
		    "Accept-Encoding: gzip, deflate",
		    "Cache-Control: no-cache",
		    "Connection: keep-alive",
		    "Content-Length: 73",
		    "Content-Type: application/x-www-form-urlencoded",
		  ),
		));

		$response = curl_exec($curl);
		$sml = json_decode($response, true);
		return $sml['access_token'];
    }

    public function generateSignature($path, $verb, $token, $timestamp, $body, $secret) {
	    $payload = "path=$path&verb=$verb&token=$token"."&timestamp=$timestamp&body=$body";
	    $signPayload = hash_hmac('sha256', $payload, $secret, true);
	    $base64sign = base64_encode($signPayload);
	    return $base64sign;
	}

	public function createVA()
	{
		$data = "{\n\t\"institutionCode\": \"J104408\",\n\t\"brivaNo\": \"77777\",\n\t\"custCode\": \"200222\",\n\t\"nama\": \"Yories\",\n\t\"amount\": \"100001\",\n\t\"keterangan\": \"\",\n\t\"expiredDate\": \"".date("Y-m-d H:i:s")."\"\n}";

		$path ='https://sandbox.partner.api.bri.co.id/v1/briva';
		$verb ='POST';
		$token ='Bearer '.$this->getToken();
		$timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
		$secret ='RcHGAYaIvXJroKyL';
		$body = 'path='.$path.'&verb='.$verb.'&token='.$token.''.'&amp;'.'timestamp='.$timestamp.'&body='.$data;

		$signature = $this->generateSignature($path, $verb, $token, $timestamp, $body, $secret);

		$curl = curl_init();
		curl_setopt_array($curl, array(
			  CURLOPT_URL => $path,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $data,
			  CURLOPT_HTTPHEADER => array(
			  	"Authorization: ".$token,
			    "BRI-Signature: ".$signature,
			    "BRI-Timestamp: ".$timestamp,
			    "Content-Type: application/json"
			  ),
		));

		$response = curl_exec($curl);
		$sml = json_decode($response, true);
		return $sml;
	}
}
