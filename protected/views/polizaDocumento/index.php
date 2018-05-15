<?php
$this->breadcrumbs=array(
	'Poliza Documento',
);

$this->menu=array(
	array('label'=>'Create PolizaDocumento','url'=>array('create')),
	array('label'=>'Manage PolizaDocumento','url'=>array('admin')),
);
?>

<h1>Poliza Documento</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
