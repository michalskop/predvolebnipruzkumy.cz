<?php

// put full path to Smarty.class.php
require('/usr/local/lib/php/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir('../../../smarty/templates/');
$smarty->setCompileDir('../../../smarty/templates_c/');

include_once("../../text.php");

$smarty->assign('text',$text);

$smarty->display('docs_widgets.tpl');

?>
