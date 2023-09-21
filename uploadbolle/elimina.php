<?php
require('../parts/pages/funbolle.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $nome_file = cercafileperid($id)[2];
    if($nome_file) {
        // print_r($nome_file);
        $connection = mysqli_connect('localhost', 'flotta_brasiello', '%Kp3l8%%Kp3l8s13p3l8s13', 'brasiello_fleet');
        $query = "DELETE " .
                "FROM file_bolle WHERE id = '$id'";
        $result = mysqli_query($connection, $query) or die('Error, query failed');
        mysqli_close($connection);
        unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$nome_file);
        print_r(json_encode(['successo', 'File eliminato.'], true));
        exit;
    } else {
        print_r(json_encode(['errore', 'File non eliminato.'], true));
    }
}
