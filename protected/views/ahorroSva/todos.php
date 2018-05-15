<?php
$this->breadcrumbs=array(
	'Cotizacion'
);

$this->menu=array(
	array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ahorro-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h2>Informe Ahorro SVA</h2><br>
<?php 
    echo CHtml::link("Ordenes con Ahorro", Yii::app()->createUrl("ahorroSva/admin")).'   '; 
?>
<?php echo CHtml::link("Descargar Informe", Yii::app()->createUrl("ahorroSva/excel")); ?>

<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'ahorro-grid',
	'dataProvider'=>$model->search_todos(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		array(
		      'header' => 'Número de solicitud',
		      'name' => 'orden',
		      'type' => 'raw',
		      //'value' => '"<a href=\"update/id/".$data->id."\">".$data->id."</a>"',
		      'value' => 'CHtml::link($data->orden, Yii::app()->createUrl("orden/print", array("orden"=>$data->orden)))'
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
                    'type'=>'number',
                    'htmlOptions'=>array('style' => 'text-align: right;')
                ),
		array(
                    'name' => 'alta',
                    'type'=>'number',
                    'htmlOptions'=>array('style' => 'text-align: right;')
                ),
		array(
                    'name' => 'ahorro',
                    'type'=>'number',
                    'htmlOptions'=>array('style' => 'text-align: right;')
                ),
		array(
                    'header'=>'%',
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
