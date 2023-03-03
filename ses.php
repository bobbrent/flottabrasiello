<?php
  $c = include('config/data.php');
  $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);
  $time = 3600*24;
  session_set_cookie_params($time);
  session_start();
  if($_SESSION['login_user']){
    $user_check=$_SESSION['login_user'];
  }else{
    $user_check = false;
  }
  if($user_check){
    $sqlI = "select * from login where username='$user_check'";
    if (!$resultS = $mysqli->query($sqlI)) {
      mysqli_close($mysqli);
      header('Location: index.php');
    }
  }else{
    header('Location: index.php');
    unset($_SESSION['err']);
    $_SESSION['err'] = "Errore: Effettuare Login";
  }

?>