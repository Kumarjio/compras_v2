<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creacion')); ?>:</b>
	<?php echo CHtml::encode($data->creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->actualizacion); ?>
	<br />


</div>