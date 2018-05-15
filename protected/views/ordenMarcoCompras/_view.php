<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_compra')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_compra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resumen_breve')); ?>:</b>
	<?php echo CHtml::encode($data->resumen_breve); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_solicitud')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_solicitud); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuario')); ?>:</b>
	<?php echo CHtml::encode($data->id_usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_actual')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_actual); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paso_wf')); ?>:</b>
	<?php echo CHtml::encode($data->paso_wf); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuario_reemplazado')); ?>:</b>
	<?php echo CHtml::encode($data->id_usuario_reemplazado); ?>
	<br />

	*/ ?>

</div>