<?php
$this->breadcrumbs=array(
	'Vinculacion Proveedor Juridico'=>array('admin'),
	'Revisión Contrato y Pólizas'
);


$this->menu=array(
  array('label'=>'Home','url'=>array('/orden/admin'),'icon'=>'home'),
);

?>


<?php echo $this->renderPartial('_revision_contrato', array('model' => $model->proveedor, 'vpj' => $model, 'dvpj' => $documentos, 'archivos' => $archivos), true); ?>