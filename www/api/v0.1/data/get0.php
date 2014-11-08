<?php

include("../common.php");

$g = getjson('https://spreadsheets.google.com/feeds/list/1a9zd3ThneSR7JN7-wj4uw5hBBggY9NyguFYIb4jbAc0/od6/public/full?alt=json');

$fields = [
  'question_identifier' => 'gsx$questionidentifier',
  'poll_identifier' => 'gsx$pollidentifier',
  'pollster_id' => 'gsx$pollsterid',
  'choice_id' => 'gsx$choiceid',
  'value' => 'gsx$value',
];
$t = '$t';

// set filter
$filter = [];
if (isset($_GET['start_date']))
    $filter['start_date'] = trim($_GET['start_date']);
else
    $filter['start_date'] = '1000-01-01';
if (isset($_GET['end_date']))
    $filter['end_date'] = trim($_GET['end_date']);
else
    $filter['end_date'] = '5000-01-01';
if (isset($_GET['question_identifier']))
    $filter['question_identifier'] = slugify(trim($_GET['question_identifier']));
if (isset($_GET['poll_identifier']))
    $filter['poll_identifier'] = slugify(trim($_GET['poll_identifier']));
if (isset($_GET['pollster_id']))
    $filter['pollster_id'] = slugify(trim($_GET['pollster_id']));
if (isset($_GET['choice_id']))
    $filter['choice_id'] = slugify(trim($_GET['choice_id']));
       
 
//get polls information   
$polls = getjson('https://spreadsheets.google.com/feeds/list/1a9zd3ThneSR7JN7-wj4uw5hBBggY9NyguFYIb4jbAc0/o9g2mo8/public/full?alt=json');
//reorder polls for easy access
$keys = [
  'identifier' => 'gsx$identifier',
  'pollster' => 'gsx$pollster',
];
$polls_ar = [];
foreach ($polls->feed->entry as $row) {
  if (!isset($polls_ar[$row->$keys['identifier']->$t]))
    $polls_ar[slugify(trim($row->$keys['identifier']->$t))] = [];
  $polls_ar[slugify(trim($row->$keys['identifier']->$t))][slugify(trim($row->$keys['pollster']->$t))] = $row;
}


$out = [];
$t = '$t';
foreach ($g->feed->entry as $row) {
  if (filter($row,$filter,$fields,$polls_ar,$keys)) {
      $orow = [];
      foreach ($fields as $fkey => $field) {
        if (in_array($fkey,['question_identifier','poll_identifier','pollster_id','choice_id']))
          $orow[$fkey] = slugify(trim($row->$field->$t));
        else if ($fkey == 'value')
          if (strpos($row->$field->$t,'%')) {
            $orow[$fkey] = trim(rtrim(trim($row->$field->$t),'%'))/100;
          } else {
            $orow[$fkey] = trim($row->$field->$t);
          }
        else
          $orow[$fkey] = trim($row->$field->$t);
      }
      $orow[$fkey]['poll'] = getjson("../polls/get.php?identifier=".$orow[$fkey]['question_identifier']."&pollster=".$orow[$fkey]['pollster_identifier']);
      $out[] = $orow;
  }
}

header('Content-Type: application/json');
echo json_encode($out);


// returns whether row fullfills filter or not
function filter($row,$filter,$fields,$polls_ar,$keys) {
  $t = '$t';
  $easy = ['question_identifier','poll_identifier','pollster_id','choice_id'];
  foreach ($easy as $e) {
    if ((isset($filter[$e])) and ($filter[$e] != slugify(trim($row->$fields[$e]->$t)))) {
        return false;
    }
  }
  $poll_identifier = slugify(trim($row->$fields[$easy[1]]->$t));
  $poll_pollster = slugify(trim($row->$fields[$easy[2]]->$t));
  if (!(isset($polls_ar[$poll_identifier]) and (isset($polls_ar[$poll_identifier][$poll_pollster]))))
    return false;
  $dates = [
    'start_date' => 'gsx$startdate',
    'end_date' => 'gsx$enddate'
  ];
  $single_poll = $polls_ar[$poll_identifier][$poll_pollster];
  if (($single_poll->$dates['end_date']->$t >= $filter['start_date']) and ($single_poll->$dates['end_date']->$t <= $filter['end_date']))
    return true;
  else
    return false;
  
}

?>
