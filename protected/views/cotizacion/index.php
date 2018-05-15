<?php
$this->breadcrumbs=array(
	'Cotizacion',
);

$this->menu=array(
	array('label'=>'Crear Cotizacion','url'=>array('create')),
);
?>

<h1>Cotizacion</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
