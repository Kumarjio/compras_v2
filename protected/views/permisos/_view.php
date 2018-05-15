<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('controllador_accion')); ?>:</b>
	<?php echo CHtml::encode($data->controllador_accion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creacion')); ?>:</b>
	<?php echo CHtml::encode($data->creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->actualizacion); ?>
	<br />


</div>