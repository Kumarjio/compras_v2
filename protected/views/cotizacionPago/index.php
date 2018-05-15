<?php
$this->breadcrumbs=array(
	'Cotizacion Pago',
);

$this->menu=array(
	array('label'=>'Create CotizacionPago','url'=>array('create')),
	array('label'=>'Manage CotizacionPago','url'=>array('admin')),
);
?>

<h1>Cotizacion Pago</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
