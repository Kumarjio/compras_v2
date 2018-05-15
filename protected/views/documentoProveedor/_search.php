<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id_docpro',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'proveedor',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tipo_documento',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_inicio',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_fin',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'objeto',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_firma',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tiempo_preaviso',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cuerpo_contrato',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'anexos',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'polizas',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tiempo_proroga',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'area',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'proroga_automatica',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'consecutivo_contrato',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'responsable_compras',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'responsable_proveedor',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'motivo_terminacion',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'fecha_terminacion',array('class'=>'span5')); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
