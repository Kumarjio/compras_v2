<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_parametro')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_parametro),array('view','id'=>$data->id_parametro)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_empl_listas')); ?>:</b>
	<?php echo CHtml::encode($data->id_empl_listas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_empl_clientes')); ?>:</b>
	<?php echo CHtml::encode($data->id_empl_clientes); ?>
	<br />


</div>