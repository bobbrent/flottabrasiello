<?php
include 'fun.php';
if($_POST['datas'] == "0000-00-00 00:00:00"){
  echo 3;
}else{
  $nuovoveic = nuovoveicolo($_POST['dati'],$_POST['sede'],$_POST['datas']);
  
  if(!$nuovoveic){
    echo 0;
  }else{
    echo 1;
  }
}
?>