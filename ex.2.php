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

$macchine = tellMeMacchineSedeData($sedes, $date, 'data_uscita');
$inventario = inventario($macchine);
$usato_oggi_uscita = $inventario[15];
// echo "<pre>";
// print_r($macchine);
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
$activeSheet->setCellValue('D1' , "Report vetture in uscita del $data")->getStyle('D1')->getFont()->setBold(true);

$activeSheet->setCellValue('A2', 'DESTINAZIONE')->getStyle('A1')->getFont()->setBold(true);
$activeSheet->setCellValue('B2', 'TARGA')->getStyle('B1')->getFont()->setBold(true);
$activeSheet->setCellValue('C2', 'TELAIO')->getStyle('C1')->getFont()->setBold(true);
$activeSheet->setCellValue('D2', 'MARCA')->getStyle('D1')->getFont()->setBold(true);
$activeSheet->setCellValue('E2', 'MODELLO')->getStyle('E1')->getFont()->setBold(true);
$activeSheet->setCellValue('F2', 'DATA E ORA USCITA')->getStyle('G1')->getFont()->setBold(true);
$activeSheet->setCellValue('G2', 'BOLLA SI/NO')->getStyle('H1')->getFont()->setBold(true);


$contariga = 3;
foreach($macchine as $v){
  if($v[3] == 'USATO'){
    $acc = ''; 
    
    if($v[10]){
      $bolla = 'si';
    }else{
      $bolla = 'no';
    }
    $bollas = tellMeIdBolla($v[20]);

    $destinatario = json_decode($bollas[0][5]);
    $destinazione = json_decode($bollas[0][6]);
    $desti = $destinatario[0]." | Via ".$destinazione[0]." n ".$destinazione[1].", (".$destinazione[2].") ".$destinazione[3];
    
    
    $activeSheet->setCellValue("A$contariga", $desti);
    $activeSheet->setCellValue("B$contariga", $v[4]);
    $activeSheet->setCellValue("C$contariga", $v[5]);
    $activeSheet->setCellValue("D$contariga", $v[6]);
    $activeSheet->setCellValue("E$contariga", $v[7]);
    $activeSheet->setCellValue("F$contariga", formattaDataLogin($v[19]));
    $activeSheet->setCellValue("G$contariga", $bolla);

    $contariga++;
  }
}

//FILTRI COLONNE
$spreadsheet->getActiveSheet()->setAutoFilter('A2:G2');

//INTESTAZIONE
$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(46);
$spreadsheet->getActiveSheet()->getStyle('A2:G2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);



//SETTO ATTIVO IL PRIMO FOGLIO
$spreadsheet->setActiveSheetIndex(0);
$datas = new DateTime(date('Y-m-d'));
$datanome = $datas->format('d-m-Y');   

$nome_file = "ALD USATO IN USCITA $datanome";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nome_file.'.xls"');  
header('Cache-Control: max-age=0');
$Excel_writer->save('php://output');

