<?php Yii::import('ext.phpexcel.Classes.PHPExcel');
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0) 
            ->setCellValue('A1', 'NOMBRE DESTINATARIO') //campo variable
			->setCellValue('B1', 'DIRECCION') //campo variable
			->setCellValue('C1', 'CIUDAD') //campo variable
			->setCellValue('D1', 'REFERENCIA')// campo vacio
			->setCellValue('E1', 'PESO')//campos fijos
			->setCellValue('F1', 'VALOR DECLARADO')//campos fijos
			->setCellValue('G1', 'LARGO')//campos fijos
			->setCellValue('H1', 'ANCHO')// campos fijos
			->setCellValue('I1', 'ALTO')//campos fijos
			->setCellValue('J1', 'CONTENIDO')//campos variables
			->setCellValue('K1', 'OBSERVACIONES');//campos variables
			
$objPHPExcel->getActiveSheet()->setTitle('Correspondencia 472'); //nombre del libro
$objPHPExcel->setActiveSheetIndex(0); //Dimesiones de las columnas

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFont()->setBold(true); //Configuracion letra, titulos ms-excel

$objPHPExcel->getActiveSheet() ->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet() ->getStyle('A2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet() ->getStyle('A:K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$BStyle = array(
		'borders' => array(
		'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			)   
		)
);

$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($BStyle); 

$objPHPExcel->getActiveSheet() //Color Celdas A1 - C1 blanco
			->getStyle('A1:k1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('979797');
$fila = 2;
$campo_peso = 200;
$campo_valordeclarado = 1000;
$campo_dimension = 2;

foreach ($model as $consulta) {
	$objPHPExcel->getActiveSheet()->SetCellValue("A".$fila, strtoupper($consulta->idCartas->nombre_destinatario)); 
	$objPHPExcel->getActiveSheet()->SetCellValue("B".$fila, strtoupper($consulta->direccion));
	$objPHPExcel->getActiveSheet()->SetCellValue("C".$fila, strtoupper($consulta->idCartas->na0->ciudad0->ciudad));
	$objPHPExcel->getActiveSheet()->SetCellValue("D".$fila, ''); //null 
	$objPHPExcel->getActiveSheet()->SetCellValue("E".$fila, $campo_peso);
	$objPHPExcel->getActiveSheet()->SetCellValue("F".$fila, $campo_valordeclarado);
	$objPHPExcel->getActiveSheet()->SetCellValue("G".$fila, $campo_dimension);
	$objPHPExcel->getActiveSheet()->SetCellValue("H".$fila, $campo_dimension);
	$objPHPExcel->getActiveSheet()->SetCellValue("I".$fila, $campo_dimension);
	$objPHPExcel->getActiveSheet()->SetCellValue("J".$fila, $consulta->idCartas->na); 
 	$objPHPExcel->getActiveSheet()->SetCellValue("K".$fila, strtoupper($consulta->idCartas->na0->tipologia0->tipologia)." - ".strtoupper($consulta->idCartas->na0->tipologia0->area0->area));

 	$objPHPExcel->getActiveSheet()->getStyle("A".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("B".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("C".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("D".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("E".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("F".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("G".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("H".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("I".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("J".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("K".$fila)->applyFromArray($BStyle);	
	CartasFisicas::actualizaPunteo($consulta->idCartas->id);
	$fila++;
}
// Redirect output to a clientâ€™s web browser (Excel5)
$name="Firma Fisica 472 ".date("d-m-Y h:i A").".xls";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$name.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
Yii::app()->end();
exit;
?>