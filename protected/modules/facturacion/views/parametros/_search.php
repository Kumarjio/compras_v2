<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id_parametro',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_empl_listas',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_empl_clientes',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
