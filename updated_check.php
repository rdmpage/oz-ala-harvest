<?php

// Get updated AFD taxon GUID

error_reporting(E_ALL);

require_once(dirname(__FILE__) . '/couchsimple.php');


//----------------------------------------------------------------------------------------
function get_redirect($url)
{	
	$redirect = '';
	
	$ch = curl_init(); 
	curl_setopt ($ch, CURLOPT_URL, $url); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION,  0); 
	curl_setopt ($ch, CURLOPT_HEADER,		  1);  
	
	// timeout (seconds)
	curl_setopt ($ch, CURLOPT_TIMEOUT, 240);

			
	$curl_result = curl_exec ($ch); 
	
	if (curl_errno ($ch) != 0 )
	{
		echo "CURL error: ", curl_errno ($ch), " ", curl_error($ch);
	}
	else
	{
		$info = curl_getinfo($ch);
		
		//print_r($info);		
		 
		$header = substr($curl_result, 0, $info['header_size']);
				
		$http_code = $info['http_code'];
		
		if ($http_code == 303)
		{
			$redirect = $info['redirect_url'];
		}
		
		if ($http_code == 302)
		{
			$redirect = $info['redirect_url'];
		}
		
	}
	
	$redirect = preg_replace('/;jsessionid=.*$/', '', $redirect);
	
	
	return $redirect;
}


//----------------------------------------------------------------------------------------
function get($url)
{
	$opts = array(
	  CURLOPT_URL =>$url,
	  CURLINFO_CONTENT_TYPE => "application/csv",
	  CURLOPT_FOLLOWLOCATION => TRUE,
	  CURLOPT_RETURNTRANSFER => TRUE
	);

	$ch = curl_init();
	curl_setopt_array($ch, $opts);
	$data = curl_exec($ch);
	$info = curl_getinfo($ch); 
	curl_close($ch);
	
	return $data;
}


// Taxa to check
$guids = array(
//'184ab7f2-a26d-4e33-85c6-653e678844d9'
'bebc6ca8-afc0-4d02-bda2-24e7b1be9171'
);


foreach ($guids as $guid)
{
	$url = 'https://biodiversity.org.au/afd/taxa/' . $guid;

	$redirect = get_redirect($url);

	if ($redirect == '')
	{
		echo "$guid OK\n";	
	}
	{
		$redirect_uuid = str_replace('http://biodiversity.org.au/afd/taxa/', '', $redirect);
		echo "Redirect $redirect_uuid\n";

		$redirect_uri = 'urn:lsid:biodiversity.org.au:afd.taxon:' . $redirect_uuid;
		
		echo "$redirect_uri\n";
	
		$exists = $couch->exists($redirect_uri);
		
		if ($exists)
		{
			echo "$guid\t$redirect_uuid\n";
		}
	}
}




?>
