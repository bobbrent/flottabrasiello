<header class="header black-bg">
  <div class="sidebar-toggle-box">
    <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
  </div>
  <a href="index.php" class="logo"><b><?php echo LOGO;?></b></a>
  <div class="nav notify-row" id="top_menu">
    <ul class="nav top-menu">
      <?php include('notification.php');?>
    </ul>
  </div>
  <div class="top-menu">
    <ul class="nav pull-right top-menu">
      <li id="logout_butt"><a href="logout.php" class="logout">Logout</a></li>
    </ul>
  </div>
</header>