<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nit')); ?>:</b>
	<?php echo CHtml::encode($data->nit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_documento')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_documento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documento_identidad')); ?>:</b>
	<?php echo CHtml::encode($data->documento_identidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_completo')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_completo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('participacion')); ?>:</b>
	<?php echo CHtml::encode($data->participacion); ?>
	<br />


</div>