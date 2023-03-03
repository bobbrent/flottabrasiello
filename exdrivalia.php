<?php 
require_once ('vendor/autoload.php');
include 'parts/pages/fun.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

$sedes = $_GET['sede'];
$like = $_GET['like'];
$dettagli = tellMeDettagliSede($sedes);
$sede = $dettagli[0][7];
$macchine = tellMeMacchineSedeLike($sedes, $like);

if(isset($_GET['data'])){
  $datare = $_GET['data'];
  $inventario = inventario($macchine, $datare);
  $date = new DateTime($datare);

  $data = $date->format('d/m/Y');
  $data_1 = $date->modify('-1 day')->format('d/m/Y');
  $data_2 = $date->modify('-1 day')->format('d/m/Y');
  $data_3 = $date->modify('-1 day')->format('d/m/Y');
  $data_4 = $date->modify('-1 day')->format('d/m/Y');
  $datas = new DateTime($datare);
  $datanome = $datas->format('d-m-Y');  
}else{
  $inventario = inventario($macchine);
  $date = new DateTime(date('Y-m-d'));

  $data = $date->format('d/m/Y');
  $data_1 = $date->modify('-1 day')->format('d/m/Y');
  $data_2 = $date->modify('-1 day')->format('d/m/Y');
  $data_3 = $date->modify('-1 day')->format('d/m/Y');
  $data_4 = $date->modify('-1 day')->format('d/m/Y');
  $datas = new DateTime(date('Y-m-d'));
  $datanome = $datas->format('d-m-Y');  
}
// echo "<pre>";
// print_r($inventario);
// echo "</pre>";

// 0 $nuovo_oggi,
// 1 $nuovo_oggi_1,
// 2 $nuovo_oggi_2,
// 3 $nuovo_oggi_3,
// 4 $nuovo_oggi_4,
// 5 $nuovo_oggi_uscite,
// 6 $nuovo_oggi_1_uscite,
// 7 $nuovo_oggi_2_uscite,
// 8 $nuovo_oggi_3_uscite,
// 9 $nuovo_oggi_4_uscite,
// 10 $usato_oggi,
// 11 $usato_oggi_1,
// 12 $usato_oggi_2,
// 13 $usato_oggi_3,
// 14 $usato_oggi_4,
// 15 $usato_oggi_uscite,
// 16 $usato_oggi_1_uscite,
// 17 $usato_oggi_2_uscite,
// 18 $usato_oggi_3_uscite,
// 19 $usato_oggi_4_uscite,
// 20 $stock_nuovo,
// 21 $stock_usato,

// 22 $conta_arrivi_macchine_nuove_oggi,
// 23 $conta_arrivi_macchine_nuove_oggi_1,
// 24 $conta_arrivi_macchine_nuove_oggi_2,
// 25 $conta_arrivi_macchine_nuove_oggi_3,
// 26 $conta_arrivi_macchine_nuove_oggi_4,
// 27 $conta_arrivi_macchine_usate_oggi,
// 28 $conta_arrivi_macchine_usate_oggi_1,
// 29 $conta_arrivi_macchine_usate_oggi_2,
// 30 $conta_arrivi_macchine_usate_oggi_3,
// 31 $conta_arrivi_macchine_usate_oggi_4,

// 32 $conta_uscite_macchine_nuove_oggi,
// 33 $conta_uscite_macchine_nuove_oggi_1,
// 34 $conta_uscite_macchine_nuove_oggi_2,
// 35 $conta_uscite_macchine_nuove_oggi_3,
// 36 $conta_uscite_macchine_nuove_oggi_4,
// 37 $conta_uscite_macchine_usate_oggi,
// 38 $conta_uscite_macchine_usate_oggi_1,
// 39 $conta_uscite_macchine_usate_oggi_2,
// 40 $conta_uscite_macchine_usate_oggi_3,
// 41 $conta_uscite_macchine_usate_oggi_4 
// 42 tot_macchine


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

$stilenuovo = [
  'font' => [
      'bold' => false,
  ],
  'alignment' => [
      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
  ],
  'fill' => [
      'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
      'startColor' => [
          'argb' => 'FF9E9C9F',
      ],
      'endColor' => [
          'argb' => 'FF9E9C9F',
      ],
  ]
];

$stileusato = [
  'font' => [
      'bold' => false,
  ],
  'alignment' => [
      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
  ],
  'fill' => [
      'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
      'startColor' => [
          'argb' => 'FFBFBFBF',
      ],
      'endColor' => [
          'argb' => 'FFBFBFBF',
      ],
  ]
];

$ultima = [
  'font' => [
      'bold' => true,
  ],
  'alignment' => [
      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
  ],
  'fill' => [
      'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
      'startColor' => [
          'argb' => 'FFBF8F00',
      ],
      'endColor' => [
          'argb' => 'FFBF8F00',
      ],
  ]
];

$spreadsheet = new Spreadsheet();   
$Excel_writer = new Xls($spreadsheet);  

$spreadsheet->setActiveSheetIndex(0);

//PRIMA PAGINA
$activeSheet = $spreadsheet->getActiveSheet()->setTitle("RIEPILOGO");
$activeSheet->setCellValue('D1' , $sede)->getStyle('D1')->getFont()->setBold(true);

// oggi
$activeSheet->setCellValue('C2' , $data);

$stock1 = $inventario[22] - $inventario[32];
$stock2 = $inventario[27] - $inventario[37];
$activeSheet->setCellValue('C3' , count($inventario[0]));
$activeSheet->setCellValue('C4' , count($inventario[5]));
$activeSheet->setCellValue('C5' , $stock1);
$activeSheet->setCellValue('C7' , count($inventario[10]));
$activeSheet->setCellValue('C8' , count($inventario[15]));
$activeSheet->setCellValue('C9' , $stock2);

$stock = 2500 - $stock1 - $stock2;
$activeSheet->setCellValue('C11' , $stock);

//oggi - 1
$activeSheet->setCellValue('D2' , $data_1);

$stock1 = $inventario[23] - $inventario[33];
$stock2 = $inventario[28] - $inventario[38];
$activeSheet->setCellValue('D3' , count($inventario[1]));
$activeSheet->setCellValue('D4' , count($inventario[6]));
$activeSheet->setCellValue('D5' , $stock1 );

$activeSheet->setCellValue('D7' , count($inventario[11]));
$activeSheet->setCellValue('D8' , count($inventario[16]));
$activeSheet->setCellValue('D9' , $stock2);

$stock = 2500 - $stock1 - $stock2;
$activeSheet->setCellValue('D11' , $stock);

//OGGI - 2
$activeSheet->setCellValue('E2' , $data_2);

$stock1 = $inventario[24] - $inventario[34];
$stock2 = $inventario[29] - $inventario[39];
$activeSheet->setCellValue('E3' , count($inventario[2]));
$activeSheet->setCellValue('E4' , count($inventario[7]));
$activeSheet->setCellValue('E5' , $stock1 );

$activeSheet->setCellValue('E7' , count($inventario[12]));
$activeSheet->setCellValue('E8' , count($inventario[17]));
$activeSheet->setCellValue('E9' , $stock2);

$stock = 2500 - $stock1 - $stock2;
$activeSheet->setCellValue('E11' , $stock);

//OGGI - 3
$activeSheet->setCellValue('F2' , $data_3);

$stock1 = $inventario[25] - $inventario[35];
$stock2 = $inventario[30] - $inventario[40];
$activeSheet->setCellValue('F3' , count($inventario[3]));
$activeSheet->setCellValue('F4' , count($inventario[8]));
$activeSheet->setCellValue('F5' , $stock1 );

$activeSheet->setCellValue('F7' , count($inventario[13]));
$activeSheet->setCellValue('F8' , count($inventario[18]));
$activeSheet->setCellValue('F9' , $stock2);

$stock = 2500 - $stock1 - $stock2;
$activeSheet->setCellValue('F11' , $stock);

//OGGI - 4
$activeSheet->setCellValue('G2' , $data_4);

$stock1 = $inventario[26] - $inventario[36];
$stock2 = $inventario[31] - $inventario[41];
$activeSheet->setCellValue('G3' , count($inventario[4]));
$activeSheet->setCellValue('G4' , count($inventario[9]));
$activeSheet->setCellValue('G5' , $stock1 );

$activeSheet->setCellValue('G7' , count($inventario[14]));
$activeSheet->setCellValue('G8' , count($inventario[19]));
$activeSheet->setCellValue('G9' , $stock2);

$stock = 2500 - $stock1 - $stock2;
$activeSheet->setCellValue('G11' , $stock);


$activeSheet->setCellValue('B3' , 'arrivi');
$activeSheet->setCellValue('B4' , 'uscite');
$activeSheet->setCellValue('B5' , 'stock');
$activeSheet->setCellValue('B7' , 'arrivi');
$activeSheet->setCellValue('B8' , 'uscite');
$activeSheet->setCellValue('B9' , 'stock');
$activeSheet->setCellValue('A4' , 'NUOVO');
$activeSheet->setCellValue('A8' , 'USATO');
$activeSheet->setCellValue('A11' , 'DISPONIBILITÀ TOTALE');

$spreadsheet->getActiveSheet()->getStyle('A2:G2')->applyFromArray($stiletop);
$spreadsheet->getActiveSheet()->getStyle('A3:G3')->applyFromArray($stilenuovo);
$spreadsheet->getActiveSheet()->getStyle('A4:G4')->applyFromArray($stilenuovo);
$spreadsheet->getActiveSheet()->getStyle('A5:G5')->applyFromArray($stilenuovo);
$spreadsheet->getActiveSheet()->getStyle('A7:G7')->applyFromArray($stileusato);
$spreadsheet->getActiveSheet()->getStyle('A8:G8')->applyFromArray($stileusato);
$spreadsheet->getActiveSheet()->getStyle('A9:G9')->applyFromArray($stileusato);
$spreadsheet->getActiveSheet()->getStyle('A11:G11')->applyFromArray($ultima);
$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);

//SECONDA PAGINA
$spreadsheet->createSheet(); 
$spreadsheet->setActiveSheetIndex(1);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('A1', 'TIPO VEICOLO')->getStyle('A1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('B1', 'TELAIO/TARGA')->getStyle('B1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('C1', 'MODELLO')->getStyle('C1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('D1', 'KM')->getStyle('D1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('E1', 'DATA E ORA ARRIVO')->getStyle('E1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('F1', 'DATA E ORA USCITA')->getStyle('F1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('G1', 'DEPOSITO')->getStyle('G1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('H1', 'NOTE')->getStyle('H1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('I1', 'SMONTAGGIO TARGHE')->getStyle('I1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('J1', 'LAVAGGIO')->getStyle('J1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('K1', 'LAVAGGIO ESTERNO/INTERNO')->getStyle('K1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('L1', 'FOTO')->getStyle('L1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('M1', 'APP. BASE')->getStyle('M1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('N1', 'APP. PREMIUM')->getStyle('N1')->getFont()->setBold(true);
$spreadsheet->setActiveSheetIndex(1)->setCellValue('O1', 'VETTORE')->getStyle('O1')->getFont()->setBold(true);


$contariga = 2;
foreach($macchine as $v){
  $spreadsheet->setActiveSheetIndex(1)->setCellValue("A$contariga", $v[3]);
//   if($v[4]){
//     $spreadsheet->setActiveSheetIndex(1)->setCellValue("B$contariga", $v[4]);
// }else{
//     $spreadsheet->setActiveSheetIndex(1)->setCellValue("B$contariga", $v[5]);
//   }
  $telaiotarga = $v[4]." ".$v[5];
  $spreadsheet->setActiveSheetIndex(1)->setCellValue("B$contariga", $telaiotarga);
  $modello = $v[6]." ".$v[7];
  $spreadsheet->setActiveSheetIndex(1)->setCellValue("C$contariga", $modello);
  // Aggiunta km 04/08/2021
  $spreadsheet->setActiveSheetIndex(1)->setCellValue("D$contariga", $v[11]);

  $spreadsheet->setActiveSheetIndex(1)->setCellValue("E$contariga", formattaDataLogin($v[9]));
  if($v[19]){
    $spreadsheet->setActiveSheetIndex(1)->setCellValue("F$contariga", formattaDataLogin($v[19]));
  }
  $spreadsheet->setActiveSheetIndex(1)->setCellValue("G$contariga", tellMePiazzale($v[1]));
  $spreadsheet->setActiveSheetIndex(1)->setCellValue("H$contariga", $v[21]);
  $lav = tellMeLavorazioniMacchina($v[0]);
  if($lav != 'no'){
      if($lav[0][2] != 0){
        $spreadsheet->setActiveSheetIndex(1)->setCellValue("I$contariga", $lav[0][2]);
      }
      if($lav[0][3] != 0){
        $spreadsheet->setActiveSheetIndex(1)->setCellValue("J$contariga", $lav[0][3]);
      }
      if($lav[0][4] != 0){
        $spreadsheet->setActiveSheetIndex(1)->setCellValue("K$contariga", $lav[0][4]);
      }
      if($lav[0][5] != 0){
        $spreadsheet->setActiveSheetIndex(1)->setCellValue("L$contariga", $lav[0][5]);
      }
      if($lav[0][6] != 0){
        $spreadsheet->setActiveSheetIndex(1)->setCellValue("M$contariga", $lav[0][6]);
      }
      if($lav[0][7] != 0){
        $spreadsheet->setActiveSheetIndex(1)->setCellValue("N$contariga", $lav[0][7]);
      }
  }
  $spreadsheet->setActiveSheetIndex(1)->setCellValue("O$contariga", tellMeVettore($v[0]));
  $contariga++;
}

//FILTRI COLONNE
$spreadsheet->getActiveSheet()->setAutoFilter('A1:O1');

//INTESTAZIONE
$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(30);
$spreadsheet->getActiveSheet()->getStyle('A1:L1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
//NOME FOGLIO
$spreadsheet->getActiveSheet()->setTitle("STOCK");


//SETTO ATTIVO IL PRIMO FOGLIO
$spreadsheet->setActiveSheetIndex(0);

$nome_file = "INVENTARIO STOCK $like - $datanome";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nome_file.'.xls"');  
header('Cache-Control: max-age=0');
$Excel_writer->save('php://output');