<?php
header('Content-Description: File Transfer');
header("Content-type: application/vnd.ms-excel");
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header("Content-disposition: attachment; filename=Informe_ahorro_SVA.xls");

?>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'ahorro-grid',
        'dataProvider'=>$model->search_excel(),
        'enableSorting'=>false,
        'summaryText'=>'',
	'columns'=>array(
		array(
		      'header' => 'Número de solicitud',
		      'name' => 'orden',
		      ),

        array(
                 'header' => 'Tipo de compra',
                'name' => 'tipo',
              ),
        array(
                'header' => 'Descripcion de la compra',
                'name' => 'compra',
              ),
                array(
                    'name'=>'proveedor',
                    'value'=>'$data->getProveedor()'
                ),
                array(
                    'name'=>'fecha',
                    'value'=>'date("Y-m-d",strtotime($data->fecha))',
                ),
		array(
                    'name' => 'selecionada',
                    'value'=>  'str_replace(".", ",", $data->selecionada)'
                ),
		array(
                    'name' => 'alta',
                    'value'=>'str_replace(".", ",", $data->alta)'
                ),
		array(
                    'name' => 'ahorro',
                    'value'=>'str_replace(".", ",", $data->ahorro)'
                ),
		array(
                    'name' => 'porcentaje',//Yii::app()->numberFormatter->formatPercentage(
                    'value'=>  'Yii::app()->numberFormatter->formatNumber(array("maxDecimalDigits"=>2, "multiplier"=>1, "negativePrefix"=>"(","negativeSuffix"=>")"),$data->porcentaje) . "%"',
                    'htmlOptions'=>array('style' => 'text-align: right;')
                ),
        array(
              'header' => 'moneda',
              'name' => 'moneda',
              ),
        array(
              'header' => 'trm',
              'name' => 'trm',
              ),
        array(
              'header' => 'negociador',
              'name' => 'negociante',
              ),
	),
)); ?>
    </body>
</html>