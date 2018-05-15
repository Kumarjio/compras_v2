<?php
$this->breadcrumbs=array(
	'Vicepresidencias',
);

$this->menu=array(
	array('label'=>'Create Vicepresidencias','url'=>array('create')),
	array('label'=>'Manage Vicepresidencias','url'=>array('admin')),
);
?>

<h1>Vicepresidencias</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
