<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('producto_orden')); ?>:</b>
	<?php echo CHtml::encode($data->producto_orden); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nit')); ?>:</b>
	<?php echo CHtml::encode($data->nit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_unitario')); ?>:</b>
	<?php echo CHtml::encode($data->valor_unitario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_compra')); ?>:</b>
	<?php echo CHtml::encode($data->total_compra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('elegido_compras')); ?>:</b>
	<?php echo CHtml::encode($data->elegido_compras); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('elegido_usuario')); ?>:</b>
	<?php echo CHtml::encode($data->elegido_usuario); ?>
	<br />

	*/ ?>

</div>