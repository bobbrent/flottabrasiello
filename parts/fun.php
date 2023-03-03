<?php
include('functions/db.php');

function tellMeSedeUser($username){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT login.sedi FROM `login` where login.username = '$username'") or die("database error:". mysqli_error($connString));
	$row = mysqli_fetch_assoc($cec);
	return $row['sedi'];
}

function risolviNps($id_nps, $id_operatore){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec1 =  mysqli_query($connString, "INSERT INTO `nps_risolti`(`id_nps`, `ok`, `id_operatore`) VALUES ($id_nps, 1, $id_operatore)") or die("database error:". mysqli_error($connString));
  return true;
}

function iserisciNota($id_nps, $testo, $id_operatore){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $testo = addslashes($testo);
  $cec1 =  mysqli_query($connString, "INSERT INTO `commenti`(`id_nps`, `id_operatore`, `testo`) VALUES ($id_nps,$id_operatore,'$testo')") or die("database error:". mysqli_error($connString));
  return true;
}

function tellMeNoteNps($id){
	$db = new dbObj();
	$connString = $db->getConnstring();
	$cec = mysqli_query($connString, "SELECT * FROM `commenti` WHERE `id_nps` = $id") or die("database error:" . mysqli_error($connString));

	$note = array();
	$i = 0;

	$numero_righe = mysqli_num_rows($cec);
	if($numero_righe > 0){
		while($row = mysqli_fetch_assoc($cec)){
			$note[$i] = [$row['id_operatore'],$row['testo'],$row['data']];
			$i++;
		}
	}else{
		$note = "Nessuna Nota";
	}
	return $note;
}

function risoluzioneNps($id){
	$db = new dbObj();
	$connString = $db->getConnstring();
	$cec = mysqli_query($connString, "SELECT * FROM `nps_risolti` WHERE `id_nps` = '$id'") or die("database error:" . mysqli_error($connString));
	$row_cnt = mysqli_num_rows($cec);

  if($row_cnt > 0){
		if(irrisolvibile($id)){
			$row = mysqli_fetch_assoc($cec);
			switch($row['ok']){
				case true: $ris = "Risolto";break;
				default: $ris = "Non Risolto";break;
			}
		}else{
			$ris = "Non Risolvibile";
		}

	}else{
		if(irrisolvibile($id)){
			$ris = "Non Risolto";
		}else{
			$ris = "Non Risolvibile";
		}

	}
	return $ris;
}

function infoNps($id){
	$db = new dbObj();
	$connString = $db->getConnstring();
	$cec = mysqli_query($connString, "SELECT * FROM `lime_survey_804856` WHERE `id` = '$id'  AND `804856X13X91` IS NOT NULL AND `804856X13X91` != '' AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` <> '' AND `804856X13X106` IS NOT NULL  AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC") or die("database error:" . mysqli_error($connString));
	$row = mysqli_fetch_assoc($cec);
	return $row;
}

function irrisolvibile($id){
	$info = infoNps($id);
	$data_da_info = $info['startdate'];
	$data_oggi = time();
	$data_nps = strtotime($data_da_info);

	$datediff = $data_oggi - $data_nps;

	$stato = tellMeStatoNps($id);
	$giorni_passati = round($datediff / (60 * 60 * 24));
	if($giorni_passati < 31){
		return true;
	}else{
		return false;
	}
}

function tellMeIcona($data, $id, $voto){

	$data_oggi = time();
	$data_nps = strtotime($data);

	$datediff = $data_oggi - $data_nps;

	$stato = tellMeStatoNps($id);
	$giorni_passati = round($datediff / (60 * 60 * 24));

	if (risoluzioneNps($id) == 'Risolto') {
			$icona[0] = "battery-icon-green";
			$icona[1] = "battery-icon-green";
	} else {
			if ($voto > 8) {
				$icona[0] = "battery-icon-green";
				$icona[1] = "battery-icon-green";
			} else {
					switch ($giorni_passati) {
							case ($giorni_passati > 0 && $giorni_passati < 10): $icona[1] = "battery-icon-5-5"; $icona[0] = "battery-icon-green";
									break;
							case ($giorni_passati > 10 && $giorni_passati < 20): $icona[1] = "battery-icon-3-5"; $icona[0] = "battery-icon-green";
									break;
							case ($giorni_passati > 20 && $giorni_passati < 30): $icona[1] = "battery-icon-1-5"; $icona[0] = "battery-icon-green";
									break;
							default: $icona[1] = "battery-icon-red"; $icona[0] = "scaduta"; $icona[2] = true;
									break;
					}
			}
	}

	return $icona;

}

function formattaDataLogin($data){
    $right = date('d/m/Y H:i', strtotime($data));
    return $right;
}

function mailSbagliate($x){
	$contatore = 0;
	$arrayReturn = array();
	$db = new dataBaseMailer();
	$connString = $db->getConnstring();
	$cec = mysqli_query($connString, "SELECT * FROM `mail_log` WHERE `id_operatore` = $x AND `valida` = 0") or die("database error:" . mysqli_error($connString));
	while ($row = mysqli_fetch_assoc($cec)) {
		$arrayReturn[$contatore] = [
			$row["id"],
			$row["mail"],
			$row["contratto"],
			$row["data_richiesta"]
		];
		$contatore++;
	}
	return $arrayReturn;
}

function mailPerOperatore($x){
	$contatore = 0;
	$arrayReturn = array();
	$db = new dataBaseMailer();
	$connString = $db->getConnstring();
	$cec = mysqli_query($connString, "SELECT * FROM `mail_log` WHERE `id_operatore` = $x") or die("database error:" . mysqli_error($connString));
	while ($row = mysqli_fetch_assoc($cec)) {
		$arrayReturn[$contatore] = [
			$row["id"],
			$row["mail"],
			$row["contratto"],
			$row["id_operatore"],
			$row["data_richiesta"],
			$row["valida"]
		];
		$contatore++;
	}
	return $arrayReturn;
}

function percentualeErrori($x){
	$contatore = 0;
	$num = 0;
	$db = new dataBaseMailer();
	$connString = $db->getConnstring();
	$query = mysqli_query($connString, "SELECT * FROM `mail_log` WHERE `id_operatore` = $x") or die("database error:" . mysqli_error($connString));

	while ($st = mysqli_fetch_assoc($query)) {
		$email_arr = explode('@', $st["mail"]);
		$domain = array_slice($email_arr, -1);
		$no = array("yahoo.com", "yahoo.it", "yahoo.fr", "schneider-electric.com", "ymail.it", "ymail.com", "archiworldpec.it");
		$domino = strtolower($domain);
		if (!in_array($domino, $no)) {
			if ($st["valida"] == 0) {
				$contatore++;
			}
			$num++;
		}
	}
	if ($contatore > 0) {
		$v = ($contatore / $num) * 100;
		$valore = round($v);
	} else {
		$valore = 0;
	}

	$ret = [$valore, $num, $contatore];
	return $ret;
}

function cancella($cosa, $id){
  $db = new dbObj();
  $connString = $db->getConnstring();
  $cec1 = mysqli_query($connString, "DELETE FROM `$cosa` WHERE id = $id") or die("database error:" . mysqli_error($connString));
  return 1;
}

function troncaProd($x, $length){
    if (strlen($x) <= $length) {
        return $x;
    }
    return substr($x, 0, $length) . '...';
}

function aggiornaUtente($id, $password){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $pass = crypt($password);
  $cec1 =  mysqli_query($connString, "UPDATE `login` SET login.password = '$pass' WHERE login.id = $id") or die("database error:". mysqli_error($connString));
  return 1;
}

function aggiornaUtenteSEDI($id, $sedi){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec1 =  mysqli_query($connString, "UPDATE `login` SET login.sedi = '$sedi' WHERE login.id = $id") or die("database error:". mysqli_error($connString));
  return 1;
}

function nuovoutente($user, $password, $ruolo){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $pass = crypt($password);
  $cec1 =  mysqli_query($connString, "INSERT INTO `login`(`username`, `password`, `role`) VALUES ('$user','$pass','$ruolo')") or die("database error:". mysqli_error($connString));
  $cec =  mysqli_query($connString, "SELECT login.id FROM `login` ORDER BY login.id Desc limit 1") or die("database error:". mysqli_error($connString));
  $rows = mysqli_fetch_assoc($cec);
  $id = $rows['id'];
  return $id;
}

function nuovoutenteStation($user, $password, $ruolo, $sedi){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $pass = crypt($password);
  $cec1 =  mysqli_query($connString, "INSERT INTO `login`(`username`, `password`, `role`, `sedi`) VALUES ('$user','$pass','$ruolo','$sedi')") or die("database error:". mysqli_error($connString));
  $cec =  mysqli_query($connString, "SELECT login.id FROM `login` ORDER BY login.id Desc limit 1") or die("database error:". mysqli_error($connString));
  $rows = mysqli_fetch_assoc($cec);
  $id = $rows['id'];
  return $id;
}

function tellMeUtente($id){
    $db = new dbObj();
    $connString = $db->getConnstring();
    $cec = mysqli_query($connString, "SELECT login.username FROM `login` where login.id = $id") or die("database error:" . mysqli_error($connString));
    $row_cnt = mysqli_num_rows($cec);
    if ($row_cnt > 0) {
        $or = mysqli_fetch_assoc($cec);
        $nome = $or['username'];
        return $nome;
    } else {
        $nome = 'Cliente non trovato';
        return $nome;
    }

}

function tellMeUser($username){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT login.id FROM `login` where login.username = '$username'") or die("database error:". mysqli_error($connString));
  $row_cnt = mysqli_num_rows($cec);

  $or = mysqli_fetch_assoc ($cec);
  return $or['id'];

}

function tellMeSediUser($username){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT login.sedi FROM `login` where login.username = '$username'") or die("database error:". mysqli_error($connString));
  $row_cnt = mysqli_num_rows($cec);

  $or = mysqli_fetch_assoc ($cec);
  return $or['sedi'];
}

function tellMeOperatore($id){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT login.username FROM `login` where login.id = $id") or die("database error:". mysqli_error($connString));
  $row_cnt = mysqli_num_rows($cec);
  if($row_cnt > 0){
    $or = mysqli_fetch_assoc ($cec);
    $nome = $or['username'];

    $data = $nome;
    return $data;
  }else{
    $data = 'Operatore non trovato';
    return $data;
  }

}

function tellMeRuolo($s){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `ruoli` where ruoli.id = $s") or die("database error:". mysqli_error($connString));
  $row_cnt = mysqli_num_rows($cec);
  if($row_cnt > 0){
    $or = mysqli_fetch_assoc ($cec);
    return $or['ruolo'];
  }else{
    return '/';
  }
}

function tellMeSede($s){
	$db = new dbObj();
	$connString = $db->getConnstring();
	$cec = mysqli_query($connString, "SELECT `descrizione` FROM `sedi` WHERE `codice` = '$s'") or die("database error:" . mysqli_error($connString));
	$row = mysqli_fetch_assoc($cec);
	return $row['descrizione'];
}

function tellMeStatoNps($id){
	$db = new dbObj();
	$connString = $db->getConnstring();
	$cec = mysqli_query($connString, "SELECT * FROM `commenti` WHERE `id_nps` = $id") or die("database error:" . mysqli_error($connString));
	$row_cnt = mysqli_num_rows($cec);
  if($row_cnt > 0){
		$row = mysqli_fetch_assoc($cec);
		return $row;
	}else{
		$r['stato'] = false;
		return $r['stato'];
	}
}

function tellMeSedi(){
		$db = new dbObj();
		$connString = $db->getConnstring();
		$cec = mysqli_query($connString, "SELECT DISTINCT `descrizione`, `codice` FROM `sedi` WHERE `attiva` = 'TRUE'") or die("database error:" . mysqli_error($connString));
		$i = 0;
		while ($row = mysqli_fetch_assoc($cec)) {
			$sede[$i]['codice'] = $row['codice'];
			$sede[$i]['nome'] = $row['descrizione'];
			$i++;
		}
    return $sede;
}

function htmlXspecialchars($string, $ent = ENT_COMPAT, $charset = 'ISO-8859-1'){
    return htmlspecialchars($string, $ent, $charset);
}

function htmlXentities($string, $ent = ENT_COMPAT, $charset = 'ISO-8859-1'){
    return htmlentities($string, $ent, $charset);
}

function htmlX_entity_decode($string, $ent = ENT_COMPAT, $charset = 'ISO-8859-1'){
    return html_entity_decode($string, $ent, $charset);
}
