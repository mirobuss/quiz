<?php
//error_reporting(E_ALL ^ E_NOTICE);
include '../../../../gf/App.php';
$app= \GF\App::getInstance();
$app->setConfigFolder('../config');
$app->run();