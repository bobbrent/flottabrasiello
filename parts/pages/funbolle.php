<?php
function filesize_formatted($size)
{
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
  
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function cercafileperbolla($id)
{
    // $dbConn = mysqli_connect('localhost', 'root', '', 'brasiello_fleet') or die('MySQL connect failed. ' . mysqli_connect_error());
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "select id,nome_file,nuovo_nome from file_bolle where id_bolla = $id";
    
    $result = mysqli_query($connString, $sql) or die(mysqli_error($connString));

    while ($row = $result->fetch_row()) {
        $risultato = $row;
    }
    if(isset($risultato)) {
        return $risultato;
    } else {
        return false;
    }
}

function cercafileperid($id)
{
    $dbConn = mysqli_connect('localhost', 'flotta_brasiello', '%Kp3l8%%Kp3l8s13p3l8s13', 'brasiello_fleet') or die('MySQL connect failed. ' . mysqli_connect_error());
    $sql = "
  select id,nome_file,nuovo_nome from file_bolle where id = $id";
  
    $result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn));

    while ($row = $result->fetch_row()) {
        $risultato = $row;
    }
    if(isset($risultato)) {
        return $risultato;
    } else {
        return false;
    }
}
