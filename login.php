<?php
  include('functions/functions.php');
  $c = include('config/data.php');
  $setcookie = 3600*24;
  session_set_cookie_params($setcookie);
  session_start();
  $error='';
  if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
      $error = "Username o Password errati";
    }
    else
    {
      $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);
      $username = stripslashes($_POST['username']);
      $password = stripslashes($_POST['password']);
      $username = mysqli_real_escape_string($mysqli, $username);
      $password = mysqli_real_escape_string($mysqli, $password);

      if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
      }
      $sqlI = "select * from login where username='$username'";

      if (!$resultS = $mysqli->query($sqlI)) {
        $error = "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
      }else{
        $rows = $resultS->fetch_assoc();

        if ($rows > 0) {

          if ($rows['password'] == crypt($password, $rows['password'])) {
            $data = date("Y-m-d H:i:s");
            $sqlIu = "UPDATE login SET 	ultimo_login = '$data' WHERE username='$username'";
            $acc = $mysqli->query($sqlIu);
            $_SESSION['login_user']=$username;
            if($rows['role'] == 0 || $rows['role'] == 1 ){
							$_SESSION['ruolo'] = $rows['role'];
              $_SESSION['is_admin'] = true;
              header("location: app.php");
              if(isset($_SESSION['err'])){
                unset($_SESSION['err']);
              }
            } else{
              if(is_active($rows['role'])){
                $_SESSION['ruolo'] = $rows['role'];
                $_SESSION['sedi'] = sediTeller($rows['role']);
                header("location: app.php");
                if(isset($_SESSION['err'])){
                  unset($_SESSION['err']);
                }
              }else {
                unset($_SESSION['err']);
                $_SESSION['err'] = "Errore: Utente Non Autorizzato";
              }
            }
          } else {
            unset($_SESSION['err']);
            $_SESSION['err'] = "Errore: Username o Password errati";
          }

        } else {
         unset($_SESSION['err']);
         $_SESSION['err'] = "Errore: Username o Password errati";
        }
      }

    }
  }
?>