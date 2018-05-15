<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_jefatura')); ?>:</b>
	<?php echo CHtml::encode($data->id_jefatura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recibe_dotacion')); ?>:</b>
	<?php echo CHtml::encode($data->recibe_dotacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('es_jefe')); ?>:</b>
	<?php echo CHtml::encode($data->es_jefe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('es_gerente')); ?>:</b>
	<?php echo CHtml::encode($data->es_gerente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activo')); ?>:</b>
	<?php echo CHtml::encode($data->activo); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('creacion')); ?>:</b>
	<?php echo CHtml::encode($data->creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->actualizacion); ?>
	<br />

	*/ ?>

</div>