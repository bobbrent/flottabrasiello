<?php
  include 'fun.php';
  
  $id = $_POST['id'];
  $campo = $_POST['campo'];
  $valore = addslashes($_POST['valore']);

  print_r(aggiornaPiazzale($id, $campo, $valore));



?>