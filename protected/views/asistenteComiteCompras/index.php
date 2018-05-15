<?php
$this->breadcrumbs=array(
	'Asistente Comite Compras',
);

$this->menu=array(
	array('label'=>'Create AsistenteComiteCompras','url'=>array('create')),
	array('label'=>'Manage AsistenteComiteCompras','url'=>array('admin')),
);
?>

<h1>Asistente Comite Compras</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
