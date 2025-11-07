@php
// header('Content-Type: application/json');
  $ID = config('app.sep_id');
    $t = time();
    $data = "$ID&$t";
    $secretKey = config('app.sep_key');
    date_default_timezone_set('UTC');
    $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

    $completeurl = config('app.sep_url_web_service')."/SEP/" . $reg;

    $session = curl_init($completeurl);
    $arrheader = array(
      'X-cons-id: ' . $ID,
      'X-timestamp: ' . $t,
      'X-signature: ' . $signature,
      'Content-Type: application/x-www-form-urlencoded',
    );
    curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
    curl_setopt($session, CURLOPT_HTTPGET, 1);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($session);
    $sml = json_decode($response, true);
    $json = json_encode($sml);

    echo $json; die;

    //echo $sml['response']['peserta']['noKartu']; die;

@endphp