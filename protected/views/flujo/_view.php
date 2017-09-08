<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actividad')); ?>:</b>
	<?php echo CHtml::encode($data->actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sucesion')); ?>:</b>
	<?php echo CHtml::encode($data->sucesion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipologia')); ?>:</b>
	<?php echo CHtml::encode($data->tipologia); ?>
	<br />


</div>