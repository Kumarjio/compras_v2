<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_poldoc')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_poldoc),array('view','id'=>$data->id_poldoc)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_inicio')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_inicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_fin')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_fin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_fin_ind')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_fin_ind); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo_poliza')); ?>:</b>
	<?php echo CHtml::encode($data->id_tipo_poliza); ?>
	<br />


</div>