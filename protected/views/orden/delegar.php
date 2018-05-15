<?php
$this->breadcrumbs=array(
	'Delegar Solicitud',
);

	$this->menu=array(
	  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
	  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
	  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
	  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
	);


?>

<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'tipo-compra-grid',
	'dataProvider'=>$empleados->search_negociador(),
	'type'=>'striped bordered condensed',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		'nombre_completo',
		array( 
			'class'=>'bootstrap.widgets.BootButtonColumn', 
			'template' => '{delegar}',
			'buttons'=>array(
				'delegar' => array(
					'url'=>'Yii::app()->createUrl("orden/delegar", array("id"=>'.$model->id.', "id_responsable" => $data[id]))',
					'icon' => 'hand-right'
				),
			),
		),
	),
)); ?>