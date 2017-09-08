<?php
/* @var $this TrazabilidadController */
/* @var $data Trazabilidad */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('na')); ?>:</b>
	<?php echo CHtml::encode($data->na); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_asign')); ?>:</b>
	<?php echo CHtml::encode($data->user_asign); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_asign')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_asign); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actividad')); ?>:</b>
	<?php echo CHtml::encode($data->actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_cierre')); ?>:</b>
	<?php echo CHtml::encode($data->user_cierre); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_cierre')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_cierre); ?>
	<br />

	*/ ?>

</div>