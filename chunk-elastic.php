<?php

// Parse a JSONL file line-by-line, clean, and chunk

require_once(dirname(__FILE__) . '/elastic/elastic.php');

/*

curl http://130.209.46.63/_bulk -XPOST --data-binary '@ala-10000.json'  --progress-bar | tee /dev/null

*/

$filename = 'ala.jsonl';
$basename = 'ala';

$count = 0;
$total = 0;

$chunksize = 20000;

$rows = array();

$done = false;

$file_handle = fopen($filename, "r");
while (!feof($file_handle) && !$done) 
{

	$jsonl = fgets($file_handle);
	
	if ($jsonl != '')
	{	
		$doc = json_decode($jsonl);
		unset($doc->type);
		
		// Action
		$meta = new stdclass;
		$meta->index = new stdclass;
		$meta->index->_index = 'ala';	
		$meta->index->_id = $doc->id;
		
		// v. 6		
		$meta->index->_type = '_doc';
		
		// Earlier versions
		//$meta->index->_type = 'thing';
		
		// Request
		$doc->search_result_data->id = 'https://bie.ala.org.au/species/' . $doc->id;
				
		$rows[] = json_encode($meta);
		$rows[] = json_encode($doc);
	}

	$count++;	
	$total++;
	
	if ($count % $chunksize == 0)
	{
		$output_filename = $basename . '-' . $total . '.json';
		
		$chunk_files[] = $output_filename;
		
		file_put_contents($output_filename, join("\n", $rows)  . "\n");
		
		$count = 0;
		$rows = array();
		
		/*
		if ($total > 200000)
		{
			$done = true;
		}
		*/
	}
	
	
}

// Left over?
if (count($rows) > 0)
{
	$output_filename = $basename . '-' . $total . '.json';
	
	$chunk_files[] = $output_filename;
	
	file_put_contents($output_filename, join("\n", $rows)  . "\n");
}

echo "--- curl upload.sh ---\n";
$curl = "#!/bin/sh\n\n";
foreach ($chunk_files as $filename)
{
	$curl .= "echo '$filename'\n";
	
	$url = 'http://130.209.46.63/_bulk';	

	$url = 'http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk';
	
	// old
	//$curl .= "curl $url -XPOST --data-binary '@$filename'  --progress-bar | tee /dev/null\n";
	
	// 6
	$curl .= "curl $url -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@$filename'  --progress-bar | tee /dev/null\n";

	$curl .= "echo ''\n";
}

file_put_contents(dirname(__FILE__) . '/upload-elastic.sh', $curl);


	
?>	

