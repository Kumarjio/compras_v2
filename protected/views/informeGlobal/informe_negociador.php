<?php
$this->breadcrumbs=array(
	'Cotizacion'
);
?>

<h2>Informe Ahorro CYC</h2><br>
<?php
$this->menu=array(
	array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
	array('label'=>'Volver','url'=>array('admin'), 'icon'=>'chevron-left'),
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

<div class="col-lr-12">
    
    <p>
            <?php echo CHtml::link("Descargar Informe", $this->createUrl("excelNegociador", $model->attributes)); ?>
    </p>
</div>

<?php 
$this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'ahorro-grid-cyc',
	'dataProvider'=>$informe_cyc->search_avanzado($model),
	'type'=>'striped bordered condensed',
	'enableSorting'=>false,
	'ajaxUrl'=>Yii::app()->createUrl('hola'),
    'ajaxUpdate'=>true,
    'beforeAjaxUpdate'=>'aFunctionThatWillBeCalled',
	//'filter'=>$informe_cyc,
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
		      'type' => 'raw',
		      'htmlOptions'=>array('style' => 'text-align: right;'),
		      'value'=>'$data->tipo.Orden::model()->tipoNegociacionSpan($data->negociacion_directa)'
		),
		array(
		      'header' => 'Descripción de la compra',
		      'name' => 'compra',
		      'htmlOptions'=>array('style' => 'text-align: right;')
		      ),

        array(
            'name'=>'nombre',
            'value'=>'$data->getNombre()'
        ),
		
		array(
                    'name' => 'fecha',
                    'value'=>'date("Y-m-d", strtotime($data->fecha))'
                ),
		array(
                    'name' => 'promedio',
                    'type'=>'number',
                    'htmlOptions'=>array('style' => 'text-align: right;')
                ),
		array(
                    'name' => 'selecionada',
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
		      'htmlOptions'=>array('style' => 'text-align: right;')
		      ),
		array(
		      'header' => 'trm',
		      'name' => 'trm',
		      'htmlOptions'=>array('style' => 'text-align: right;')
		      ),
		array(
		      'header' => 'negociador',
		      'name' => 'negociante',
		      'htmlOptions'=>array('style' => 'text-align: right;')
		      ),
		
	),
)); 

Yii::app()->clientScript->registerScript('some-script-id','function aFunctionThatWillBeCalled(id, data){
    console.log("id is "+id);
    return false;
    // your jquery code to remember checked rows
}');


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
    //echo CHtml::link("Todas Las Ordenes", Yii::app()->createUrl("ahorroSva/todos", array("todas" => true))).'   '; 
?>
<?php //echo CHtml::link("Descargar Informe", Yii::app()->createUrl("ahorroSva/excel")); ?>

<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'ahorro-grid-sva',
	'dataProvider'=>$informe_sva->search_avanzado($model),
	'type'=>'striped bordered condensed',
	'enableSorting'=>false,
	//'filter'=>$informe_sva,
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
		      'htmlOptions'=>array('style' => 'text-align: right;')
		      ),

		array(
		      'header' => 'Descripcion de la compra',
		      'name' => 'compra',
		      'htmlOptions'=>array('style' => 'text-align: right;')
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
		      'htmlOptions'=>array('style' => 'text-align: right;')
		      ),
		array(
		      'header' => 'trm',
		      'name' => 'trm',
		      'htmlOptions'=>array('style' => 'text-align: right;')
		      ),
		array(
		      'header' => 'negociador',
		      'name' => 'negociante',
		      'htmlOptions'=>array('style' => 'text-align: right;')
		      ),
	),
)); ?>
