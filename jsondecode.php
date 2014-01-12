<?php

function jsondecode($json)
{
	$data = json_decode($json);
	//echo "status = ".$data->status."\n";
	if (!empty ($data))
	{
		if( !empty ($data->hypotheses))
			return $data->hypotheses[0]->utterance;
	}
	return "";
}

$json = '{"status":0,"id":"a3fefb9621f11c853b8be298773193b5-1","hypotheses":[{"utterance":"Stuart little","confidence":0.61556125}]}';

//echo jsondecode($json);

?>