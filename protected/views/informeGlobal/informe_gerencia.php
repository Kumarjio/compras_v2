

<h2>Informe Por Gerencias</h2><br>

<div class="col-lr-12">
    
    <p>
            <?php echo CHtml::link("Descargar Informe", $this->createUrl("excelGerencia", $model->attributes)); ?>
    </p>
</div>
<?php  

$this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'ahorro-grid',
	'dataProvider'=>$informe_gerencia->search($model),
	'type'=>'striped bordered condensed',
	'enableSorting'=>false,
	//'filter'=>$informe_cyc,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		'id',
		array(
			'name'=>'nombre_compra',
			'footer'=>'TOTAL CONSULTA'
		),
		array(
			'name'=>'total',
			'footer'=>$informe_gerencia->sumar($model),
			'type'=>'number'
		),
		'fecha_solicitud',
		'negociacion_directa',
		'id_jefatura',
		'jefatura',
		'id_gerencia',
		'gerencia',
		'nit',
		
		
	),
)); 
