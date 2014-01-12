<?php

require_once 'kookoophp/response.php';
include 'resources.php';

session_start();

$r = new Response();

$r->setFiller("yes");

if ($_REQUEST['event'] == "NewCall")
{
	$_SESSION['sid'] = $_REQUEST['sid'];
	$_SESSION['mobileNumber'] = $_REQUEST['cid'];
	$r->addPlayText($resources["WELCOME_VOICE"]);
	$_SESSION['state'] = "PreRecord";
}


if($_REQUEST['event'] == "Record" && $_SESSION['state'] == "Recording" )
{
	
	$data = $_REQUEST['data'];
	
	$fileName = getFileName($data);

	include 'savefile.php';
	try
	{
		saveFile($data, $fileName);
	}
	catch(Exception $e)
	{
		$r->addPlayText("Could not save the file. ".$e->getMessage());
	}
	
	include'wav2flac.php';
	wave2flac($r, $fileName);
	
	$outputFileName = getOutputFileName($fileName);
	
	include 'speech2text.php';
	$text = speech2text($outputFileName);
	$smsText = "";
	
	if (empty($text))
	{
		$r->addPlayText($resources["RECORD_FAILURE_VOICE"]);
		$r->addPlayText("The file name is ".$fileName);
		
		/*if(function_exists('exec')) {
			$r->addPlayText("exec is enabled");
		}*/
		
		$dirname = dirname(__FILE__);
		$path = $dirname."/".$fileName;
		
		if(file_exists($path))
			$r->addPlayText("Yes, The File exists");
		else
			$r->addPlayText("Sorry, The File does not exist");
	}
	else
	{
		
		$r->addPlayText($resources["RECORDED_VOICE"]);
		$r->addPlayText($text);
		
		include 'moviedetails.php';
		$smsText = getMovieDetails($text);
		
		if(empty($smsText))
			$r->addPlayText($resources["MOVIE_RECOGNITION_FAILURE_VOICE"]);
		else
		{
			
			$r->addPlayText($resources["SMS_VOICE"]);
			$r->sendSms(substr($smsText, 0, 100), $_SESSION['mobileNumber']);	
		}
	}
	
	$_SESSION['state'] = "Awaiting Input";
	$cd = prepareDtmf();
	$r->addCollectDtmf($cd);
	//echo $r->getXML();
	//echo "xml";
	$r->send();
	
}

if($_REQUEST['event'] == "GotDTMF" && $_SESSION['state'] == "Awaiting Input")
{
	$data = $_REQUEST['data'];
	
	if (!empty($data))
	{
		if ($data == "1")
			$_SESSION['state'] = "PreRecord";
		
		else if($data == "2")
		{
			$_SESSION['state'] = "Termination";
			$r->addPlayText($resources["THANKS_VOICE"]);
			$r->addPlayText($resources["GOODBYE_VOICE"]);
			$r->addHangup();
			$r->send();
		}
		else
		{
			$cd = prepareDtmf();
			$r->addCollectDtmf($cd);
			$r->send();
		}
	}
	else
	{
		$cd = prepareDtmf();
		$r->addCollectDtmf($cd);
		$r->send();
	}
}

if($_SESSION['state'] == "PreRecord")
{
	$r->addPlayText($resources["APP_INTRO_VOICE"]);
	$r->addPlayText($resources["RECORD_VOICE"]);
	$r->addRecord("movieName");
	$_SESSION['state'] = "Recording";
	$r->send();
}

function prepareDtmf()
{
	include 'resources.php';
	$cd = new CollectDtmf();

	$cd->setMaxDigits("1");
	$cd->setTimeOut("5000");	//5 seconds
	$cd->addPlayText($resources["AWAIT_INPUT_ONE_VOICE"]);
	$cd->addPlayText($resources["AWAIT_INPUT_TWO_VOICE"]);
	
	return $cd;
}

function getFileName($url)
{
	$index = strrpos($url, "/");
	$name = substr($url, $index + 1);
	return $name;
}
/*
$number = "$number";
	$text =  "";
	for($i=0;$i<strlen($number);$i++) 
	{ 
		$text = $text."$number[$i] "; 
	}
	//echo $text;
	$r->addPlayText($text);*/
//echo getFileName("http://www.google.com/dhoni/kohli/sound.wav");

?>