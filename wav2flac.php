<?php
//include 'kookoophp/response.php';

function wave2flac($r, $inputFileName) 
{
	//$x = strripos($inputFileName, "wav"); // last occurence of wav(r) in case insenstive string(i)
	//$outputFileName = substr($inputFileName, 0, $x).'flac';
	$outputFileName = getOutputFileName($inputFileName);
	$command = "./ffmpeg -i $inputFileName -acodec flac -aq 100 -ar 16000 $outputFileName";
	//echo $command;
	$result = "";
	try {
		$result = exec($command);
	}
	catch (Exception $e)
	{
		$r->addPlayText("Exception occured - ".$e->getMessage());
	}
	$r->addPlayText("Result is ".$result);
	//return $outputFileName;
}

function getOutputFileName($inputFileName)
{
	$x = strripos($inputFileName, "wav"); // last occurence of wav(r) in case insenstive string(i)
	$outputFileName = substr($inputFileName, 0, $x)."flac";
	return $outputFileName;
}
//echo wave2flac("sound.wav") or die("error");

?>