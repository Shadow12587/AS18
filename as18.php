<?php 

function main () {
    $apiCall = 'https://api.covid19api.com/summary';
	$json_string = curl_get_contents($apiCall);
	$obj = json_decode($json_string);

	$arr1 = Array();
    $arr2 = Array();
    $arr3 = Array();
    
    foreach($obj->Countries as $i) {
        array_push($arr1, $i->Country);
        array_push($arr2, $i->TotalDeaths);
    } 

    array_multisort($arr2, SORT_DESC, $arr1);

    for ($x = 0; $x < 10; $x++) {
        array_push($arr3, Array($arr1[$x], $arr2[$x])); 
    }

    header('Content-type: application/json');
    echo json_encode($arr3);
    
}

function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

main();

?> 
