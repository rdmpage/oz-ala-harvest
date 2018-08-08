<?php

// Parse a JSONL file line-by-line and upload to Elasticsearch

require_once(dirname(__FILE__) . '/elastic/elastic.php');

$filename = 'ala.jsonl';

$file_handle = fopen($filename, "r");
while (!feof($file_handle)) 
{
	$jsonl = fgets($file_handle);
	
	if ($jsonl != '')
	{	
		$doc = json_decode($jsonl);
		
		unset($doc->type);
		$doc->search_result_data->id = 'https://bie.ala.org.au/species/' . $doc->id;
	
		echo json_encode($doc, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		
		$id = $doc->id;
		
		$elastic_doc = new stdclass;
		$elastic_doc->doc = $doc;
		$elastic_doc->doc_as_upsert = true;

		//print_r($elastic_doc);
		
		$doc_type = '_doc';
		
		// Earlier versions
		$doc_type = 'thing';

		// PUT for first time, POST for update
		$elastic->send('PUT', $doc_type . '/' . urlencode($id), json_encode($elastic_doc));				
		//$elastic->send('POST',  $doc_type . '/' . urlencode($id) . '/_update', json_encode($elastic_doc));	
		
	}
	
}

	
?>	
