<?php

function saveFile($url, $fileName)
{
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//echo "Downloading file";
	$output = curl_exec($ch);
	curl_close($ch);
	//echo "Saving File".$fileName;
	
	file_put_contents($fileName, $output); //or die("Error writing to File");
	
	
}


?>