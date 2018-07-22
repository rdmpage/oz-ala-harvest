<?php

error_reporting(E_ALL);

require_once('couchsimple.php');

$count = 0;


//----------------------------------------------------------------------------------------
function get($url)
{
	$data = null;
	
	$opts = array(
	  CURLOPT_URL =>$url,
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



//----------------------------------------------------------------------------------------
// stack is where we start from (e.g., list of ids or subtree root)
// if force then replacer any existing 
// if follow then drill down by getting children, otherwise just add id
function go($stack, $force = false, $follow = true)
{
	global $couch;
	global $count;
	
	while (count($stack) > 0)
	{
		$id = array_pop($stack);
	
		echo $id . "\n";
		echo "stack count=" . count($stack) . "\n";
	
		$exists = $couch->exists($id);
	
		$go = true;
		if ($exists && !$force)
		{
			echo "Have already\n";
			$go = false;
		}
	
		if ($go)
		{
			$count++;
			
			$url = 'https://bie.ala.org.au/ws/species/' . $id;
			$json = get($url);			
			if ($json)
			{
				$obj = json_decode($json);
				//$json = json_encode($obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				//file_put_contents($filename, $json);
			
				$doc = new stdclass;
				$doc->_id = $id;
				$doc->message = $obj;
			
				//print_r($doc);
	
				if (!$exists)
				{
					$couch->add_update_or_delete_document($doc, $doc->_id, 'add');	
				}
				else
				{
					if ($force)
					{
						$couch->add_update_or_delete_document($doc, $doc->_id, 'update');
					}
				}
			
				// parent(s)
			
				// children
				if ($follow)
				{
					$url = 'https://bie.ala.org.au/ws/childConcepts/' . $id;
					$json = get($url);			
					if ($json)
					{
						$obj = json_decode($json);
				
						foreach ($obj as $child)
						{
							$stack[] = $child->guid;
						}
				
					}
				}
			}
			
			// Give server a break every 10 items
			if (($count % 10) == 0)
			{
				$rand = rand(1000000, 3000000);
				echo "\n...sleeping for " . round(($rand / 1000000),2) . ' seconds' . "\n\n";
				usleep($rand);
			}
			
			
		}
	}
	
}

//----------------------------------------------------------------------------------------

// subtree crawling
if (1)
{

	// subtree
	if (1)
	{
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:c46801ab-2ff2-4e92-8445-cda82a83dd97'; // Agamidae
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:eb452bb5-728b-4dbe-a3dd-19aaf61b0307'; // HYDROPTILIDAE

		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:90d39dc7-2307-4780-a26a-b4f97afbe27a'; // ARANEOMORPHAE
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:4fb59020-e4a8-4973-adca-a4f662c4645c'; // MOLLUSCA

		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:3cbb537e-ab39-4d85-864e-76cd6b6d6572'; // ACANTHOCEPHALA
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:1f5a5c77-fcef-45b9-84ad-bfea95fd1e62'; // ANNELIDA 

		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:b0d417cf-5c4a-4a07-a8cd-846f0ed5881d'; // BRACHIOPODA 

		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:b0d417cf-5c4a-4a07-a8cd-846f0ed5881d'; // BRACHIOPODA 
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:feb008c4-8dd3-41fd-b89b-75cef4eb1b7c'; // Ucinae
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:6fc026dd-eac1-42b8-98a5-b019a7977209'; // CULICIDAE
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:a048f9e3-d664-486d-91fa-dd6d44c4844e'; // OPILIONES

		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:e22efeb4-2cb5-4250-8d71-61c48bdaa051'; // PISCES
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:ef5515fd-a0a2-4e16-b61a-0f19f8900f76'; // GNATHOSTOMATA
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:93fd3551-ca8b-44aa-9c83-e8e8e49fddd4'; // GRYLLIDAE

		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:93fd3551-ca8b-44aa-9c83-e8e8e49fddd4'; // GRYLLIDAE
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:e9e7db31-04df-41fb-bd8d-e0b0f3c332d6'; // MAMMALIA
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:5ed80139-31bb-48a8-9f57-42d8015dacbb'; // AVES
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:3f03f277-a522-42ba-93f8-6caeacd233fa'; // Cisseina
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:52b4768b-2ea5-4e91-ac38-93fa91b36cd6'; // BUPRESTIDAE
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:8edaf6f6-d5f7-45b0-ac82-ef7de21b47d9'; // MYRIAPODA
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:82bb8470-faa0-4030-9b8f-bb3af4337d5b'; // Dytiscidae
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:d0904fe4-a294-49fe-9c1d-ad753123d48c'; // SCARABAEIDAE
		
		$root = 'urn:lsid:biodiversity.org.au:afd.taxon:096aefd0-0357-4291-9e0a-0e80c1442fa7'; // ANASPIDESIDAE Ahyong, S.T. & Alonso-Zarazaga, M.A., 2017
		

		$stack = array();
		$stack[] = $root;

		// add everything rooted at a subtree
		go($stack, true, true);
	}

	if (0)
	{
		// add everything in a list, don't go down any subtrees
		// good for adding missing stuff, or lineages back to the root.

		$stack = array(
		'urn:lsid:biodiversity.org.au:afd.taxon:c46801ab-2ff2-4e92-8445-cda82a83dd97',
		'urn:lsid:biodiversity.org.au:afd.taxon:6ac03c60-d04f-43d3-a450-2dd16181f264',
		'urn:lsid:biodiversity.org.au:afd.taxon:ce3a5d30-60ec-4e53-9803-b514b88ddbca',
		'urn:lsid:biodiversity.org.au:afd.taxon:eaeda00f-6bd6-4d20-ad52-da6c428c2378',
		'urn:lsid:biodiversity.org.au:afd.taxon:682e1228-5b3c-45ff-833b-550efd40c399',
		'urn:lsid:biodiversity.org.au:afd.taxon:ef5515fd-a0a2-4e16-b61a-0f19f8900f76',
		'urn:lsid:biodiversity.org.au:afd.taxon:5d6076b1-b7c7-487f-9d61-0fea0111cc7e',
		'urn:lsid:biodiversity.org.au:afd.taxon:065f1da4-53cd-40b8-a396-80fa5c74dedd',
		'urn:lsid:biodiversity.org.au:afd.taxon:4647863b-760d-4b59-aaa1-502c8cdf8d3c'

		);

		go($stack, false, false);
	}
}

if (0)
{
	// add from file
	$filename = 'MOLLUSCA.csv';
	$filename = 'ARTHROPODA.csv';
	$filename = 'species.csv';
	$file_handle = fopen($filename, "r");

	$row_count = 0;
	$count = 1;

	while (!feof($file_handle)) 
	{
		$line = trim(fgets($file_handle));
	
		if ($line != '')
		{	
			$parts = explode(",", $line);
		
			if ($row_count++ > 1)
			{		
				$stack = array($parts[0]);
				go($stack, false, false);
			}
			
			
			
		}
	}
}			



?>
