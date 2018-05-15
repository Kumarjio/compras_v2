<?php
$this->breadcrumbs=array(
	'Proveedor Miembros',
);

$this->menu=array(
	array('label'=>'Create ProveedorMiembros','url'=>array('create')),
	array('label'=>'Manage ProveedorMiembros','url'=>array('admin')),
);
?>

<h1>Proveedor Miembros</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
