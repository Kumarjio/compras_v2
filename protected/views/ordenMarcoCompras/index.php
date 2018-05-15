<?php
$this->breadcrumbs=array(
	'Orden Marco Comprases',
);

$this->menu=array(
array('label'=>'Create OrdenMarcoCompras','url'=>array('create')),
array('label'=>'Manage OrdenMarcoCompras','url'=>array('admin')),
);
?>

<h1>Orden Marco Comprases</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
