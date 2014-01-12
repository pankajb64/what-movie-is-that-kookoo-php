<?php
// execute query
// get list of 15 most popular music releases
// retrieve result as SimpleXML object
if($_REQUEST['event']=="NewCall")
{
	echo "<response><collectdtmf l=8></collectdtmf></response>";
	exit;
}
else if($_REQUEST['event']=="GotDtmf")
{
$data=$_REQUEST['data'];
$lat1=substr($data,0,2);
$lat2=substr($data,2,2);
$lon1=substr($data,4,2);
$lon2=substr($data,6,2);

$lat=$lat1.".".$lat2;
$lon=$lon1.".".$lon2;
//$xml = simplexml_load_file('http://api.wunderground.com/api/808172940c84f6a3/forecast/q/17.42,78.46.xml');
$xml = simplexml_load_file('http://api.wunderground.com/api/808172940c84f6a3/forecast/q/'.$lat.','.$lon.'.xml');
//var_dump($xml);
echo "<response>";
//var_dump($xml->forecast->simpleforecast);
$days=array("Today","Tomorrow","Day after tomorrow");
$i=0;
foreach($xml->forecast->simpleforecast->forecastdays->forecastday as $forecast){
  echo "<playtext>".$days[$i].", High of </playtext><playtext>".$forecast->high->celsius." </playtext><playtext>and low of </playtext><playtext>".$forecast->low->celsius."</playtext><playtext> and conditions will be </playtext><playtext>".$forecast->conditions."</playtext>";
  $i++;
  if($i==3)
	break;
}
echo "</response>";
exit;
}
?>
