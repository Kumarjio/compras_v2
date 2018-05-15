<?php Yii::import('ext.phpexcel.Classes.PHPExcel');
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0) 
            ->setCellValue('A1', 'Número de referencia') //campo vacio
			->setCellValue('B1', 'Ciudad/Cód DANE de Origen') //campo vacio
			->setCellValue('C1', 'Numero de Guia') //campo vacio
			->setCellValue('D1', 'Tiempo de Entrega')// datos fijos
			->setCellValue('E1', 'Generar Sobreporte')//datos fijos
			->setCellValue('F1', 'Documento de Identificación')//campos vacios
			->setCellValue('G1', 'Nombre del Destinatario')//campos variables
			->setCellValue('H1', 'Dirección')// campos variables
			->setCellValue('I1', 'Ciudad/Cód DANE de destino')//campos variables
			->setCellValue('J1', 'Departamento')//campos variables
			->setCellValue('K1', 'Teléfono')//campos variables
			->setCellValue('L1', 'Correo electrónico Destinatario')//campos vacios
			->setCellValue('M1', 'Celular')//campos vacios
			->setCellValue('N1', 'Nombre de la Unidad de Empaque')//campos fijos
			->setCellValue('O1', 'Dice Contener')//campos variables
			->setCellValue('P1', 'Valor declarado')//campos fijos
			->setCellValue('Q1', 'Numero de Piezas')//campos campos fijos
			->setCellValue('R1', 'Cantidad')//campos fijos
			->setCellValue('S1', 'Remisión')//campos vacios
			->setCellValue('T1', 'Alto')//campos fijos
			->setCellValue('U1', 'Ancho')//campos fijos
            ->setCellValue('V1', 'Largo')//campos fijos
            ->setCellValue('W1', 'Peso')//campos fijos
            ->setCellValue('X1', 'Producto')//campos fijos
            ->setCellValue('Y1', 'Forma de Pago')//campos fijos
            ->setCellValue('Z1', 'Medio de Transporte')//campos fijos
            ->setCellValue('AA1', 'Generar Cajaporte')//campos fijos
            ->setCellValue('AB1', 'Unidad de Longitud')//campos fijos
            ->setCellValue('AC1', 'Unidad de Peso')//campos fijos
            ->setCellValue('AD1', 'Campo personalizado 1')//campos variables
            ->setCellValue('AE1', 'Factura');//campos variables

$objPHPExcel->getActiveSheet()->setTitle('Servientrega'); //nombre del libro
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
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle("A1:AE1")->getFont()->setBold(true); //Configuracion letra, titulos ms-excel
$objPHPExcel->getActiveSheet() ->getStyle('A1:AE1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet() ->getStyle('A2:AE2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet() ->getStyle('A:AE')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$BStyle = array(
  	'borders' => array(
    	'allborders' => array(
      		'style' => PHPExcel_Style_Border::BORDER_THIN
  		)   
  	)
);

$objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->applyFromArray($BStyle); 

$objPHPExcel->getActiveSheet() //Color Celdas A1 - C1 blanco
			->getStyle('A1:C1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('FFFBFB');

$objPHPExcel->getActiveSheet() //Color Celdas D1 - E1 Amarillo
			->getStyle('D1:E1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('DFDF00');

$objPHPExcel->getActiveSheet() // Color Celdas F1 blanco
			->getStyle('F1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('FFFBFB');

$objPHPExcel->getActiveSheet() // Color Celdas G1 - K1 Azul Rey
			->getStyle('G1:K1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('005DA9');

$objPHPExcel->getActiveSheet() // Color Celdas F1 blanco
			->getStyle('L1:M1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('FFFBFB');

$objPHPExcel->getActiveSheet() // Color Celdas F1 Amarillo
			->getStyle('N1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('DFDF00');

$objPHPExcel->getActiveSheet() // Color Celdas F1 Azul Rey
			->getStyle('O1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('005DA9');

$objPHPExcel->getActiveSheet() // Color Celdas F1 Amarillo
			->getStyle('P1:R1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('DFDF00');

$objPHPExcel->getActiveSheet() // Color Celdas F1 blanco
			->getStyle('S1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('FFFBFB');

$objPHPExcel->getActiveSheet() // Color Celdas F1 Amarillo
			->getStyle('T1:AC1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('DFDF00');

$objPHPExcel->getActiveSheet() // Color Celdas F1 Azul Rey
			->getStyle('AD1:AE1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('005DA9');
$fila = 2;
$entrega = 1;
$sobreporte = 0;
$unidad = "GENERICA";
$valor_declarado = 5000;
$dimensiones = 12;
$formapago =  2;
$longitud = "CM";
$peso = "KG";

foreach ($model as $consulta) {
	$objPHPExcel->getActiveSheet()->SetCellValue("D".$fila, $entrega);
	$objPHPExcel->getActiveSheet()->SetCellValue("E".$fila, $sobreporte);
	$objPHPExcel->getActiveSheet()->SetCellValue("G".$fila, strtoupper($consulta->idCartas->nombre_destinatario));
	$objPHPExcel->getActiveSheet()->SetCellValue("H".$fila, strtoupper($consulta->direccion));
	$objPHPExcel->getActiveSheet()->SetCellValue("I".$fila, strtoupper($consulta->idCartas->na0->ciudad0->ciudad));
	$objPHPExcel->getActiveSheet()->SetCellValue("J".$fila, strtoupper($consulta->idCartas->na0->ciudad0->departamento));
	$objPHPExcel->getActiveSheet()->SetCellValue("K".$fila);
	$objPHPExcel->getActiveSheet()->SetCellValue("N".$fila, $unidad);
	$objPHPExcel->getActiveSheet()->SetCellValue("O".$fila, strtoupper($consulta->idCartas->na0->tipologia0->area0->area)); 
	$objPHPExcel->getActiveSheet()->SetCellValue("P".$fila, $valor_declarado);
	$objPHPExcel->getActiveSheet()->SetCellValue("Q".$fila, $entrega);
	$objPHPExcel->getActiveSheet()->SetCellValue("R".$fila, $entrega);
	$objPHPExcel->getActiveSheet()->SetCellValue("T".$fila, $dimensiones);
	$objPHPExcel->getActiveSheet()->SetCellValue("U".$fila, $dimensiones);
	$objPHPExcel->getActiveSheet()->SetCellValue("V".$fila, $dimensiones);
	$objPHPExcel->getActiveSheet()->SetCellValue("W".$fila, $entrega);
	$objPHPExcel->getActiveSheet()->SetCellValue("X".$fila, $entrega);
	$objPHPExcel->getActiveSheet()->SetCellValue("Y".$fila, $formapago);
	$objPHPExcel->getActiveSheet()->SetCellValue("Z".$fila, $dimensiones);
	$objPHPExcel->getActiveSheet()->SetCellValue("AA".$fila, $campo_cajaporte);
	$objPHPExcel->getActiveSheet()->SetCellValue("AB".$fila, $longitud);
	$objPHPExcel->getActiveSheet()->SetCellValue("AC".$fila, $peso);
	$objPHPExcel->getActiveSheet()->SetCellValue("AD".$fila, $consulta->idCartas->na);
	$objPHPExcel->getActiveSheet()->SetCellValue("AE".$fila, strtoupper($consulta->idCartas->na0->tipologia0->tipologia));

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
	$objPHPExcel->getActiveSheet()->getStyle("L".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("M".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("N".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("O".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("P".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("Q".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("R".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("S".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("T".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("U".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("V".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("W".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("X".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("Y".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("Z".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("AA".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("AB".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("AC".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("AD".$fila)->applyFromArray($BStyle);
	$objPHPExcel->getActiveSheet()->getStyle("AE".$fila)->applyFromArray($BStyle);
	CartasFisicas::actualizaPunteo($consulta->idCartas->id);
	$fila++;
}
// Redirect output to a clientâ€™s web browser (Excel5)
$name="Firma Fisica ".date("d-m-Y h:i A").".xls";
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

?>