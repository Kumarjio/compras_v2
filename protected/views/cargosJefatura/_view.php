<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cargo')); ?>:</b>
	<?php echo CHtml::encode($data->id_cargo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_jefatura')); ?>:</b>
	<?php echo CHtml::encode($data->id_jefatura); ?>
	<br />


</div>