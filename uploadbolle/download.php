<?php 

if (isset($_GET['id'])) 
{
  // include($_SERVER['DOCUMENT_ROOT'].'/functions/db.php');
  $id = $_GET['id'];
  $connection = mysqli_connect('localhost', 'flotta_brasiello', '%Kp3l8%%Kp3l8s13p3l8s13', 'brasiello_fleet');
  // $db = new dbObj();
  // $connString =  $db->getConnstring();
  $query = "SELECT * " .
          "FROM file_bolle WHERE id = '$id'";
  $result = mysqli_query($connection,$query) or die('Error, query failed');
  list($id, $id_bolla, $file, $content, $size,$type) = mysqli_fetch_array($result);
  header("Content-type: $type");
  header("Content-Disposition: attachment; filename=$file");

  echo $content;
  mysqli_close($connection);
  exit;
}