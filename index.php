<?php
include_once 'api/autoload.php';
use config\Database;
use v1\objects\Website;

$database = new Database();
$db = $database->getConnection();
$website = new Website($db);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.woolston.com.au/crm/v1/customers",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
$err = curl_error($curl);
curl_close($curl);
$data = json_decode($response, true);
$sites = $data["data"];

foreach($sites as $site) {
    $url = $site['URL'];
    if ($url) {
        date_default_timezone_set('Australia/Melbourne');
        $startTime = new \DateTime();
        $headers = get_headers($url, 1);
        $endTime = new \DateTime();

        $website->SiteUrl = $url;
        $website->MonitorHttpCode = $httpcode;
        $website->MonitorResponseBody = json_encode($headers);
        $response = $website->create();
        echo "<h1>" .$url. "<span style='font-size: 0.8em'>" .$httpcode. "</span></h1>";
        echo "<hr />";
    }
}