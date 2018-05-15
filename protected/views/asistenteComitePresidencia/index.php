<?php
$this->breadcrumbs=array(
	'Asistente Comite Presidencia',
);

$this->menu=array(
	array('label'=>'Create AsistenteComitePresidencia','url'=>array('create')),
	array('label'=>'Manage AsistenteComitePresidencia','url'=>array('admin')),
);
?>

<h1>Asistente Comite Presidencia</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
