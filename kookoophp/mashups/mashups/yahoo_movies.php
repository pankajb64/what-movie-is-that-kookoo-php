<?php

$json_o=json_decode(file_get_contents("http://api.rottentomatoes.com/api/public/v1.0/lists/movies/box_office.json?limit=5&country=in&apikey=wfrddvu4fx5bvr4cgt883x6g"));
//var_dump($json_o);
echo "<response>";
foreach($json_o->movies as $movie)
{
echo "<playtext>".$movie->critics_consensus."</playtext>";
}
echo "</response>";
?>
