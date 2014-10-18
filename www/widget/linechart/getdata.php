<?php

include("../../../www/settings.php");

$url = 
$api_path . "data/get.php?since=1900-01-01&topic_id=model-psp&pollster_id=cvvm";

$raw = json_decode(file_get_contents($url));
$colors = json_decode(file_get_contents("../../js/colors.json"));

usort($raw, "cmp");

$out = [];
$out_ar = [];
foreach ($raw as $row) {
  $out_ar[$row->choice_id]['name'] = $row->choice_id;
  if (!(isset($out_ar[$row->choice_id]['values'])))
    $out_ar[$row->choice_id]['values'] = [];
  $out_ar[$row->choice_id]['values'][] = ["x"=> $row->end_date, "y" =>$row->value, "n" => intval($row->n)];
  $name = $row->choice_id;
  if (isset($colors->$name))
    $out_ar[$row->choice_id]['properties']['fill'] = $colors->$name;
  else
    $out_ar[$row->choice_id]['properties']['fill'] = '#888';
};
foreach ($out_ar as $row) {
  $out[] = $row;
}

header('Content-Type: application/json');
echo json_encode($out);



function cmp($a, $b)
{
    return strcmp($a->end_date, $b->end_date);
}


?>
