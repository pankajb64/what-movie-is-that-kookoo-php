<?php
// execute query
// get list of 15 most popular music releases
// retrieve result as SimpleXML object
$xml = simplexml_load_file('http://query.yahooapis.com/v1/public/yql?q=select * from rss where url="http://xml.education.yahoo.com/rss/wotd/"');
var_dump($xml);
// iterate over query result set
$results = $xml->results;
echo "<response>";
foreach ($results->item as $r) {
//var_dump($r);
$title=explode("-",$r->title);
  echo "<playtext>".$title[0]."</playtext><playtext>".$r->description."</playtext>";
}  
echo "</response>";
?>
