<?php
$this->breadcrumbs=array(
	'Documento Proveedor'=>array('admin'),
	$model->id_docpro=>array('view','id'=>$model->id_docpro),
	'Actualizar',
);


$this->menu=array(
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Actualizar','url'=>array('update','id'=>$model->id_docpro),'icon'=>'edit'),
  array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_docpro),'confirm'=>'Está seguro que desea eliminar este registro?')),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>