<?php


$url_path = "http://localhost/michal/project/predvolebnipruzkumy.cz/api/v0.0/";

/**
* filter
*/
function filter($rows,$filter_fields,$fields) {
  $filter = [];
  $orows = [];
  $t = '$t';
  
  foreach ($filter_fields as $ff) {
    if (isset($_GET[$ff]))
      $filter[$ff] = slugify(trim($_GET[$ff]));
  }
  foreach($rows as $row) {
    $pass = true;
    foreach($filter as $fkey => $f) {
      if (!(slugify($row->$fields[$fkey]->$t) == $f))
        $pass = false;
    }
    if ($pass)
        $orows[] = $row;
  }
  return $orows;
}

/**
* time filter
*/
function time_filter($rows) {
  $t = '$t';
  $gsd = 'gsx$startdate';
  $ged = 'gsx$enddate';
  if (isset($_GET['since']))
    $since = trim($_GET['since']);
  else
    $since = '1000-01-01';
  if (isset($_GET['until']))
    $until = trim($_GET['until']);
  else
    $until = '5000-01-01'; 
  
  $orows = [];
  foreach($rows as $row) {
    if (($since <= $row->$gsd->$t) and ($until > $row->$ged->$t))
      $orows[] = $row;
  }
  return $orows;
}

/**
* select for output
*/
function select_fields($orows,$fields,$slug_fields) {
    $t = '$t';
    $out = [];
    foreach ($orows as $row) {
      $orow = [];
      foreach ($fields as $fkey => $field) {
        if (in_array($fkey,$slug_fields)) {
          $orow[$fkey] = slugify(trim($row->$field->$t));
        } else {
          $orow[$fkey] = trim($row->$field->$t);
        }
      }
      $out[] = $orow;
    }
    return $out;
}

/**
  cache
*/
function getjson($url) {
  if (file_exists('../cache/'.slugify($url))) {
    return json_decode(file_get_contents('../cache/'.slugify($url)));
  }
  $json = file_get_contents($url);
  $file = fopen("../cache/".slugify($url),"w");
  fwrite($file,$json);
  fclose($file);
  return json_decode($json);
}

/**
* creates "friendly url" version of text, translits string (gets rid of diacritics) and substitutes ' ' for '-', etc.
* @return friendly url version of text
* example:
* friendly_url('klub ČSSD')
*     returns 'klub-cssd'
*/
function slugify($text,$locale = 'cs_CZ.utf-8') {
    $old_locale = setlocale(LC_ALL, "0");
    setlocale(LC_ALL,$locale);
    $url = $text;
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
    setlocale(LC_ALL,$old_locale);
    return $url;
}


?>
