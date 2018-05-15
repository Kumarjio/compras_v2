<?php
$this->breadcrumbs=array(
	'Solicitar cancelacion a compras',
);

$this->menu=array(
  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
  array('label'=>'Realizar Pedido','url'=>array('/Orden/realizarPedido', 'id' => $model->id),'icon'=>'headphones'),
  array('label'=>'Productos seleccionados','url'=>array('/detalleOrdenCompra/admin', 'id_orden' => $model->id),'icon'=>'tags'),
  array('label'=>'Ordenes de compra','url'=>array('/OrdenCompra/admin', 'id_orden' => $model->id),'icon'=>'list-alt'),
  array('label'=>'Solicitar cancelación','url'=>array('/orden/solicitarCancelacion', 'id' => $model->id),'icon'=>'remove-sign', 'visible' => $puede_editar),
);


?>

<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'orden-form',
	'enableAjaxValidation'=>false,
	)); ?>


<h2>Solicitar Cancelación de una compra aprobada</h2> 


<?php echo $form->errorSummary($model); ?>

<div class="well">	

		<div class="alert alert-block alert-warning fade in">

			<?php echo $form->textAreaRow($model,'observacion', array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
		</div>
</div>

<div class="form-actions">

<?php $this->widget('bootstrap.widgets.BootButton', array(
	'buttonType'=>'submit',
	'type'=>'primary',
	'label'=>'Enviar a cancelación')); ?>
</div>

<?php $this->endWidget() ?>