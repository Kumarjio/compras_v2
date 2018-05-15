<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cargo')); ?>:</b>
	<?php echo CHtml::encode($data->id_cargo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('salario')); ?>:</b>
	<?php echo CHtml::encode($data->salario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_empleado')); ?>:</b>
	<?php echo CHtml::encode($data->id_empleado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_empleador')); ?>:</b>
	<?php echo CHtml::encode($data->id_empleador); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_inicio')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_inicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_fin')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_fin); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_motivo_ingreso')); ?>:</b>
	<?php echo CHtml::encode($data->id_motivo_ingreso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_motivo_retiro')); ?>:</b>
	<?php echo CHtml::encode($data->id_motivo_retiro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creacion')); ?>:</b>
	<?php echo CHtml::encode($data->creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->actualizacion); ?>
	<br />

	*/ ?>

</div>