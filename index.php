<?php
	include 'login.php';
	if (isset($_SESSION['login_user'])) {
		header("location: app.php");
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Roberto Lombardi">
  <title>Brasiello  |  Logins</title>
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="lib/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  <style>
    #errore_login{
      font-weight: 800;
      padding: 0 10%;
      font-family: Helvetica Neue;
      text-align: center;
    }
    .logo_login{
      width: 200px;
      mix-blend-mode: screen;
    }
    @media screen and (max-width: 676px) {
      .form-login{
        margin: 75px auto 0;
      }
    }
  </style>
</head>

<body>
  <div id="login-page">
    <div class="container">
      <form class="form-login" method="POST" action="index.php">
        <h2 class="form-login-heading"><img class="logo_login" src="img/logo.png"></h2>
        <div class="login-wrap">
          <input type="text" class="form-control" name="username" placeholder="username" autofocus>
          <br>
          <input type="password" class="form-control" name="password" placeholder="Password">
          <br>
          <input class="btn btn-theme btn-block" type="submit" name="submit" value="Login">
          <hr>
          <span id="errore_login"><?php echo $error; ?></span>
        </div>
      </form>
    </div>
  </div>
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="lib/jquery.backstretch.min.js"></script>
    <?php
      if(isset($_SESSION['err'])){
        ?>
          <script>
            document.getElementById('errore_login').innerText = '<?php echo $_SESSION['err'];?>';
          </script>
        <?php
      }
    ?>
  <script>
    $.backstretch("img/home.jpg", {
      speed: 500
    });
  </script>
</body>

</html>
