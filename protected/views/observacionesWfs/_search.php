<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'model',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'idmodel',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'usuario',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'estado_anterior',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'estado_nuevo',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'observacion',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'fecha',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
