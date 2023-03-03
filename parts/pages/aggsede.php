<?php
  include 'fun.php';
  
  $id = $_POST['id'];
  $campo = $_POST['campo'];
  $valore = $_POST['valore'];

  if($campo == 'slug' || $campo == 'progressivo'){
    print_r(aggiornaSedeb($id, $campo, $valore));
  }else{
    print_r(aggiornaSede($id, $campo, $valore));
  }


?>