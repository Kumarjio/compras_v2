<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
	<?php echo CHtml::encode($data->model); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmodel')); ?>:</b>
	<?php echo CHtml::encode($data->idmodel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_anterior')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_anterior); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_nuevo')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_nuevo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado_anterior')); ?>:</b>
	<?php echo CHtml::encode($data->estado_anterior); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado_nuevo')); ?>:</b>
	<?php echo CHtml::encode($data->estado_nuevo); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	*/ ?>

</div>