<?php
$this->breadcrumbs=array(
	'Adjuntos Cotizacion',
);

$this->menu=array(
	array('label'=>'Create AdjuntosCotizacion','url'=>array('create')),
	array('label'=>'Manage AdjuntosCotizacion','url'=>array('admin')),
);
?>

<h1>Adjuntos Cotizacion</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
