<?php
include 'crawler.php';

// $curl = curl_init();
// curl_setopt_array($curl, array(
//     CURLOPT_URL => ,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_TIMEOUT => 30,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "GET",
//     CURLOPT_HTTPHEADER => array(
//         "cache-control: no-cache"
//     ),
// ));

// $response = curl_exec($curl);
// $err = curl_error($curl);
// curl_close($curl);
$response = crawler::http_request("https://api.woolston.com.au/crm/v1/customers");
$data = json_decode($response, true);

foreach($data['data'] as $website) {
    $url = $website['URL'];
    if ($url) {
        // $site_data  = crawler::http_request($url);
        // $links = crawler::extract_elements('a', $site_data);
        // if ( count($links) > 0 ) {
        //file_put_contents('links.json', json_encode($links, JSON_PRETTY_PRINT));
        //print_r(json_encode($links, JSON_PRETTY_PRINT));
        // }
        date_default_timezone_set('Australia/Melbourne');
        $startTime = new DateTime();
        $headers = get_headers($url, 1);
        $endTime = new DateTime();
        echo "<h1>" .$url. "</h1>";
        // echo "<ul>";
        echo "<li>Time taken: " .(($endTime->getTimestamp() - $startTime->getTimestamp())*1000). " millisecs</li>";
        echo "<li>" .json_encode($headers). "</li>";
        // echo "<li>" .json_encode($links, JSON_PRETTY_PRINT). "</li>";
        //echo "<li>" .json_encode(urlExists($url), true). "</li>";
        // echo "</ul>";
        echo "<hr />";
    }
}

function urlExists($url=NULL)  
{  
    if($url == NULL) return false;  
    $ch = curl_init($url);  
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    $data = curl_exec($ch);  
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
    $data = curl_getinfo($ch);
    curl_close($ch);  
    if($httpcode>=200 && $httpcode<300){  
        return $data;
    } else {  
        return false;  
    }  
} 
?>