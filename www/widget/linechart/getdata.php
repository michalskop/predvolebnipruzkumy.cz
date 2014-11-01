<?php
error_reporting(0);
include("../../settings.php");
include("../../common.php");
include("../../text.php");

setlocale(LC_ALL, $text['locale']);

//read params:
$readparams = ['since','until','topic_id','pollster_id','choice_id'];
$defaults = ['since' => '1900-01-01', 'topic_id' => 'model-psp', 'pollster_id' => 'cvvm'];
$params = [];
foreach ($readparams as $rp)
if (isset($_GET[$rp])) {
  if (is_array($_GET[$rp])) {
    $p = [];
    foreach ($_GET[$rp] as $item) {
      $p[] = sanitize($item);
    }
    $params[$rp] = $p;
  } else {
    $params[$rp] = sanitize($_GET[$rp]);
  }
}
else {
  if (isset($defaults[$rp]))
    $params[$rp] = $defaults[$rp];
}

$url = 
$api_path . "data/get.php?" . http_build_query($params);
$raw = json_decode(file_get_contents($url));
usort($raw, "cmp");
$colors = json_decode(file_get_contents("../../js/colors.json"));


//choices
$url = $api_path . "choice/get.php";
$choices = json_decode(file_get_contents($url));
    //reorder choices ofr easy access
$choices_re = [];
foreach ($choices as $choice) {
  $choices_re[$choice->id] = $choice;
}



$out = [];
$out_ar = [];
foreach ($raw as $row) {
  $name = $row->choice_id;
  $out_ar[$name]['name'] = $name;
  $choice = $choices_re[$row->choice_id];
  if (isset($choice->abbreviation))
    $ch = $choice->abbreviation;
  else
    $ch = $choice->name;
  $tooltip = "<strong>" . $ch . "</strong><br/>" . round($row->value*1000)/10 . " %<br/>" . strftime("%x",strtotime($row->end_date));
  if (!(isset($out_ar[$name]['values'])))
    $out_ar[$name]['values'] = [];
  $out_ar[$name]['values'][] = ["x"=> $row->end_date, "y" =>$row->value, "n" => intval($row->n), "tooltip" => $tooltip];

  if (isset($colors->$name))
    $out_ar[$row->choice_id]['properties']['fill'] = $colors->$name;
  else
    $out_ar[$row->choice_id]['properties']['fill'] = '#888';
  //$out_ar
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
