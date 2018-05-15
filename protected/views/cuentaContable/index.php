<?php
$this->breadcrumbs=array(
	'Cuenta Contable',
);

$this->menu=array(
	array('label'=>'Create CuentaContable','url'=>array('create')),
	array('label'=>'Manage CuentaContable','url'=>array('admin')),
);
?>

<h1>Cuenta Contable</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
