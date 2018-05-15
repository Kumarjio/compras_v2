<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proveedor')); ?>:</b>
	<?php echo CHtml::encode($data->id_proveedor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_orden_compra')); ?>:</b>
	<?php echo CHtml::encode($data->id_orden_compra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_unitario')); ?>:</b>
	<?php echo CHtml::encode($data->valor_unitario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_compra')); ?>:</b>
	<?php echo CHtml::encode($data->valor_compra); ?>
	<br />


</div>