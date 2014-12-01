<?php

// put full path to Smarty.class.php
require('/usr/local/lib/php/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir('../smarty/templates/');
$smarty->setCompileDir('../smarty/templates_c/');

include_once("text.php");

$widgets=[
    ['charturl'=>'widget/linechart/', 'parameters'=>'?since=2013-11-01&width=400&height=150','description'=>'CVVM: <strong>volební model</strong>, od posledních voleb 2013'],
    ['charturl'=>'widget/linechart/', 'parameters'=>'?since=2013-11-01&width=400&height=150&pollster_id=median','description'=>'Median: <strong>volební model</strong>, od posledních voleb 2013'],
    ['charturl'=>'widget/linechart/', 'parameters'=>'?since=&width=400&height=150&topic_id=ucast-psp','description'=>'CVVM: deklarovaná <strong>účast</strong> ve volbách'],
    ['charturl'=>'widget/linechart/', 'parameters'=>'?since=2013-11-01&&width=400&height=150&topic_id=preference-psp','description'=>'CVVM: <strong>volební preference</strong>, od posledních voleb']
];
foreach ($widgets as $k => $widget) {
  $widgets[$k]['url'] = $text['url'] . $widget['charturl'] . $widget['parameters'];
  $widgets[$k]['svgurl'] = $text['url'] . $widget['charturl'] . 'cache/svg/' . md5($widgets[$k]['url']);
  $widgets[$k]['pngurl'] = $text['url'] . $widget['charturl'] . 'cache/png/' . md5($widgets[$k]['url']);
}



$smarty->assign('text',$text);
$smarty->assign('widgets',$widgets);

$smarty->display('frontpage.tpl');

?>
