<?php 
require_once ('vendor/autoload.php');
include 'parts/pages/fun.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

$sedes = $_GET['sede'];
$dettagli = tellMeDettagliSede($sedes);
$sede = $dettagli[0][7];

if(isset($_GET['data'])){
  $data = $_GET['data'];
  $date = $_GET['data'];
}else{
  $date = new DateTime(date('Y-m-d'));
  $data = $date->format('d/m/Y');
}

$macchine = tellMeMacchineSedeData($sedes, $date, 'data_arrivo');
$inventario = inventario($macchine);
$usato_oggi = $inventario[10];
// echo "<pre>";
// print_r($usato_oggi);
// echo "</pre>";


// 10 $usato_oggi,

// 15 $usato_oggi_uscite,




$stiletop = [
  'font' => [
      'bold' => true,
  ],
  'alignment' => [
      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
  ],
  'fill' => [
      'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
      'startColor' => [
          'argb' => 'FF00CCFF',
      ],
      'endColor' => [
          'argb' => 'FF00CCFF',
      ],
  ]
];


$spreadsheet = new Spreadsheet();   
$Excel_writer = new Xls($spreadsheet);  

$spreadsheet->setActiveSheetIndex(0);

//PRIMA PAGINA
$activeSheet = $spreadsheet->getActiveSheet()->setTitle("REPORT");
$activeSheet->setCellValue('D1' , "Report vetture in entrata del $data")->getStyle('D1')->getFont()->setBold(true);

$activeSheet->setCellValue('A2', 'PIAZZALE')->getStyle('A1')->getFont()->setBold(true);
$activeSheet->setCellValue('B2', 'TARGA')->getStyle('B1')->getFont()->setBold(true);
$activeSheet->setCellValue('C2', 'TELAIO')->getStyle('C1')->getFont()->setBold(true);
$activeSheet->setCellValue('D2', 'MARCA')->getStyle('D1')->getFont()->setBold(true);
$activeSheet->setCellValue('E2', 'MODELLO')->getStyle('E1')->getFont()->setBold(true);
$activeSheet->setCellValue('F2', 'COLORE')->getStyle('F1')->getFont()->setBold(true);
$activeSheet->setCellValue('G2', 'DATA E ORA ENTRATA')->getStyle('G1')->getFont()->setBold(true);
$activeSheet->setCellValue('H2', 'BOLLA SI/NO')->getStyle('H1')->getFont()->setBold(true);
$activeSheet->setCellValue('I2', 'KM')->getStyle('I1')->getFont()->setBold(true);
$activeSheet->setCellValue('J2', 'ELENCO_DANNI')->getStyle('J1')->getFont()->setBold(true);
$activeSheet->setCellValue('K2', 'CHIAVI')->getStyle('K1')->getFont()->setBold(true);


$contariga = 3;
foreach($macchine as $v){
  if($v[3] == 'USATO'){

  $acc = ''; 
  $acc = $acc." ".$v[21];
  $piazzale = tellMePiazzale($v[1]);
  if($v[10]){
    $bolla = 'si';
    }else{
    $bolla = 'no';
  }
  if($v[12]){
    $doppie = '2';
    }else{
    $doppie = '1';
  }
  $activeSheet->setCellValue("A$contariga", $piazzale);
  $activeSheet->setCellValue("B$contariga", $v[4]);
  $activeSheet->setCellValue("C$contariga", $v[5]);
  $activeSheet->setCellValue("D$contariga", $v[6]);
  $activeSheet->setCellValue("E$contariga", $v[7]);
  $activeSheet->setCellValue("F$contariga", $v[8]);
  $activeSheet->setCellValue("G$contariga", formattaDataLogin($v[9]));
  $activeSheet->setCellValue("H$contariga", $bolla);
  $activeSheet->setCellValue("I$contariga", $v[11]);
  $activeSheet->setCellValue("J$contariga", $acc);
  $activeSheet->setCellValue("K$contariga", $doppie);

  $contariga++;
  }
}

//FILTRI COLONNE
$spreadsheet->getActiveSheet()->setAutoFilter('A2:k2');

//INTESTAZIONE
$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(30);
$spreadsheet->getActiveSheet()->getStyle('A2:k2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);



//SETTO ATTIVO IL PRIMO FOGLIO
$spreadsheet->setActiveSheetIndex(0);
$datas = new DateTime(date('Y-m-d'));
$datanome = $datas->format('d-m-Y');   

$nome_file = "ALD USATO IN ENTRATA $datanome";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nome_file.'.xls"');  
header('Cache-Control: max-age=0');
$Excel_writer->save('php://output');

