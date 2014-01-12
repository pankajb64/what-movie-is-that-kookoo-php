<?php
include 'jsondecode.php';

function speech2text($inputFileName)
{
	$url = "https://www.google.com/speech-api/v1/recognize?xjerr=1&client=speech2text&lang=en-US&maxresults=1";
	
	$content = file_get_contents($inputFileName);
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: audio/x-flac; rate=16000"));
	curl_setopt($ch, CURLOPT_POSTFIELDS, "Content=".$content);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$output = curl_exec($ch);
	curl_close($ch);
	
	return jsondecode($output);
}

//$result = speech2text("recording1.flac");
//echo $result;

?>