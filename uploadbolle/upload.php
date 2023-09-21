<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // include($_SERVER['DOCUMENT_ROOT'].'/functions/db.php');
    if ($_FILES['file']['size'] <= 0) {
        print_r(json_encode(['errore', 'Devi selezionare il file'], true));
    } else {
        foreach ($_FILES as $key => $value) {
            if (0 < $value['error']) {
                print_r(json_encode(['errore', 'Error during file upload ' . $value['error']], true));
            } elseif (!empty($value['name'])) {
                $filename = $value['name'];
                $tipofile =  pathinfo($filename, PATHINFO_EXTENSION);
                $newname = date('YmdHis', time()).mt_rand().'.'.$tipofile;
                $location = "../uploads/".$newname;
                if (move_uploaded_file($value['tmp_name'], $location)) {
                    $dbConn = mysqli_connect('localhost', 'flotta_brasiello', '%Kp3l8%%Kp3l8s13p3l8s13', 'brasiello_fleet') or die('MySQL connect failed. ' . mysqli_connect_error());
                    // $db = new dbObj();
                    // $connString =  $db->getConnstring();
      
                    $sql = " insert into file_bolle(`id_bolla`, `nome_file`, `nuovo_nome`, `grandezza`, `tipo`, `data`) values(
                      ".$_POST['numerobolla'].",
                      '".$value['name']."',
                      '".$newname."', 
                      '".filesize_formatted($value['size'])."', 
                      '".$value['type']."', 
                      '".date('Y-m-d H:i:s')."'
                      )";
      
                    $result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn));
      
                    if($result) {
                        print_r(json_encode(['successo', 'File salvato nel database'], true));
                    }
                } else {
                    print_r(json_encode(['errore', 'Errore durante il salvataggio del file: ' ], true));
  
                }
            }
        }
    }
}

function filesize_formatted($size)
{
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
  
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
