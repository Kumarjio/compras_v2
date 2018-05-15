<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id_poldoc',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_inicio',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_fin',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'fecha_fin_ind'); ?>

	<?php echo $form->textFieldRow($model,'id_tipo_poliza',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
