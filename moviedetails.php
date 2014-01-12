<?php

require_once('tmdbapiphp/TMDb.php');

function getMovieDetails($movieName)
{
	$TMDB_API_KEY = "fd647de66606c5c7e5243182b9190099"; //"c2c73ebd1e25cbc29cf61158c04ad78a";
	
	$tmdb = new TMDb($TMDB_API_KEY);
	$result = $tmdb->searchMovie($movieName);
	
	$text = "";
	if (! empty($result) )
	{
		
		if ( !empty($result["results"])) 
		{
			
			$movie = $result["results"][0];
			$name = $movie["title"];
			$rating = $movie["vote_average"];
			$url = "www.themoviedb.org/movie/".$movie["id"];
			$released = $movie["release_date"];
			//$certification = $movie->certification;
			
			$text = ''.$name.' Rating - '.$rating.' Released - '.$released.' '.$url;
			return $text;
		}
		//else
		//print_r( $result);
	}
	
	$text = "";
	return $text;
}

//echo getMovieDetails("Stuart Little");
?>