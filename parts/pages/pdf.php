<?php

require '../lib/fpdf.php';
include '../parts/pages/fun.php';
// $da = "01/11/2018";
// $a = "30/11/2018";
$data = date("d/m/Y");

  if($da != ''){
    if($a != ''){
      define("nomepagina", "Nps da $da a $a");
    }else{
      define("nomepagina", "Nps $a");
    }


    $c = include '../config/data.php';

    $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $da = formatFata($da);
    if ($a != '') {
        $a = formatFata($a);
        $sql = "SELECT * FROM `lime_survey_804856` WHERE `804856X13X94` >= '$da' AND `804856X13X94` <= '$a'  AND `804856X13X91` IS NOT NULL AND `804856X13X91` != '' AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL  AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    } else {
        $sql = "SELECT * FROM `lime_survey_804856` WHERE `804856X13X94` = '$da'  AND `804856X13X91` IS NOT NULL AND `804856X13X91` != '' AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL  AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    }
    if (!$result = $mysqli->query($sql)) {
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    }
    //echo $da.' '.$a;
    $valor = array();
    while ($result->fetch_assoc()) {
        $i = 0;
        foreach ($result as $row => $val) {
            $valor[$i] = $val;
            $i++;
        }
    }

    $valori = keyUnivoche($valor, 'ipaddr');
    $valori = keyUnivoche($valori, '804856X13X106');


    $codici = array();
    $v = 0;
    foreach($valori as $val){
      $codici[$v] = $valori[$v]['804856X13X91'];
      $v++;
    }
    $codici = array_unique($codici);

    $risultati = array();
    foreach($codici as $cod){
      $cont = 0;
      foreach($valori as $ec){
        if ($ec['804856X13X91'] === $cod){
          $risultati[$cod][$cont] = valuTacsat($ec['804856X13X81SQ001']);
          $cont++;
        }
      }
    }

    $js = array();
    $coco = 0;
    $totale = 0;
    $totalev = 0;
    $pros = array();
    $nes = array();
    foreach($risultati as $sed => $dati){
      foreach ($dati as $nps){
        if(valuTa($nps) == 1){
          $pros[] = 1;
          $nes[] = 0;
        }else if(valuTa($nps) == -1){
          $nes[] = -1;
          $pros[] = 0;
        }else{
          $pros[] = 0;
          $nes[] = 0;
        }
      }
      $ff = array();
      $numero = count($pros);
      $newNps = 0;

      for($x = 0;$x <$numero;$x++){
        $newNps = $newNps + $pros[$x] + $nes[$x];
      }
      $newsNps = ($newNps/$numero)*100;
      foreach($dati as $cc){
        $ff[] = valuta2($cc);
      }
      $js[$coco]["sede"] = $sed;
      $js[$coco]["nps"] = NPS_($ff);

      $js[$coco]["votis"] = $ff;
      $js[$coco]["totale"] = array_sum($dati);
      $js[$coco]["voti"] = count($ff);


      $totale += $js[$coco]["totale"];
      $totalev += $js[$coco]["voti"];
      $js[$coco]["csat"] = round(csat(array_sum($dati), count($ff)), 2);
      $coco++;
    }
    $passive = 100 - promoter($pros) - abs(detractor($nes));
  }


define("logo", "../img/logo.png");
define("data", "Data: ".$data);

class PDF extends FPDF{
    public function Header()
    {
        //LOGO
        $this->Image(logo, 12, 12, 50);
        //HEAD
        $this->SetFont('Helvetica', 'B', 15);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 15, nomepagina, 0, 0, 'R');
        $this->SetFont('Helvetica', '', 15);
        $this->Ln(10);
        $this->Cell(0, 15, data, 0, 0, 'R');
        $this->Ln(20);

    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}



$pdf = new PDF('P', 'mm', 'A4');
$coloretesto = [0,0,0];


$pdf->AddPage();
$pdf->AliasNbPages();

//CORPO
$pdf->SetTextColor($coloretesto[0], $coloretesto[1], $coloretesto[2]);
$pdf->Ln(20);

$pdf->SetFont('Helvetica', '', 11);

$pdf->Write(6, 'NPS: ');
$pdf->SetFont('Helvetica', 'B', 12);

$pdf->Write(6, str_replace(',', '.', NPS_val($valori)));
$pdf->Ln(7);

$pdf->SetFont('Helvetica', '', 11);
$pdf->SetFont('Helvetica', 'B', 12);

$pdf->Write(6, "Detractor: ".abs(detractor($nes))."% | Passive: ".$passive."% | Promoter ".promoter($pros)."%");

$pdf->SetFont('Helvetica', 'B', 12);

//TABELLA
$pdf->Ln(15);
$pdf->Cell(70, 6, "SEDE", 1);
$pdf->Cell(20, 6, "CSAT%", 1);
$pdf->Cell(20, 6, "N.VOTI", 1);
$pdf->Cell(20, 6, "NPS", 1);
$pdf->Cell(30, 6, "PROMOTER", 1);
$pdf->Cell(30, 6, "DETRACTOR", 1);
$pdf->Ln(7);

$pdf->SetFont('Helvetica', '', 11);

foreach($js as $dati){
  $sede = troncaProd(ssSede($dati['sede']), 27);
  $pro = promoter($dati['votis'])."%";
  $no = abs(detractor($dati['votis']))."%";

  $pdf->Ln(7);
  $pdf->Cell(70, 6, $sede, 1);
  $pdf->Cell(20, 6, $dati['csat'], 1);
  $pdf->Cell(20, 6, $dati['voti'], 1);
  $pdf->SetFont('Helvetica', 'B', 11);

  $pdf->Cell(20, 6, $dati['nps'], 1);
  $pdf->SetFont('Helvetica', '', 11);

  $pdf->Cell(30, 6, $pro, 1);
  $pdf->Cell(30, 6, $no, 1);
}

$pdf->Ln(30);


$pdf->SetFont('Helvetica', 'B', 15);


$pdf->SetFont('Helvetica', '', 12);
$pdf->Ln(12);

$datapdf = date('d-m-Y');
$file = "../nps/nps_riepilogo_$datapdf.pdf";
// $file = $_SERVER['DOCUMENT_ROOT'] . "/nps/nps/nps_riepilogo_$datapdf.pdf";

// $file = $_SERVER['DOCUMENT_ROOT']."/nps/nps/nps_$datapdf.pdf";
// $s = 0;
// for($i = 1; $s < 1; $i++){
//   if (file_exists($file)) {
//     $file = $_SERVER['DOCUMENT_ROOT'] . "/nps/nps/nps_$datapdf($i).pdf";
//   }else{
//     $s = 2;
//   }
// }

$pdf->Output($file, "F");
// $pdf->Output($_SERVER['DOCUMENT_ROOT']."/ordini/$id.pdf", "F");



function valuTa($nume){
    $num = trim($nume, 'A');
    if ($num > 0 && $num < 8) {
        return -1;
    } else if ($num > 7 && $num < 10) {
        return 0;
    } else if ($num > 9 && $num < 12) {
        return 1;
    }
}

function valuTa2($nume){
    $num = trim($nume, 'A');
    if ($num > -1 && $num < 7) {
        return -1;
    } else if ($num > 6 && $num < 9) {
        return 0;
    } else if ($num > 8 && $num < 11) {
        return 1;
    }
}

function valuTacsat($nume){
    // $num = trim($nume, 'A');
    if ($nume == null) {
        return 0;
    } else {
        $num = trim($nume, 'A');
        return $num - 1;
    }

    // return $num - 1;
}

function formatFata($string){
    $dat_1 = explode('/', $string);
    $giusta = "$dat_1[2]-$dat_1[1]-$dat_1[0]";
    return $giusta;
}

function formatFato($string){
    $dat_1 = explode('-', $string);
    $giusta = "$dat_1[2]/$dat_1[1]/$dat_1[0]";
    return $giusta;
}

function ssUtent($ut){
    $c = include 'config/data.php';

    $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $sqlI = "SELECT `nome_cognome` FROM `utenti` WHERE `id` = '$ut'";

    if (!$resultS = $mysqli->query($sqlI)) {
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    } else {
        $row = $resultS->fetch_assoc();
        return $row['nome_cognome'];
    }
}

function ssSede($ut){
    $c = include '../config/data.php';

    $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $sqlI = "SELECT `descrizione` FROM `sedi` WHERE `codice` = '$ut'";

    if (!$resultS = $mysqli->query($sqlI)) {
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    } else {
        $row = $resultS->fetch_assoc();
        return $row['descrizione'];
    }
}

function NPS_val($val){
    $x = 0;
    $totp = 0;
    $totn = 0;
    foreach ($val as $d) {
        $voto = valuTa2($d['804856X13X81SQ001']);
        if ($voto == 1) {
            $totp = $totp + $voto;
        } else if ($voto == -1) {
            $totn = $totn + $voto;
        }
        $x++;
    }

    if ($totp == 0) {
        $totp = 0;
    } else {
        $totp = ($totp / $x) * 100;
    }
    if ($totn == 0) {
        $totn = 0;
    } else {
        $totn = ($totn / $x) * 100;
    }

    $NPS = $totp + $totn;
    return round($NPS, 2);

}

function NPS_vals($val){
    $x = 0;
    $totp = 0;
    $totn = 0;
    foreach ($val as $d) {
        $voto = valuTa2($d['voto']);
        if ($voto == 1) {
            $totp = $totp + $voto;
        } else if ($voto == -1) {
            $totn = $totn + $voto;
        }
        $x++;
    }

    if ($totp == 0) {
        $totp = 0;
    } else {
        $totp = ($totp / $x) * 100;
    }
    if ($totn == 0) {
        $totn = 0;
    } else {
        $totn = ($totn / $x) * 100;
    }
    $NPS = $totp + $totn;
    return round($NPS, 2);
}

function NPS_($val){
    $x = 0;
    $totp = 0;
    $totn = 0;
    foreach ($val as $d) {
        $voto = $d;
        if ($voto == 1) {
            $totp = $totp + $voto;
        } else if ($voto == -1) {
            $totn = $totn + $voto;
        }
        $x++;
    }
    if ($totp == 0) {
        $totp = 0;
    } else {
        $totp = ($totp / $x) * 100;
    }
    if ($totn == 0) {
        $totn = 0;
    } else {
        $totn = ($totn / $x) * 100;
    }
    $NPS = $totp + $totn;
    return round($NPS, 2);
}

function promoter($val){
    $x = 0;
    $tot = 0;
    foreach ($val as $d) {
        if ($d == 1) {
            $tot = $tot + 1;
        }
        $x++;
    }
    $x = count($val);
    if ($tot == 0) {
        $tot = 0;
    } else {
        $tot = ($tot / $x) * 100;
    }
    return round($tot, 2);
}

function detractor($val){
    $x = 0;
    $tot = 0;
    foreach ($val as $d) {
        if ($d == -1) {
            $tot = $tot + $d;
        }
        $x++;
    }

    if ($tot == 0) {
        $tot = 0;
    } else {
        $tot = ($tot / $x) * 100;
    }
    return round($tot, 2);
}

function csat($t, $tv){
    $CSAT = ($t / $tv) * 10;
    return $CSAT;
}

function selPick($da, $a){
    $c = include 'config/data.php';

    $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $da = formatFata($da);
    if ($a != '') {
        $a = formatFata($a);
        $sqlI = "SELECT DISTINCT 804856X13X108  as id from lime_survey_804856 WHERE `804856X13X94` >= '$da' AND `804856X13X94` <= '$a'  AND `804856X13X91` IS NOT NULL AND `804856X13X91` != '' AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL  AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    } else {
        $sqlI = "SELECT DISTINCT 804856X13X108  as id from lime_survey_804856 WHERE `804856X13X94` = '$da'  AND `804856X13X91` IS NOT NULL AND `804856X13X91` != '' AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL  AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    }

    if (!$resultS = $mysqli->query($sqlI)) {
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    } else {
        while ($res = $resultS->fetch_assoc()) {
            foreach ($res as $row) {
                if (is_numeric($row)) {
                    $ids[] = $row;
                }
            }
        }

    }
    if (isset($ids)) {
        return $ids;
    } else {
        $ids = '';
        return $ids;
    }

}

function selDrop($da, $a){
    $c = include 'config/data.php';

    $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $da = formatFata($da);
    if ($a != '') {
        $a = formatFata($a);
        $sqlI = "SELECT DISTINCT 804856X13X107  as id from lime_survey_804856 WHERE `804856X13X94` >= '$da' AND `804856X13X94` <= '$a'  AND `804856X13X91` IS NOT NULL AND `804856X13X91` != '' AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL  AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    } else {
        $sqlI = "SELECT DISTINCT 804856X13X107  as id from lime_survey_804856 WHERE `804856X13X94` = '$da'  AND `804856X13X91` IS NOT NULL AND `804856X13X91` != '' AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL  AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    }

    if (!$resultS = $mysqli->query($sqlI)) {
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    } else {
        while ($res = $resultS->fetch_assoc()) {
            foreach ($res as $row) {
                if (is_numeric($row)) {
                    $ids[] = $row;
                }

            }
        }

    }
    if (isset($ids)) {
        return $ids;
    } else {
        $ids = '';
        return $ids;
    }

}

function mediaVotiDrop($id){
    $c = include 'config/data.php';

    $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $sqlI = "SELECT `804856X13X81SQ001` FROM `lime_survey_804856` WHERE `804856X13X107` = $id AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    $i = 0;

    $voti = array();

    if (!$resultS = $mysqli->query($sqlI)) {
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    } else {
        while ($res = $resultS->fetch_assoc()) {
            foreach ($res as $ec) {
                $v[] = $ec;
                $voti[$i] = valuTacsat($ec);
                $i++;
            }
        }

    }
    if (count($voti) > 0) {
        $vots = array_sum($voti);
        $media = $vots / $i;
        return round($media, 2);
    } else {
        return 0;
    }

}

function numerovotidrop($id){
    $c = include 'config/data.php';

    $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $sqlI = "SELECT `804856X13X81SQ001` FROM `lime_survey_804856` WHERE `804856X13X107` = $id AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    $i = 0;

    $voti = array();

    if (!$resultS = $mysqli->query($sqlI)) {
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    } else {
        while ($res = $resultS->fetch_assoc()) {
            foreach ($res as $ec) {
                $voti[$i] = valuTacsat($ec);

                $i++;
            }
        }

    }
    if (count($voti) > 0) {
        return count($voti);
    } else {
        return 0;
    }

}

function numerovotipick($id){
    $c = include 'config/data.php';

    $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $sqlI = "SELECT `804856X13X81SQ001` FROM `lime_survey_804856` WHERE `804856X13X108` = $id AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    $i = 0;

    $voti = array();

    if (!$resultS = $mysqli->query($sqlI)) {
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    } else {
        while ($res = $resultS->fetch_assoc()) {
            foreach ($res as $ec) {
                $voti[$i] = valuTacsat($ec);

                $i++;
            }
        }

    }
    if (count($voti) > 0) {
        return count($voti);
    } else {
        return 0;
    }

}

function mediaVotiPick($id){
    $c = include 'config/data.php';

    $mysqli = new mysqli($c['host'], $c['username'], $c['password'], $c['database']);

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $sqlI = "SELECT `804856X13X81SQ001` FROM `lime_survey_804856` WHERE `804856X13X108` = $id AND `804856X13X94` IS NOT NULL AND `804856X13X81SQ001` IS NOT NULL AND `804856X13X106` IS NOT NULL AND `lastpage` >= 1 ORDER BY `lime_survey_804856`.`startdate` ASC";
    $i = 0;
    $voti = array();
    if (!$resultS = $mysqli->query($sqlI)) {
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    } else {
        while ($res = $resultS->fetch_assoc()) {
            foreach ($res as $ec) {
                $v[] = $ec;
                $voti[$i] = valuTacsat($ec);
                $i++;
            }
        }

    }
    if (count($voti) > 0) {
        $vots = array_sum($voti);
        $media = $vots / $i;
        return round($media, 2);
    } else {
        return 0;
    }
}

function keyUnivoche($array, $uniqueKey){
    $unique = array();
    foreach ($array as $value) {
        $unique[$value[$uniqueKey]] = $value;
    }
    return array_values($unique);
}

?>
<section class="wrapper site-min-height">
	<h3><i class="fa fa-angle-right"></i> Scarica Riepilogo NPS</h3>
	<div class="row mt">
		<div class="col-lg-12">
			<a href="<?php
			$num = strlen ( $_SERVER['DOCUMENT_ROOT'] );
			$nom = substr($file, 17);

			echo "nps/nps_riepilogo_$datapdf.pdf";?>" target="_blank"> File </a>
		</div>
	</div>
</section>
