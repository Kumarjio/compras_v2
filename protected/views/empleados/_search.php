<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nombre_completo',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'genero',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'tipo_documento',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'numero_identificacion',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'activo',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'embarazo',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'tiempo_gestacion',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_probable_parto',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'creacion',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'actualizacion',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
