<?php
include($_SERVER['DOCUMENT_ROOT'].'/functions/db.php');
include($_SERVER['DOCUMENT_ROOT'].'/config/struct.php');
// include($_SERVER['DOCUMENT_ROOT'].'/bgest/functions/db.php');
// include($_SERVER['DOCUMENT_ROOT'].'/bgest/config/struct.php');

function controllaNumeroBolla($num, $sede){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `ultima_bolla` WHERE `sede` = '$sede'") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  if($ris[2] < $num){
    return true;
  }else{
    return false;
  }
}

function nuovabolla($var, $sede, $data, $progressivo, $ultimo){
  $i =0;
  for($x = false;$x != true; $i++){
    $x = controllaNumeroBolla($ultimo, $sede);
    if($x == false){
      $ultimo++;
    }
  }

  $prg = tellMeProgressivo($sede);
  $dat = date('y');
  $progressivo = $prg[0][2]."-".$dat."/".$ultimo;

  $destinatario = [$var[0], $var[1], $var[2], $var[3], $var[4], $var[9]];
  if($var[5] == ''){
    $destinazione = [$var[1], $var[2], $var[3], $var[4]];
  }else{
    $destinazione = [$var[5], $var[6], $var[7], $var[8]];
  }
  $destinatario = json_encode($destinatario);
  $destinazione = json_encode($destinazione);
  $db = new dbObj();
  $connString =  $db->getConnstring();

  $veicoli = json_encode($var[13]);

  $QUER = "INSERT INTO `bolla`(`progressivo`,".
  "`data_bolla`, `sede`, `id_veicoli`, `destinatario`, ".
  "`luogo_destinazione`, `causale_trasporto`, `vettori`, ".
  "`annotazioni`) VALUES ('".$progressivo."','".$data."','".$sede."','".$veicoli.
  "','".addslashes($destinatario)."','".addslashes($destinazione)."','".addslashes($var[11])."','".addslashes($var[10])."','".addslashes($var[12])."')";
  
  $cec =  mysqli_query($connString, $QUER) or die("database error:". mysqli_error($connString));

  if($cec){
    foreach($var[13] as $v){
      $quera = "UPDATE `macchina` SET `data_uscita`='$data',`bolla_uscita`='$progressivo' WHERE `id` = $v";
      $ceca =  mysqli_query($connString, $quera) or die("database error:". mysqli_error($connString));
    }
  
    $quers = "UPDATE `ultima_bolla` SET `progressivo`= $ultimo WHERE `sede` = '$sede'";
    $cecs =  mysqli_query($connString, $quers) or die("database error:". mysqli_error($connString));
  }
}

function nuovoveicolo($var, $sede, $data){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $QUER = "INSERT INTO `macchina`(`id_piazzale`, 
  `sede`, `targa`, `telaio`, `marca`, `modello`, `colore`, `data_arrivo`, 
  `presenza_bolla_arrivo`, `km`, `doppia_chiave`, `libretto_circolazione`, 
  `sd_card`, `tappetini`, `rscorta_gonfiaggio`, `antenna`, `libretto_manutenzione`, 
  `note`, `tipo_veicolo`, `flotta`) VALUES (
    ".$var[0].",
    '".$sede."',
    '".addslashes($var[1])."',
    '".addslashes($var[2])."',
    '".addslashes($var[3])."',
    '".addslashes($var[4])."',
    '".addslashes($var[5])."',
    '".$data."',
    ".$var[15].",
    ".$var[6].",
    ".$var[14].",
    ".$var[13].",
    ".$var[12].",
    ".$var[11].",
    ".$var[10].",
    ".$var[9].",
    ".$var[8].",
    '".addslashes($var[7])."',
    '".addslashes($var[16])."',
    '".addslashes($var[17])."'
  )";
  $cec =  mysqli_query($connString, $QUER) or die("database error:". mysqli_error($connString));
  //$row = mysqli_fetch_assoc($cec);
  return $cec;
}

function inventario($array, $datare = "no"){
  if($datare != "no"){
    $date = new DateTime($datare);
  }else{
    $date = new DateTime(date('Y-m-d'));
  }
  
  $data = $date->format('Y-m-d');
  $data_1 = $date->modify('-1 day')->format('Y-m-d');
  $data_2 = $date->modify('-1 day')->format('Y-m-d');
  $data_3 = $date->modify('-1 day')->format('Y-m-d');
  $data_4 = $date->modify('-1 day')->format('Y-m-d');
  
  $nuovo_oggi = array();
  $nuovo_oggi_1 = array();
  $nuovo_oggi_2 = array();
  $nuovo_oggi_3 = array();
  $nuovo_oggi_4 = array();
  $conta_arrivi_macchine_nuove_oggi = 0;
  $conta_arrivi_macchine_nuove_oggi_1 = 0;
  $conta_arrivi_macchine_nuove_oggi_2 = 0;
  $conta_arrivi_macchine_nuove_oggi_3 = 0;
  $conta_arrivi_macchine_nuove_oggi_4 = 0;

  $nuovo_oggi_uscite = array();
  $nuovo_oggi_1_uscite = array();
  $nuovo_oggi_2_uscite = array();
  $nuovo_oggi_3_uscite = array();
  $nuovo_oggi_4_uscite = array();
  $conta_uscite_macchine_nuove_oggi = 0;
  $conta_uscite_macchine_nuove_oggi_1 = 0;
  $conta_uscite_macchine_nuove_oggi_2 = 0;
  $conta_uscite_macchine_nuove_oggi_3 = 0;
  $conta_uscite_macchine_nuove_oggi_4 = 0;
  
  $usato_oggi = array();
  $usato_oggi_1 = array();
  $usato_oggi_2 = array();
  $usato_oggi_3 = array();
  $usato_oggi_4 = array();
  $conta_arrivi_macchine_usate_oggi = 0;
  $conta_arrivi_macchine_usate_oggi_1 = 0;
  $conta_arrivi_macchine_usate_oggi_2 = 0;
  $conta_arrivi_macchine_usate_oggi_3 = 0;
  $conta_arrivi_macchine_usate_oggi_4 = 0;
  
  $usato_oggi_uscite = array();
  $usato_oggi_1_uscite = array();
  $usato_oggi_2_uscite = array();
  $usato_oggi_3_uscite = array();
  $usato_oggi_4_uscite = array();
  $conta_uscite_macchine_usate_oggi = 0;
  $conta_uscite_macchine_usate_oggi_1 = 0;
  $conta_uscite_macchine_usate_oggi_2 = 0;
  $conta_uscite_macchine_usate_oggi_3 = 0;
  $conta_uscite_macchine_usate_oggi_4 = 0;

  $stock_nuovo = 0;
  $stock_usato = 0;

  $a = 0; //cont nuovo oggi 
  $b = 0; //cont nuovo oggi -1
  $c = 0; //cont nuovo oggi -2
  $d = 0; //cont nuovo oggi -3
  $e = 0; //cont nuovo oggi -4
  $f = 0; //cont usato oggi 
  $g = 0; //cont usato oggi -1
  $h = 0; //cont usato oggi -2
  $i = 0; //cont usato oggi -3
  $l = 0; //cont usato oggi -4

  $m = 0; //cont nuovo oggi uscite
  $n = 0; //cont nuovo oggi -1 uscite
  $o = 0; //cont nuovo oggi -2 uscite
  $p = 0; //cont nuovo oggi -3 uscite
  $q = 0; //cont nuovo oggi -4 uscite
  $r = 0; //cont usato oggi uscite
  $s = 0; //cont usato oggi -1 uscite
  $t = 0; //cont usato oggi -2 uscite
  $u = 0; //cont usato oggi -3 uscite
  $z = 0; //cont usato oggi -4 uscite

  $conta_macchine = 0;

  foreach($array as $v){
    $data_cut = substr($v[9], 0, 10);
    switch($data_cut){
      case ($data_cut == $data):{
        if($v[3] == 'NUOVO'){
          $nuovo_oggi[$a] = $v;
          $a++;
          $stock_nuovo++;
          break;
        }else{
          $usato_oggi[$f] = $v;
          $f++;
          $stock_usato++;
          break;
        }
      }
      case ($data_cut == $data_1):{
        if($v[3] == 'NUOVO'){
          $nuovo_oggi_1[$b] = $v;
          $b++;
          $stock_nuovo++;
          break;
        }else{
          $usato_oggi_1[$g] = $v;
          $g++;
          $stock_usato++;
          break;
        }
      }
      case ($data_cut == $data_2):{
        if($v[3] == 'NUOVO'){
          $nuovo_oggi_2[$c] = $v;
          $c++;
          $stock_nuovo++;
          break;
        }else{
          $usato_oggi_2[$h] = $v;
          $h++;
          $stock_usato++;
          break;
        }
      }
      case ($data_cut == $data_3):{
        if($v[3] == 'NUOVO'){
          $nuovo_oggi_3[$d] = $v;
          $d++;
          $stock_nuovo++;
          break;
        }else{
          $usato_oggi_3[$i] = $v;
          $i++;
          $stock_usato++;
          break;
        }
      }
      case ($data_cut == $data_4):{
        if($v[3] == 'NUOVO'){
          $nuovo_oggi_4[$e] = $v;
          $e++;
          $stock_nuovo++;
          break;
        }else{
          $usato_oggi_4[$l] = $v;
          $l++;
          $stock_usato++;
          break;
        }
      }
      default:{
        if($v[3] == 'NUOVO'){
          $stock_nuovo++;
          break;
        }else{
          $stock_usato++;
          break;
        }
      }
    }

    if($data_cut <= $data){
      if($v[3] == 'NUOVO'){
        $conta_arrivi_macchine_nuove_oggi++;
      }else{
        $conta_arrivi_macchine_usate_oggi++;
      }
    }
    if($data_cut <= $data_1){
      if($v[3] == 'NUOVO'){
        $conta_arrivi_macchine_nuove_oggi_1++;
      }else{
        $conta_arrivi_macchine_usate_oggi_1++;
      }
    }
    if($data_cut <= $data_2){
      if($v[3] == 'NUOVO'){
        $conta_arrivi_macchine_nuove_oggi_2++;
      }else{
        $conta_arrivi_macchine_usate_oggi_2++;
      }
    }
    if($data_cut <= $data_3){
      if($v[3] == 'NUOVO'){
        $conta_arrivi_macchine_nuove_oggi_3++;
      }else{
        $conta_arrivi_macchine_usate_oggi_3++;
      }
    }
    if($data_cut <= $data_4){
      if($v[3] == 'NUOVO'){
        $conta_arrivi_macchine_nuove_oggi_4++;
      }else{
        $conta_arrivi_macchine_usate_oggi_4++;
      }
    }
    
    if($v[19]){
      $data_cut_uscita = substr($v[19], 0, 10);

      switch($data_cut){
        case ($data_cut_uscita == $data):{
          if($v[3] == 'NUOVO'){
            $nuovo_oggi_uscite[$m] = $v;
            $m++;
            break;
          }else{
            $usato_oggi_uscite[$r] = $v;
            $r++;
            break;
          }
        }
        case ($data_cut_uscita == $data_1):{
          if($v[3] == 'NUOVO'){
            $nuovo_oggi_1_uscite[$n] = $v;
            $n++;
            break;
          }else{
            $usato_oggi_1_uscite[$s] = $v;
            $s++;
            break;
          }
        }
        case ($data_cut_uscita == $data_2):{
          if($v[3] == 'NUOVO'){
            $nuovo_oggi_2_uscite[$o] = $v;
            $o++;
            break;
          }else{
            $usato_oggi_2_uscite[$t] = $v;
            $t++;
            break;
          }
        }
        case ($data_cut_uscita == $data_3):{
          if($v[3] == 'NUOVO'){
            $nuovo_oggi_3_uscite[$p] = $v;
            $p++;
            break;
          }else{
            $usato_oggi_3_uscite[$u] = $v;
            $u++;
            break;
          }
        }
        case ($data_cut_uscita == $data_4):{
          if($v[3] == 'NUOVO'){
            $nuovo_oggi_4_uscite[$q] = $v;
            $q++;
            break;
          }else{
            $usato_oggi_4_uscite[$z] = $v;
            $z++;
            break;
          }
        }
      }

      if($data_cut_uscita <= $data){
        if($v[3] == 'NUOVO'){
          $conta_uscite_macchine_nuove_oggi++;
        }else{
          $conta_uscite_macchine_usate_oggi++;
        }
      }
      if($data_cut_uscita <= $data_1){
        if($v[3] == 'NUOVO'){
          $conta_uscite_macchine_nuove_oggi_1++;
        }else{
          $conta_uscite_macchine_usate_oggi_1++;
        }
      }
      if($data_cut_uscita <= $data_2){
        if($v[3] == 'NUOVO'){
          $conta_uscite_macchine_nuove_oggi_2++;
        }else{
          $conta_uscite_macchine_usate_oggi_2++;
        }
      }
      if($data_cut_uscita <= $data_3){
        if($v[3] == 'NUOVO'){
          $conta_uscite_macchine_nuove_oggi_3++;
        }else{
          $conta_uscite_macchine_usate_oggi_3++;
        }
      }
      if($data_cut_uscita <= $data_4){
        if($v[3] == 'NUOVO'){
          $conta_uscite_macchine_nuove_oggi_4++;
        }else{
          $conta_uscite_macchine_usate_oggi_4++;
        }
      }

    }

    $conta_macchine++;
  }

  $ris = [
    $nuovo_oggi,
    $nuovo_oggi_1,
    $nuovo_oggi_2,
    $nuovo_oggi_3,
    $nuovo_oggi_4,
    $nuovo_oggi_uscite,
    $nuovo_oggi_1_uscite,
    $nuovo_oggi_2_uscite,
    $nuovo_oggi_3_uscite,
    $nuovo_oggi_4_uscite,
    $usato_oggi,
    $usato_oggi_1,
    $usato_oggi_2,
    $usato_oggi_3,
    $usato_oggi_4,
    $usato_oggi_uscite,
    $usato_oggi_1_uscite,
    $usato_oggi_2_uscite,
    $usato_oggi_3_uscite,
    $usato_oggi_4_uscite,
    $stock_nuovo,
    $stock_usato,
    $conta_arrivi_macchine_nuove_oggi,
    $conta_arrivi_macchine_nuove_oggi_1,
    $conta_arrivi_macchine_nuove_oggi_2,
    $conta_arrivi_macchine_nuove_oggi_3,
    $conta_arrivi_macchine_nuove_oggi_4,
    $conta_arrivi_macchine_usate_oggi,
    $conta_arrivi_macchine_usate_oggi_1,
    $conta_arrivi_macchine_usate_oggi_2,
    $conta_arrivi_macchine_usate_oggi_3,
    $conta_arrivi_macchine_usate_oggi_4,
    $conta_uscite_macchine_nuove_oggi,
    $conta_uscite_macchine_nuove_oggi_1,
    $conta_uscite_macchine_nuove_oggi_2,
    $conta_uscite_macchine_nuove_oggi_3,
    $conta_uscite_macchine_nuove_oggi_4,
    $conta_uscite_macchine_usate_oggi,
    $conta_uscite_macchine_usate_oggi_1,
    $conta_uscite_macchine_usate_oggi_2,
    $conta_uscite_macchine_usate_oggi_3,
    $conta_uscite_macchine_usate_oggi_4,
    $conta_macchine
  ];
  return $ris;
}

function tellMeFlottaSede($sede){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT DISTINCT `flotta` FROM `macchina` WHERE `flotta` != '' AND `sede` = '$sede'") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeFlotta(){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT DISTINCT `flotta` FROM `macchina` WHERE `flotta` != ''") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeMacchineSedeDataLike($sede, $data, $cosa, $like){
  $time = strtotime("-2 year", time());
  $anno = date("Y", $time);
  if(!is_string($data)){
    $data = $data->format('Y-m-d');
  }
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` WHERE `sede` = '$sede' AND `flotta` LIKE '$like'  AND `$cosa` LIKE '$data%'  ORDER BY `macchina`.`data_arrivo` ASC") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeMacchineSedeLike($sede, $like){
  $time = strtotime("-2 year", time());
  $anno = date("Y", $time);
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` WHERE `sede` = '$sede' AND `flotta` LIKE '$like' ORDER BY `macchina`.`data_arrivo` ASC") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeVettore($idmacchina){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT vettori FROM `bolla` where id_veicoli like '%\"$idmacchina\"%';") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeMacchineSedeData($sede, $data, $cosa){
  $time = strtotime("-2 year", time());
  $anno = date("Y", $time);
  if(!is_string($data)){
    $data = $data->format('Y-m-d');
  }
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` WHERE `sede` = '$sede' AND `flotta` LIKE 'ald'  AND `$cosa` LIKE '$data%'  ORDER BY `macchina`.`data_arrivo` ASC") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeMacchineSede($sede){
  $time = strtotime("-2 year", time());
  $anno = date("Y", $time);
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` WHERE `sede` = '$sede' AND `flotta` LIKE 'ald'  ORDER BY `macchina`.`data_arrivo` ASC") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function aggiungiPiazzale($var){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $quer = "INSERT INTO `piazzali`(`denominazione`, `sede`) VALUES (".
  "'".addslashes($var[0])."',".
  "'".$var[1]."')";
  $cec =  mysqli_query($connString, $quer) or die("database error:". mysqli_error($connString));
}

function aggiungiSede($var){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $quer = "INSERT INTO `sedi`(`codice`, `attiva`, `descrizione`, `via`, `citta`, `prov`, `numero`, `cap`, `telefono`, `mail`) VALUES (".
  "'".$var[0]."',".
  "'TRUE',".
  "'".$var[1]."',".
  "'".$var[2]."',".
  "'".$var[3]."',".
  "'".$var[5]."',".
  "'".$var[4]."',".
  "'".$var[6]."',".
  "'".$var[7]."',".
  "'".$var[8]."')";
  $cec =  mysqli_query($connString, $quer) or die("database error:". mysqli_error($connString));

  $quer2 = "INSERT INTO `ultima_bolla`(`sede`, `slug`, `progressivo`) VALUES ('".$var[0]."','".$var[9]."','".$var[10]."')";
  $cec2 =  mysqli_query($connString, $quer2) or die("database error:". mysqli_error($connString));

}

function aggiornaMacchina($id, $campo, $valore){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $quer = "UPDATE `macchina` SET `$campo`= '$valore' WHERE `id` = '$id'";
  $cec =  mysqli_query($connString, $quer) or die("database error:". mysqli_error($connString));

  return $quer;
}

function aggiornaPiazzale($id, $campo, $valore){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $quer = "UPDATE `piazzali` SET `$campo`= '$valore' WHERE `id` = '$id'";
  $cec =  mysqli_query($connString, $quer) or die("database error:". mysqli_error($connString));

  return $quer;
}

function aggiornaSede($id, $campo, $valore){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $quer = "UPDATE `sedi` SET `$campo`= '$valore' WHERE `codice` = '$id'";
  $cec =  mysqli_query($connString, $quer) or die("database error:". mysqli_error($connString));

  return $quer;
}

function aggiornaSedeb($id, $campo, $valore){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $quer = "UPDATE `ultima_bolla` SET `$campo` = '$valore' WHERE `sede` = '$id'";
  $cec =  mysqli_query($connString, $quer) or die("database error:". mysqli_error($connString));
}

function aggiornaLavorazioniMacchina($id, $lavorazione, $valore){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `lavorazioni` WHERE `id_macchina` = '$id'") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  switch($lavorazione){
    case ('smontaggio'):{
      $lav = 'smontaggio_targhe';
      if($valore != 0) {$val = 3;}else{$val = 0;}
      break;
    }
    case ('lavaggio'):{
      $lav = 'lavaggio';
      if($valore != 0) {$val = 6;}else{$val = 0;}
      break;
    }
    case ('lavaggioest'):{
      $lav = 'lavaggio_est_int';
      if($valore != 0) {$val = 10;}else{$val = 0;}
      break;
    }
    case ('foto'):{
      $lav = 'foto';
      if($valore != 0) {$val = 10;}else{$val = 0;}
      break;
    }
    case ('appbase'):{
      $lav = 'appbase';
      if($valore != 0) {$val = 1;}else{$val = 0;}
      break;
    }
    case ('apppremium'):{
      $lav = 'apppremium';
      if($valore != 0) {$val = 1;}else{$val = 0;}
      break;
    }
    
  }
  if(!$ris){
    $quer = "INSERT INTO `lavorazioni`(`id_macchina`, `$lav`) VALUES ($id, $val)";
  }else{
    $quer = "UPDATE `lavorazioni` SET `$lav`= $val WHERE `id_macchina` = '$id'";
  }
  $cec =  mysqli_query($connString, $quer) or die("database error:". mysqli_error($connString));
  return $ris;
}

function tellMeLavorazioniMacchina($id){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `lavorazioni` WHERE `id_macchina` = '$id'") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  if(!$ris){
    $ris = 'no';
  }
  return $ris;
}

function tellMeDettagliSede($id){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `sedi` WHERE `codice` = '$id'") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeIdBolla($progressivo){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `bolla` WHERE `progressivo` = '$progressivo'") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeDettagliBolla($id){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `bolla` WHERE `id` = $id") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeMacchineBolla($ids){
  $macc = '';
  $cont = 0;
  $len = count($ids) - 1;
  foreach($ids as $v){
    if($cont == $len){
      $macc = $macc."$v";
      $cont++;
    }else{
      $macc = $macc."$v, ";
      $cont++;
    }
  }

  $query = "SELECT * FROM `macchina` WHERE `id` IN ($macc)";
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, $query) or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function query_preliminare($query){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, $query) or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return count($ris);
}
function tellMeTotaleBolle($sede = ""){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  if($sede != ''){
    $add = "where `sede` = '$sede'";
  }else{
    $add = "";
  }
  $bll=  mysqli_query($connString, 'SELECT COUNT(*) as numero FROM `bolla` ' . $add);
  
  $ris = mysqli_fetch_all($bll);

  return $ris[0][0];
}

function tellMeBolle($query){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, $query) or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeModelli(){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT `model` FROM `car_models`") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeMarche(){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT `make` FROM `car_makes`") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeCarForDDT($sede){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` WHERE `sede` = '$sede' AND `data_uscita` IS NULL") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMeProgressivo($sede){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `ultima_bolla` WHERE `sede` = '$sede'") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMePiazzaliSEDE($sede){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `piazzali` WHERE `sede` = '$sede'") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMePiazzali(){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `piazzali`") or die("database error:". mysqli_error($connString));
  $ris = mysqli_fetch_all($cec);
  return $ris;
}

function tellMePiazzale($id){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `piazzali` where piazzali.id = $id") or die("database error:". mysqli_error($connString));
  $row = mysqli_fetch_assoc($cec);
  $nome = $row['denominazione'];
	return $nome;
}

function tellMeTotaleLavorazioni($sede = ""){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  if($sede != ''){
    $add = "where `sede` = '$sede'";
  }else{
    $add = "";
  }
  $bll=  mysqli_query($connString, 'SELECT COUNT(*) as numero FROM `macchina` ' . $add);
  
  $ris = mysqli_fetch_all($bll);

  return $ris[0][0];
}

function tellMeTotaleAutoNuove($sede = ""){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  if($sede != ''){
    $add = "and `sede` = '$sede'";
  }else{
    $add = "";
  }
  $bll=  mysqli_query($connString, 'SELECT COUNT(*) as numero FROM `macchina` where `tipo_veicolo` = "NUOVO" and `data_uscita` IS NULL ' . $add);
  
  $ris = mysqli_fetch_all($bll);
  
  return $ris[0][0];
}

function tellMeTotaleAutoinsede($sede = ""){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  if($sede != ''){
    $add = "and `sede` = '$sede'";
  }else{
    $add = "";
  }
  $bll=  mysqli_query($connString, 'SELECT COUNT(*) as numero FROM `macchina` where  `tipo_veicolo` = "USATO" and `data_uscita` IS NULL ' . $add);
  
  $ris = mysqli_fetch_all($bll);
  
  return $ris[0][0];
}

function tellMeTotaleAutosede($sede = ""){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  if($sede != ''){
    $add = "and `sede` = '$sede'";
  }else{
    $add = "";
  }
  $bll=  mysqli_query($connString, 'SELECT COUNT(*) as numero FROM `macchina` where `data_uscita` IS NULL ' . $add);
  
  $ris = mysqli_fetch_all($bll);
  
  return $ris[0][0];
}

function tellMeTotaleAutonuovo($sede = ""){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  if($sede != ''){
    $add = "and `sede` = '$sede'";
  }else{
    $add = "";
  }
  $bll=  mysqli_query($connString, 'SELECT COUNT(*) as numero FROM `macchina` where `tipo_veicolo` = "NUOVO" ' . $add);
  
  $ris = mysqli_fetch_all($bll);
  
  return $ris[0][0];
}

function tellMeTotaleAutousato($sede = ""){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  if($sede != ''){
    $add = "and `sede` = '$sede'";
  }else{
    $add = "";
  }
  $bll=  mysqli_query($connString, 'SELECT COUNT(*) as numero FROM `macchina` where `tipo_veicolo` = "USATO" ' . $add);
  
  $ris = mysqli_fetch_all($bll);
  
  return $ris[0][0];
}

function tellMeTotaleAuto_($sede = ""){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  if($sede != ''){
    $add = "where `sede` = '$sede'";
  }else{
    $add = "";
  }
  $bll=  mysqli_query($connString, 'SELECT COUNT(*) as numero FROM `macchina` ' . $add);
  
  $ris = mysqli_fetch_all($bll);
  
  return $ris[0][0];
}

function tellMeCarsLavorazioni($query){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, $query) or die("database error:". mysqli_error($connString));
  // $ris = mysqli_fetch_all($cec);
  $macchine = array();
  $cont = 0;
  while($row = mysqli_fetch_assoc($cec)){
    $macchine[$cont] = $row;
    $cont++;
  }
	return $macchine;
}

function tellMeCarsLavorazioni_OLD($paginator, $offset, $ricerca = ''){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` ORDER BY `macchina`.`data_arrivo` DESC LIMIT " . $offset . ", " . $paginator ) or die("database error:". mysqli_error($connString));
  // $cec =  mysqli_query($connString, "SELECT * FROM `macchina` WHERE `data_uscita` IS NULL ORDER BY `macchina`.`data_arrivo` DESC") or die("database error:". mysqli_error($connString));
  
  $macchine = array();
  $cont = 0;
  while($row = mysqli_fetch_assoc($cec)){
    $macchine[$cont] = $row;
    $cont++;
  }
	return $macchine;
}

function tellMeCarsCancellazione(){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  // $cec =  mysqli_query($connString, "SELECT * FROM `macchina` ORDER BY `macchina`.`data_arrivo` DESC") or die("database error:". mysqli_error($connString));
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` WHERE `bolla_uscita` = ''") or die("database error:". mysqli_error($connString));
  
  $macchine = array();
  $cont = 0;
  while($row = mysqli_fetch_assoc($cec)){
    $macchine[$cont] = $row;
    $cont++;
  }
	return $macchine;
}

function tellMeCarsCancellazioneBolla(){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` WHERE `bolla_uscita` != ''") or die("database error:". mysqli_error($connString));
  
  $macchine = array();
  $cont = 0;
  while($row = mysqli_fetch_assoc($cec)){
    $macchine[$cont] = $row;
    $cont++;
  }
	return $macchine;
}

function togliUscitaEBolla($id){
  $db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "UPDATE `macchina` SET `data_uscita`= NULL,`bolla_uscita`='' WHERE `id` = $id") or die("database error:". mysqli_error($connString));
  $testo = "Veicolo Aggiornato";
	return $testo;
}

function togliMacchinaDaBolla($id_veicolo, $id_macchine, $id_bolla){
  $db = new dbObj();
  $connString =  $db->getConnstring();

  if(count($id_macchine) > 1){
    $macchine = json_encode(togliKeydaArray($id_macchine, $id_veicolo));
    $cec =  mysqli_query($connString, "UPDATE `bolla` SET `id_veicoli`= '$macchine' WHERE `id` = $id_bolla") or die("database error:". mysqli_error($connString));
    $testo = "Bolla Aggiornata";
  }else{
    $cec =  mysqli_query($connString, "DELETE FROM `bolla` WHERE `id` = $id_bolla") or die("database error:". mysqli_error($connString));
    $testo = "Bolla Eliminata";
  }

	return $testo;
}

function tellMeCarsLavorazioniOLD(){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  // $cec =  mysqli_query($connString, "SELECT * FROM `macchina` ORDER BY `macchina`.`data_arrivo` DESC") or die("database error:". mysqli_error($connString));
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` WHERE `data_uscita` IS NULL ORDER BY `macchina`.`data_arrivo` DESC") or die("database error:". mysqli_error($connString));
  
  $macchine = array();
  $cont = 0;
  while($row = mysqli_fetch_assoc($cec)){
    $macchine[$cont] = $row;
    $cont++;
  }
	return $macchine;
}

function tellMeCars(){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cars = mysqli_query($connString, 'SELECT COUNT(*) as numero FROM `macchina`');
  if($cars['numero'] > 10){
    $limit = 'LIMIT 11, 10';
  }else{
    $limit = '';
  }
  $cec =  mysqli_query($connString, "SELECT * FROM `macchina` ORDER BY `macchina`.`data_arrivo` $limit DESC") or die("database error:". mysqli_error($connString));
  
  $macchine = array();
  $cont = 0;
  while($row = mysqli_fetch_assoc($cec)){
    $macchine[$cont] = $row;
    $cont++;
  }
	return $macchine;
}

function tellMeSedeUser($username){
	$db = new dbObj();
  $connString =  $db->getConnstring();
  $cec =  mysqli_query($connString, "SELECT login.sedi FROM `login` where login.username = '$username'") or die("database error:". mysqli_error($connString));
	$row = mysqli_fetch_assoc($cec);
	return $row['sedi'];
}

function formattaDataLogin($data){
  if($data == "0000-00-00 00:00:00"){
    return "";
  }else if($data == NULL){

  }else{
    $right = date('d/m/Y H:i', strtotime($data));
    return $right;
  }
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

function tellMeSedi(){
		$db = new dbObj();
		$connString = $db->getConnstring();
		$cec = mysqli_query($connString, "SELECT * FROM `sedi` WHERE `attiva` = 'TRUE'") or die("database error:" . mysqli_error($connString));
		$i = 0;
		while ($row = mysqli_fetch_assoc($cec)) {
			$sede[$i]['codice'] = $row['codice'];
			$sede[$i]['nome'] = $row['descrizione'];
			$sede[$i]['descrizione'] = $row['descrizione'];
			$sede[$i]['via'] = $row['via'];
			$sede[$i]['citta'] = $row['citta'];
			$sede[$i]['prov'] = $row['prov'];
			$sede[$i]['numero'] = $row['numero'];
			$sede[$i]['cap'] = $row['cap'];
			$sede[$i]['telefono'] = $row['telefono'];
			$sede[$i]['email'] = $row['mail'];
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

function togliKeydaArray($array, $val){
  $cont = 0;
  foreach($array as $x => $y){
    if($y != $val){
      $retarray[$cont] = $y;
      $cont ++;
    }
  }
  return $retarray;
}

function filtra_stringa(string $string): string
{
    $str = preg_replace('/\x00|<[^>]*>?/', '', $string);
    return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
}