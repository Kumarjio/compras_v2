<?php
$this->breadcrumbs=array(
	'Vinculacion Proveedor Administrativo'=>array('admin'),
	'Recepcion de Documentos'
);


$this->menu=array(
  array('label'=>'Home','url'=>array('/orden/admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('/proveedor/_recepcion_documentos', array('model' => $model->proveedor, 'vpa' => $model, 'dvpa' => $dvpa), true); ?>