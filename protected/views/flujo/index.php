<?php
$this->breadcrumbs=array(
	'Flujos',
);

$this->menu=array(
array('label'=>'Create Flujo','url'=>array('create')),
array('label'=>'Manage Flujo','url'=>array('admin')),
);
?>

<h1>Flujos</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
