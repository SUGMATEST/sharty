<?php

function proxycheck_function($Visitor_IP)
{
  
  $redis = new Redis();
  $redis->connect('127.0.0.1', 6379);
  // ------------------------------
  // SETTINGS
  // ------------------------------

  $API_Key = "067599-765483-2090uo-3551w1"; // Supply your API key between the quotes if you have one
  $VPN = "1"; // Change this to 1 if you wish to perform VPN Checks on your visitors
  $TLS = "0"; // Change this to 1 to enable transport security, TLS is much slower though!
  $TAG = "1"; // Change this to 1 to enable tagging of your queries (will show within your dashboard)
  $Custom_Tag = ""; // Example: $Custom_Tag = "My Forum Signup Page";

  // ------------------------------
  // END OF SETTINGS
  // ------------------------------


  // Setup the correct querying string for the transport security selected.
  $Transport_Type_String = $TLS == 1 ? "https://" : "http://";

  // By default the tag used is your querying domain and the webpage being accessed
  // However you can supply your own descriptive tag or disable tagging altogether above.
  $Post_Field = "";
  if ($TAG == 1) {
    $Post_Field = "tag=" . ($Custom_Tag != "" ? $Custom_Tag : $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
  }

  // Performing the API query to proxycheck.io/v2/ using cURL
  $ch = curl_init($Transport_Type_String . 'proxycheck.io/v2/' . $Visitor_IP . '?key=' . $API_Key . '&vpn=' . $VPN);

  $curl_options = array(
    CURLOPT_CONNECTTIMEOUT => 30,
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $Post_Field,
    CURLOPT_RETURNTRANSFER => true
  );

  curl_setopt_array($ch, $curl_options);
  $API_JSON_Result = curl_exec($ch);
  curl_close($ch);

  // Decode the JSON from our API
  $Decoded_JSON = json_decode($API_JSON_Result);
  //if status != ok
  if ($Decoded_JSON->status != "ok" && $Decoded_JSON->status != "warning") {
    error_log('Issue with Proxycheck: ' . str_replace("\n", '', $API_JSON_Result));
    return 2;
  }

  // Check if the IP we're testing is a proxy server
  if (isset($Decoded_JSON->$Visitor_IP->proxy) && $Decoded_JSON->$Visitor_IP->proxy == "yes") {
    // A proxy has been detected.
    error_log('Proxycheck blocked ' . $Visitor_IP);
    return 1;
  } else {
    //Check the type.
    if (isset($Decoded_JSON->$Visitor_IP->type)) {
      $typeWhitelist = array('Residential', 'Wireless', 'Business');
      
      if (!in_array($Decoded_JSON->$Visitor_IP->type, $typeWhitelist)) {
        // A VPN has been detected.
        error_log('Proxycheck blocked ' . $Visitor_IP);
        return 1;
      }

    }
    // No proxy has been detected.
    return 0;
  }
}

function ipintel_function($Visitor_IP)
{

  $redis = new Redis();
  $redis->connect('127.0.0.1', 6379);
  /*Expected Input
  The proxy check system takes in an input via HTTP GET request. The URL is http://check.getipintel.net/check.php and the parameter is ip . The system fully supports IPv4 with partial support for IPv6.

  Include Your Contact Information
  Include your contact information so I can notify you if a problem arise or if there are core changes. In some situations, people query the system in a wrong manner and assume everything is working (but due to the lack of or improper handling of error codes), it's not the case. Since I only have the connecting IP address, I cannot help the person correct the error.
  To include your contact information, add another parameter to your request called contact and provide your email.

  A typical query looks like:
  http://check.getipintel.net/check.php?ip=IPHere&contact=YourEmailAddressHere


  Do not use URL encoding on the input parameters.

  All queries that do not contain accurate contact information will be rejected with an error or it'll be dropped by the firewall.

  Start with flags=m option if only proxy / VPN detection is needed. If flags=m does not have a noticeable impact, then use flags=b. The default query (no flags) is mostly used infront of a payment gateway to protect against fraud because bad IP detection is included.
  If you are contacted, please respond in 2 days or the contact information could be considered as inaccurate. Your information will only be used for the purpose of communication with GetIPIntel.


  Optional settings for Input

      flags=m is used when you're only looking for the value of "1" as the result. The m flag skips the dynamic checks and only uses dynamic ban lists. See Variations of Implementation and What are dynamic checks? for detailed explanation.
      flags=b is used when you want to use dynamic ban and dynamic checks with partial bad IP check. See Variations of Implementation for detailed explanation.
      flags=f is used when you want to force the system to do a full lookup, which can take up to 5 seconds. See Variations of Implementation for detailed explanation.
      flags=n is used to exclude real time block list. Append the character "n" if you're already using flags=m, b, or f. For example, flags=nm.
      oflags=b is used when you want to see if the IP is considered as bad IP. Note that when using flags option, this result can vary due to the included datasets. Please see the comparsion table for more information.
      oflags=c is used when you want to see which country the IP came from / which country the IP belongs to (GeoIP Location). Currently in alpha testing.
      oflags=i is used when you want to exclude iCloud Relay Egress IPs, Google Cloud One VPN, or some other similiar service. They are by definition a proxy/VPN IP, however, having this additional data may help you make a more informed decision.
      oflags=a is used when you want to see the ASN number of the IP.
      format=json returns the result in JSON format with extra information.
  */
//  $email = $redis->get('getIPIntelEmail');
  $email = 'soyjakst@outlook.com';
  $ch = curl_init("https://check.getipintel.net/check.php?ip=" . $Visitor_IP . "&contact=" . $email . "&flags=f");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  curl_close($ch);

  if (!is_numeric($result)) {
    error_log('Issue with GetIPIntel: ' . str_replace("\n", '', $result));
    return 2;
  }

  /*result is now a float from 0-1*/
  if ($result > 0.95) {
    error_log('GetIPIntel blocked ' . $Visitor_IP . ' - Response: ' . $result);
    return 1;
  } else if ($result < 0) {
    error_log('Issue with GetIPIntel: ' . str_replace("\n", '', $result));

    /*
    if ($result == -5) {
      $email = strtolower(bin2hex(random_bytes(8))) . '@gmail.com';
      $redis->set('getIPIntelEmail', $email);
    }
    */

    return 2;
  } else {
    return 0;
  }

}

function tordnsel_function($ip)
{
  $hostname = implode('.', array_reverse(explode('.', $ip))) . '.dnsel.torproject.org.';
  $isTor = checkdnsrr($hostname, 'A');

  if ($isTor === true) {
    error_log('TorDNSEL blocked ' . $ip);
    return 1;
  } else {
    return 0;
  }
}

function bgptools_function($ip) {
	function ip_to_asn($ip) {
		$fp = fsockopen('bgp.tools', 43, $errno, $errstr, 2);

		fwrite($fp, "begin\r\n".$ip."\r\n"."end\r\n");

		$resp = '';
		while (!feof($fp)) {
			$resp .= fread($fp, 1024);
		}

		fclose($fp);

		preg_match('/^\d+/', $resp, $asn);
		return 'AS' . $asn[0];
	}

	try {
		$asn = ip_to_asn($ip);

		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);

		if (!$asn_blacklist = $redis->get('asnBlacklist')) {
			$ua = 'balrog bgp.tools - balrog@goatse.email';

			$ch = curl_init('https://bgp.tools/tags/vpn.txt');
			curl_setopt($ch, CURLOPT_USERAGENT, $ua);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);

			$vpn_list = explode("\n", $result);

			$ch = curl_init('https://bgp.tools/tags/vpsh.txt');
			curl_setopt($ch, CURLOPT_USERAGENT, $ua);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);

			$vps_list = explode("\n", $result);

			$asn_blacklist = array_merge($vpn_list, $vps_list);
			$asn_blacklist = array_unique($asn_blacklist);

			$ch = curl_init('https://bgp.tools/tags/dsl.txt');
			curl_setopt($ch, CURLOPT_USERAGENT, $ua);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);

			$resi_list = explode("\n", $result);
			$asn_blacklist = array_diff($asn_blacklist, $resi_list);

			$ch = curl_init('https://bgp.tools/tags/mobile.txt');
			curl_setopt($ch, CURLOPT_USERAGENT, $ua);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);

			$mobile_list = explode("\n", $result);
			$asn_blacklist = array_diff($asn_blacklist, $mobile_list);

			$ch = curl_init('https://bgp.tools/tags/uni.txt');
			curl_setopt($ch, CURLOPT_USERAGENT, $ua);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);

			$school_list = explode("\n", $result);
			$asn_blacklist = array_diff($asn_blacklist, $school_list);

			$redis->set('asnBlacklist', implode(",", $asn_blacklist), 24*60*60);
		}
		else {
			$asn_blacklist = explode(",", $asn_blacklist);
		}

		if (in_array($asn, $asn_blacklist)) {
			error_log('bgp.tools blocked ' . $ip . ' - ASN: ' . $asn);
			return 1;
		}
		else {
			return 0;
		}
	}
	catch (Throwable $e) {
		error_log('Issue with bgp.tools: ' . $e->getMessage());
		return 2;
	}
}


function vpn_check($ip, $returnNoCache = false)
{

  // Create a new Redis instance
  $redis = new Redis();
  $redis->connect('127.0.0.1', 6379);

  $cached_result = $redis->get($ip);
  if ($cached_result) {
    // Result is cached, return the value
    return $cached_result === 'true';
  } else {
    if ($returnNoCache)
      return false;

    //OR
    /*
    $result = proxycheck_function($ip);
    $result2 = ipintel_function($ip);
    $result3 = tordnsel_function($ip);

    if ($result == 1 || $result2 == 1 || $result3 == 1)
      $redis->set($ip, 'true');
    else if ($result == 0 && $result2 == 0 && $result3 == 0)
      $redis->set($ip, 'false');

    if ($result == 1 || $result2 == 1 || $result3 == 1) {
      return true;
    } else {
      return false;
    }
    */

    // Only run checks if the previous check returned negative in an attempt to reduce calls to rate limited services
    $proxycheck = 0;
    $ipintel = 0;
    $bgptools = 0;

    $tordnsel = tordnsel_function($ip);
    if ($tordnsel !== 1) {

      $bgptools = bgptools_function($ip);
      if ($bgptools !== 1) {

        $proxycheck = proxycheck_function($ip);
        if ($proxycheck !== 1) {

//          $ipintel = ipintel_function($ip);
        }
      }
    }

    if ($tordnsel === 1 || $bgptools === 1 || $proxycheck === 1 || $ipintel === 1)
      $redis->set($ip, 'true', 30*24*60*90);
    else if ($tordnsel === 0 && $bgptools === 0 || $proxycheck === 0 && $ipintel === 0)
      $redis->set($ip, 'false', 30*24*60*90);
    else
      $redis->set($ip, 'false', 24*60*60);

    if ($tordnsel === 1 || $bgptools === 1 || $proxycheck === 1 || $ipintel === 1) {
      return true;
    } else {
      return false;
    }
  }



}

?>
