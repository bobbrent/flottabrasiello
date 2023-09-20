<?php         
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include($_SERVER['DOCUMENT_ROOT'].'/functions/db.php');
    if ($_FILES['file']['size'] <= 0) {
        print_r( json_encode(['errore', 'Devi selezionare il file'], true));
    } else {
        foreach ($_FILES as $key => $value) {
            if (0 < $value['error']) {
              print_r( json_encode(['errore', 'Error during file upload ' . $value['error']], true));
            } else if (!empty($value['name'])) {
    // $dbConn = mysqli_connect('localhost', 'root', '', 'brasiello_fleet') or die('MySQL connect failed. ' . mysqli_connect_error());
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql = "
    insert into file_bolle(`id_bolla`, `nome_file`, `content`, `grandezza`, `tipo`, `data`) values(
      ".$_POST['numerobolla'].",
      '".$value['name']."',
      '".mysqli_escape_string($dbConn, file_get_contents($value['tmp_name']))."', 
      '".filesize_formatted($value['size'])."', 
      '".$value['type']."', 
      '".date('Y-m-d H:i:s')."'
      )";
    
    $result = mysqli_query($connString, $sql) or die(mysqli_error($connString));
    
    if($result) {
      print_r( json_encode(['successo', 'File salvato nel database'], true));
    }
            }
        }
    }
}

function filesize_formatted($size) {
  $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
  $power = $size > 0 ? floor(log($size, 1024)) : 0;
  
  return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}