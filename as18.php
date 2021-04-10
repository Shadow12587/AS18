<?php 
/*
	filename 	: cis355api.php
	author   	: george corser
	course   	: cis355 (winter2020)
	description	: demonstrate JSON API functions
				  return number of new covid19 cases
	input    	: https://api.covid19api.com/summary
	functions   : main()
	                curl_get_contents()
*/

echo  "<a target='_blank' href='https://github.com/Shadow12587/AS18'> GITHUB REPO </a><br><br>";

main();

#-----------------------------------------------------------------------------
# FUNCTIONS
#-----------------------------------------------------------------------------
function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';
	// line below stopped working on CSIS server
	// $json_string = file_get_contents($apiCall); 
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

    for ($x = 0; $x <= 10; $x++) {
        array_push($arr3, $arr1[$x]); 
    }

    json_encode($arr3);

    //Code Gotten from: https://www.w3schools.com/js/tryit.asp?filename=tryjson_php_db_loop
    echo '<script>
    var obj, dbParam, xmlhttp, myObj, x, txt = "";
    obj = { "limit":10 };
    dbParam = JSON.stringify(obj);
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        myObj = JSON.parse(this.responseText);
        for (x in myObj) {
        txt += myObj[x].name + "<br>";
        }
        document.getElementById("demo").innerHTML = txt;
    }
    };
    var api = "https://api.covid19api.com/summary";
    xmlhttp.open("GET", api, true);
    xmlhttp.send();
    </script> ';
	

}


#-----------------------------------------------------------------------------
// read data from a URL into a string
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
?>