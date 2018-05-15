<?php
$this->breadcrumbs=array(
	'Documento Proveedor',
);

$this->menu=array(
	array('label'=>'Create DocumentoProveedor','url'=>array('create')),
	array('label'=>'Manage DocumentoProveedor','url'=>array('admin')),
);
?>

<h1>Documento Proveedor</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
