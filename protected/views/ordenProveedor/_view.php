<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_orden')); ?>:</b>
	<?php echo CHtml::encode($data->id_orden); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nit')); ?>:</b>
	<?php echo CHtml::encode($data->nit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proveedor')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('path_adjunto')); ?>:</b>
	<?php echo CHtml::encode($data->path_adjunto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->observaciones); ?>
	<br />

	*/ ?>

</div>