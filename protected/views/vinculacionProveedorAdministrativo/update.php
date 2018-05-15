<?php
$this->breadcrumbs=array(
	'Vinculacion Proveedor Administrativo'=>array('admin')
);


$this->menu=array(
  array('label'=>'Home','url'=>array('/orden/admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('_recepcion_documentos', array('model' => $vpa->proveedor, 'vpa' => $vpa'dvpa' => $dvpa), true); ?>