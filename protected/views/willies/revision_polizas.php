<?php
$this->breadcrumbs=array(
	'Willis'=>array('admin'),
	'Revisión de Pólizas'
);


$this->menu=array(
  array('label'=>'Home','url'=>array('/orden/admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('_revision_polizas', array('model' => $model->proveedor, 'w' => $model, 'dvpj' => $documentos, 'archivos_w' => $archivos), true); ?>