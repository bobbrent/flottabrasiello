<?php
session_start();
require 'functions.php';

if (!is_array($_POST['exec'])) {
  $contentVar = json_encode($_POST['exec']);
} else {
  $contentVar = $_POST['exec'];
}

if ($contentVar['fxf']) {
  switch ($contentVar['fxf']) {
    case 'pp':{
        switchPage($contentVar);
        break;
      }
    case 'pid':{
        switchPageid($contentVar);
        break;
      }
    case 'or':{
        ordine($contentVar);
        break;
      }
    case 'full':{
        switchPagefull($contentVar);
        break;
      }
    default:{
        print_r($contentVar);
        break;
      }
  }
}
?>