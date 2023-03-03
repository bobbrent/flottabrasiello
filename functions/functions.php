<?php
//error_reporting(E_PARSE);
function switchPage($var){
  if (isset($var['da'])) {
    $da = $var['da'];
  } else {
    $da = "";
  }

  if (isset($var['a'])) {
    $a = $var['a'];
  } else {
    $a = "";
  }

  if (isset($var['sede'])) {
    $sede = $var['sede'];
  } else {
    $sede = "";
  }

  if (isset($var['operatore'])) {
    $operatore = $var['operatore'];
  } else {
    $operatore = "";
  }

  if (isset($var['pag'])) {
    $pagina = $var['pag'];
  } else {
    $pagina = "home";
  }
  include '../parts/pages/' . $var['c1'] . '.php';
}

function switchPageid($var){
  if ($var['pag']) {
      $pagina = $var['pag'];
  } else {
      $pagina = "home";
  }
  $id = $var['id'];
  include '../parts/pages/' . $var['c1'] . '.php';
}

function switchPagefull($var){
  $dati = $var;
  include '../parts/pages/' . $var['c1'] . '.php';
}

function ordine($var){
  $dati = $var;
  include '../parts/pages/' . $var['c1'] . '.php';
}

function is_active($role){
  $c = include 'config/data.php';

  $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);
  $sqlI = "select * from ruoli where id='$role'";
    if (!$resultS = $mysqli->query($sqlI)) {
      $error = "Query: " . $sql . "\n";
      echo "Errno: " . $mysqli->errno . "\n";
      echo "Error: " . $mysqli->error . "\n";
      exit;
    }else{
      $rows = $resultS->fetch_assoc();
    if ($rows > 0) {
      if($rows['abilita']){
        return true;
      }else{
        return false;
      }
    }
  }
}

function roleTeller($role){
  $c = include 'config/data.php';

  $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);
  $sqlI = "select * from ruoli where id='$role'";
    if (!$resultS = $mysqli->query($sqlI)) {
      $error = "Query: " . $sql . "\n";
      echo "Errno: " . $mysqli->errno . "\n";
      echo "Error: " . $mysqli->error . "\n";
      exit;
    }else{
      $rows = $resultS->fetch_assoc();
    if ($rows > 0) {
      return $rows['ruolo'];
    }
  }
}

function sediTeller($role){
  $c = include 'config/data.php';

  $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);
  $sqlI = "select * from ruoli where id='$role'";
  if (!$resultS = $mysqli->query($sqlI)) {
    $error = "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
  }else{
    $rows = $resultS->fetch_assoc();
    if ($rows > 0) {
      return $rows['sedi'];
    }
  }
}

?>