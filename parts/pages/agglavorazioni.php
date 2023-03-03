<?php
  include 'fun.php';
  
  $id = $_GET['id'];
  $lavorazione = $_GET['lavorazione'];
  $valore = $_GET['valore'];

  aggiornaLavorazioniMacchina($id, $lavorazione, $valore);


?>