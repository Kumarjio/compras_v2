<?php
$this->breadcrumbs=array(
	'Familia Producto',
);

$this->menu=array(
	array('label'=>'Create FamiliaProducto','url'=>array('create')),
	array('label'=>'Manage FamiliaProducto','url'=>array('admin')),
);
?>

<h1>Familia Producto</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
