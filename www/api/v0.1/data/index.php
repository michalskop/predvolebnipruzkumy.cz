<?php

include("../common.php");

$g = getjson('https://spreadsheets.google.com/feeds/list/1a9zd3ThneSR7JN7-wj4uw5hBBggY9NyguFYIb4jbAc0/od6/public/full?alt=json');

$fields = [
  'question_identifier' => 'gsx$questionidentifier',
  'poll_identifier' => 'gsx$pollidentifier',
  'pollster_id' => 'gsx$pollsterid',
  'choice_id' => 'gsx$choiceid',
  'topic_id' => 'gsx$topicid',
  'value' => 'gsx$value',
];

// slug fields for output
$slug_fields = ['question_identifier','poll_identifier','pollster_id','topic_id','choice_id'];

// filter
$filter_fields = ['question_identifier','poll_identifier','pollster_id','topic_id','choice_id'];

//simple filter
$orows = filter($g->feed->entry,$filter_fields,$fields);

//select fields now, easier work later
$orows = select_fields($orows,$fields,$slug_fields);


//time filter - poll
  if (isset($_GET['since']))
    $since = trim($_GET['since']);
  else
    $since = '1000-01-01';
  if (isset($_GET['until']))
    $until = trim($_GET['until']);
  else
    $until = '5000-01-01'; 
$polls = getjson($api_path.'polls/?since='.$since.'&until='.$until);
    //reorder
$polls_ar = [];
foreach($polls as $poll) {
  $polls_ar[$poll->pollster_id][$poll->identifier] = $poll;
}
    //filter
$orows2 = [];
foreach ($orows as $orow) {
  if (isset($polls_ar[$orow['pollster_id']][$orow['poll_identifier']])) {
    //add date and n
    $orow['end_date'] = $polls_ar[$orow['pollster_id']][$orow['poll_identifier']]->end_date;
    $orow['n'] = $polls_ar[$orow['pollster_id']][$orow['poll_identifier']]->n;
    $orows2[] = $orow;}
}
//print_r($orow2);


//topic filter - topic, question
/*if (isset($_GET['topic_id'])) {
  $topic_id = trim($_GET['topic_id']);
  $questions = getjson($api_path.'questions/?topic_id='.$topic_id);
  //reorder
  $questions_ar = [];
  foreach($questions as $question) {
    $questions_ar[$question->pollster_id][$question->poll_identifier][$question->identifier] = $poll;
  }
  //filter
  foreach ($orows2 as $orow) {
    if (isset($questions_ar[$orow['pollster_id']][$orow['poll_identifier']][$orow['question_identifier']]))
      $orows3[] = $orow;
  }
  $orows2 = $orows3;
}*/

//correct %
foreach ($orows2 as $key => $orow) {
  if (strpos($orow['value'],'%'))
    $orows2[$key]['value'] = trim(rtrim($orow['value'],'%'))/100;
}

header('Content-Type: application/json');
echo json_encode($orows2);










?>
