<?php

include("../common.php");

$g = getjson('https://spreadsheets.google.com/feeds/list/1a9zd3ThneSR7JN7-wj4uw5hBBggY9NyguFYIb4jbAc0/oqa2z0m/public/full?alt=json');
$fields = [
  'identifier' => 'gsx$identifier',
  'poll_identifier' => 'gsx$pollidentifier',
  'pollster_id' => 'gsx$pollsterid',
  'topic_id' => 'gsx$topicid',
  'open' => 'gsx$open',
  'question' => 'gsx$question'
];

// slug fields for output
$slug_fields = ['identifier','poll_identifier','pollster_id','topic_id','open'];

// filter
$filter_fields = ['identifier','poll_identifier','pollster_id','topic_id','open'];

$orows = filter($g->feed->entry,$filter_fields,$fields);

$out = select_fields($orows,$fields,$slug_fields);




header('Content-Type: application/json');
echo json_encode($out);
?>
