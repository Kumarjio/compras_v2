<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anios')); ?>:</b>
	<?php echo CHtml::encode($data->anios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meses')); ?>:</b>
	<?php echo CHtml::encode($data->meses); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dias')); ?>:</b>
	<?php echo CHtml::encode($data->dias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_dias')); ?>:</b>
	<?php echo CHtml::encode($data->total_dias); ?>
	<br />


</div>