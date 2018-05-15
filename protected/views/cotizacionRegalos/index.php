<?php
$this->breadcrumbs=array(
	'Cotizacion Regalos',
);

$this->menu=array(
	array('label'=>'Create CotizacionRegalos','url'=>array('create')),
	array('label'=>'Manage CotizacionRegalos','url'=>array('admin')),
);
?>

<h1>Cotizacion Regalos</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
