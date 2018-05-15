<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'orden',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tipo_compra',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nombre_compra',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'resumen_breve',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'id_gerencia',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_jefatura',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fecha_solicitud',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_gerente',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_jefe',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_usuario',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'centro_costos',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cuenta_contable',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'estado',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'valor_presupuestado',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'mes_presupuestado',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'detalle',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'fecha_entrega',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'direccion_entrega',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'responsable',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'requiere_acuerdo_servicios',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'requiere_polizas_cumplimiento',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'validacion_usuario',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'validacion_jefe',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'validacion_gerente',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'paso_wf',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Buscar">		
	</div>

<?php $this->endWidget(); ?>
