<?php
//clears cache

$link2cache = "../api/v0.1/cache/";

array_map('unlink', glob($link2cache."*"));  //http://php.net/manual/en/function.unlink.php

?>
