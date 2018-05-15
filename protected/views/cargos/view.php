<?php
$this->breadcrumbs=array(
	'Cargos'=>array('admin'),
	$model->id,
);

$this->menu=array(
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
  //array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

?>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
		array(
			'name'=>'id_jefatura',
			'value'=>$model->idJefatura->nombre
		),
		array(
			'name'=>'id_gerencia',
			'value'=>$model->idGerencia->nombre
		),
		array(
			'name'=>'id_vice',
			'value'=>$model->idVice->nombre
		),
		array(
			'name'=>'es_jefe',
			'type'=>'raw',
			'value'=>($model->es_jefe == "Si")?CHtml::tag("a",array("class"=>"icon-ok")): "",
			'htmlOptions'=>array(
				'style' =>'	text-align: center;
							vertical-align: middle;
						    width: 8%;',
			)
		),
		array(
			'name'=>'es_gerente',
			'type'=>'raw',
			'value'=>($model->es_gerente == "Si")?CHtml::tag("a",array("class"=>"icon-ok")): "",
			'htmlOptions'=>array(
				'style' =>'	text-align: center;
							vertical-align: middle;
						    width: 8%;',
			)
		),
		array(
			'name'=>'es_vice',
			'type'=>'raw',
			'value'=>($model->es_vice == "Si")?CHtml::tag("a",array("class"=>"icon-ok")): "",
			'htmlOptions'=>array(
				'style' =>'	text-align: center;
							vertical-align: middle;
						    width: 8%;',
			)
		),
	),
)); ?>
