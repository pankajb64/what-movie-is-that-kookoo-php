


<?php
session_start();
require_once("response.php");
//require_once("SetKooKoo.php");

$r=new Response();
  $BASE_URL = "https://query.yahooapis.com/v1/public/yql";

  $events = "";
  $r=new Response();


 
     
    // Form YQL query and build URI to YQL Web service
    $current_url = "http://rss.news.yahoo.com/rss/topstories";
    $yql_query = "select * from rss where url='$current_url'";
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";

    // Make call with cURL
    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    $json = curl_exec($session);
    // Convert JSON to PHP object 
    $phpObj =  json_decode($json);

    // Confirm that results were returned before parsing
    if($_REQUEST['event']=="NewCall")
{       $r->addPlayText("hello   welcome to kookoo and you are listening to yahoo news.");
    if(!is_null($phpObj->query->results)){
      // Parse results and extract data to display
      foreach($phpObj->query->results->item as $item){
        $events =   $item->title;
           $events .="\n";
           $r->addPlayText($events);
           
           $r->addPlayText(".");
  
        //$events .= $item->description;
                //$events .="</p>";
        //$events .="</p><br/>$Result->Address<br/>";
        //$events .="$Result->AverageRating";
        //$events .="$Result->City, $Result->State,$Result->Phone";
       // $events .="<p><a href=$item->link</a></p></div>";  
 }
    }
    // No results were returned
    if(empty($events)){
      $events = "Sorry no news found ";
      $r->addPlayText($events);
    }
    // Display results and unset the global array $_GET
    $r->addHangup();

 }  

$r->send();
//echo $events;
    //unset($_GET);
  
?>

