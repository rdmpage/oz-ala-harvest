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
'184ab7f2-a26d-4e33-85c6-653e678844d9'
);


$filename = 'guids.txt';

$file_handle = fopen($filename, "r");
while (!feof($file_handle)) 
{
	$row = trim(fgets($file_handle));
	list($guid, $nameComplete) = explode("\t", $row);

	$id = 'urn:lsid:biodiversity.org.au:afd.taxon:' . $guid;
		
	$exists = $couch->exists($id);
	
	if ($exists)
	{
		echo "-- $guid exists\n";
	}
	else
	{
		echo "-- $guid not found\n";
				
		// Get guid in local ALA from name
		$resp = $couch->send("GET", "/" . $config['couchdb_options']['database'] . "/_design/taxa/_view/nameComplete?key=" . urlencode('"' . $nameComplete. '"') . '&reduce=false' );
		
		$obj = json_decode($resp);
		if (count($obj->rows) == 1)
		{
			foreach ($obj->rows as $row)
			{
				$row->key . "\n";
				
				if (preg_match('/urn:lsid:biodiversity.org.au:afd.taxon:/', $row->id))
				{				
					echo 'UPDATE afd SET taxon_guid_ala="' . str_replace('urn:lsid:biodiversity.org.au:afd.taxon:', '', $row->id) . '" WHERE TAXON_GUID="' . $guid . '";' . "\n";
				}
			}
		}
		else
		{
			echo "-- No match $nameComplete\n";
		}
		
		
		
	}

}




?>
