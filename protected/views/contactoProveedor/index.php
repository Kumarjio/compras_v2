<?php
$this->breadcrumbs=array(
	'Contacto Proveedor',
);

$this->menu=array(
	array('label'=>'Create ContactoProveedor','url'=>array('create')),
	array('label'=>'Manage ContactoProveedor','url'=>array('admin')),
);
?>

<h1>Contacto Proveedor</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
