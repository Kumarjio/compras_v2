<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id_factura',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_orden',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nit_proveedor',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cant_productos',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_productos',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'rte_fte',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_rte_fte',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'rte_iva',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_rte_iva',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'rte_ica',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_rte_ica',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'rte_timbre',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_rte_timbre',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_centro_costos',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nro_pagos',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cuenta_x_pagar',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_cuenta_contable',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'analista_encargado',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_vencimiento',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_factura',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_recibido',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'path_imagen',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'paso_wf',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'creacion',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'actualizacion',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
