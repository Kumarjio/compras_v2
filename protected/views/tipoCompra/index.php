<?php
$this->breadcrumbs=array(
	'Tipo Compra',
);

$this->menu=array(
	array('label'=>'Create TipoCompra','url'=>array('create')),
	array('label'=>'Manage TipoCompra','url'=>array('admin')),
);
?>

<h1>Tipo Compra</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
