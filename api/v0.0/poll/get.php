<?php

include("../common.php");

$g = getjson('https://spreadsheets.google.com/feeds/list/1a9zd3ThneSR7JN7-wj4uw5hBBggY9NyguFYIb4jbAc0/o9g2mo8/public/full?alt=json');
$fields = [
  'identifier' => 'gsx$identifier',
  'pollster_id' => 'gsx$pollsterid',
  'link' => 'gsx$link',
  'start_date' => 'gsx$startdate',
  'end_date' => 'gsx$enddate',
  'published_date' => 'gsx$publisheddate',
  'population' => 'gsx$population',
  'sponsor' => 'gsx$sponsor',
  'method' => 'gsx$method',
  'n' => 'gsx$n',
  'area' => 'gsx$area',
];

// slug fields for output
$slug_fields = ['identifier','pollster_id'];

// filter
$filter_fields = [
  'pollster_id','identifier'
];

$orows = filter($g->feed->entry,$filter_fields,$fields);
$orows = time_filter($orows);

$out = select_fields($orows,$fields,$slug_fields);




header('Content-Type: application/json');
echo json_encode($out);
?>
