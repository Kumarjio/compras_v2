<?php
$this->breadcrumbs=array(
	'Vinculacion Proveedor Juridico'=>array('admin'),
	'Recepcion de Documentos'
);


$this->menu=array(
  array('label'=>'Home','url'=>array('/orden/admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('/proveedor/_recepcion_documentos_juridico', array('model' => $model->proveedor, 'vpj' => $model), true); ?>