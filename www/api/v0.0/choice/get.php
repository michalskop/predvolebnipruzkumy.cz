<?php

include("../common.php");

$g = getjson('https://spreadsheets.google.com/feeds/list/1a9zd3ThneSR7JN7-wj4uw5hBBggY9NyguFYIb4jbAc0/oy50uk/public/full?alt=json');

$fields = [
  'id' => 'gsx$id',
  'name' => 'gsx$name',
  'abbreviation' => 'gsx$abbreviation',
];

// slug fields for output
$slug_fields = ['id'];

// filter
$filter_fields = ['id','abbreviation'];

$orows = filter($g->feed->entry,$filter_fields,$fields);

$out = select_fields($orows,$fields,$slug_fields);




header('Content-Type: application/json');
echo json_encode($out);
?>
