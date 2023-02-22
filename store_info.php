<?php
	// Get the user's IP address
	$ip_address = $_SERVER['REMOTE_ADDR'];

	// Get the user's ISP and location using an API
	$ip_api_url = "http://ip-api.com/json/$ip_address";
	$ip_api_data = file_get_contents($ip_api_url);
	$ip_api_json = json_decode($ip_api_data);
	$isp = $ip_api_json->isp;
	$city = $ip_api_json->city;
	$region = $ip_api_json->regionName;
	$country = $ip_api_json->country;

	// Get the user's operating system and browser
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$os = "Unknown";
	$browser = "Unknown";
	if (preg_match('/Windows NT 10.0/i', $user_agent)) {
	    $os = "Windows 10";
	} elseif (preg_match('/Windows NT 6.3/i', $user_agent)) {
	    $os = "Windows 8.1";
	} elseif (preg_match('/Windows NT 6.2/i', $user_agent)) {
	    $os = "Windows 8";
	} elseif (preg_match('/Windows NT 6.1/i', $user_agent)) {
	    $os = "Windows 7";
	} elseif (preg_match('/Windows NT 6.0/i', $user_agent)) {
	    $os = "Windows Vista";
	} elseif (preg_match('/Windows NT 5.1/i', $user_agent)) {
	    $os = "Windows XP";
	} elseif (preg_match('/Macintosh/i', $user_agent)) {
	    $os = "Mac OS X";
	} elseif (preg_match('/Linux/i', $user_agent)) {
	    $os = "Linux";
	}

	if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
	    $browser = "Internet Explorer";
	} elseif (preg_match('/Firefox/i', $user_agent)) {
	    $browser = "Mozilla Firefox";
	} elseif (preg_match('/Chrome/i', $user_agent)) {
	    $browser = "Google Chrome";
	} elseif (preg_match('/Safari/i', $user_agent)) {
	    $browser = "Apple Safari";
	} elseif (preg_match('/Opera/i', $user_agent)) {
	    $browser = "Opera";
	} elseif (preg_match('/Netscape/i', $user_agent)) {
	    $browser = "Netscape";
	}

	// Store the information in a file on the server
	$file = 'storage/info.txt';
	$current = file_get_contents($file);
	$current .= "IP Address: $ip_address\n";
	$current .= "ISP: $isp\n";
	$current .= "City: $city\n";
	$current .= "Region: $region\n";
	$current .= "Country: $country\n";
	$current .= "Operating System: $os\n";
	$current .= "Browser: $browser\n";
	$current .= "Date and Time: " . date("Y-m-d H:i:s") . "\n";
	$current .= "\n";
	file_put_contents($file, $current);

	// Return the information to the JavaScript function
	echo "IP Address: $ip_address<br>";
	echo "ISP: $isp<br>";
	echo "City: $city<br>";
	echo "Region: $region<br>";
	echo "Country: $country<br>";
	echo "Operating System: $os<br>";
	echo "Browser: $browser<br>";
	echo
?>
