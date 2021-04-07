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

echo  "<a target='_blank' href='https://github.com/Shadow12587/AS18'> GITHUB REPO </a>";

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
	$data = $obj->Countries->TotalDeaths;
    rsort($data);

	// echo html head section
	echo '<html>';
	echo '<head>';
	echo '	<link rel="icon" href="img/cardinal_logo.png" type="image/png" />';
	echo '</head>';
	
	// open html body section
	echo '<body onload="loadDoc()">';
	
	echo '<div>';
	$myObjString = '{"newCases1":' . $data . '}' ;
	echo $myObjString;
	echo '</div>';
	
	echo '<div>';
	$myArray = array("newCases2"=>$data) ;
	// $myArray = array("newCases2"=>array("A"=>1, "B"=>2)) ;
	echo json_encode($myArray);
	echo '</div>';
	
	echo '<div id="demo">';
	echo '</div>';
	echo '<script>';
	echo '
		var country_usa;
		function loadDoc() {
		  var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			  country_usa = JSON.parse(this.responseText).Global.NewConfirmed;
			  document.getElementById("demo").innerHTML = country_usa;
			 
			}
		  };
		  var api = "https://api.covid19api.com/summary";
		  xhttp.open("GET", api, true);
		  xhttp.send();
		}
	';
	echo '</script>';
	
	// close html body section
	echo '</body>';
	echo '</html>';
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