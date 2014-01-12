<?php

$url = $_POST['url'];
$filename = 'File.zip';

if (isset($_POST['filename']))
	$filename = $_POST['filename'] .'.zip';

if (filter_var($url, FILTER_VALIDATE_URL) === false)
	die("Malformed Url");


// create curl request to download the file first	
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

//$outputfilename = urlencode(substr($url, 0, 10) .strtolower(substr(crypt(uniqid(rand(), true)), 0, 7)));
//file_put_contents($outputfilename, $output) or die("Error writing to File");

header('Content-type:  application/zip');
header('Content-Length: ' . strlen($output));
header("Content-Disposition: attachment; filename=\"$filename\"");
echo $output

//readfile($outputfilename);
/*
ignore_user_abort(true);
if (connection_aborted()) {
unlink($filename);
}
$unlink($filename);*/
//file_put_contents("uTorrent.exe", $output) or die("Error writing to File");
//echo "File Written Sucessfully"

/*now create curl request to create new paste
$api_dev_key = $_GET['key'];
$api_paste_private = '0';
$api_paste_expire_date='10M';
$api_paste_format = 'text';
$api_user_key = '';
$purl 				= 'http://pastebin.com/api/api_post.php';
$ch 				= curl_init($purl);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'api_option=paste&api_user_key='.$api_user_key.'&api_paste_private='.$api_paste_private.'&api_paste_name='.$filename.'&api_paste_expire_date='.$api_paste_expire_date.'&api_paste_format='.$api_paste_format.'&api_dev_key='.$api_dev_key.'&api_paste_code='.$filename.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_NOBODY, 0);

$response  			= curl_exec($ch);
echo $response;*/
?>
