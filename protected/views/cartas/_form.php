	<div class="form-group">
		<?php echo $form->labelEx($model,'na', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'na',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'na'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_trazabilidad', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_trazabilidad',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_trazabilidad'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_plantilla', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_plantilla',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_plantilla'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'mensaje', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'mensaje',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'mensaje'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'carta', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'carta',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'carta'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'nombre_destinatario', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'nombre_destinatario',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'nombre_destinatario'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_tipo_entrega', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_tipo_entrega',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_tipo_entrega'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_proveedor', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_proveedor',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_proveedor'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'punteo', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'punteo',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'punteo'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'impreso', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'impreso',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'impreso'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'principal', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'principal',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'principal'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_firma', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_firma',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_firma'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'direccion', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'direccion',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_ciudad', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_ciudad',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_ciudad'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'correo', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'correo',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'correo'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'telefono', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'telefono',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'fecha_respuesta', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'fecha_respuesta',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'fecha_respuesta'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'usuario_respuesta', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'usuario_respuesta',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'usuario_respuesta'); ?>
	</div>

	
	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class' => 'btn-u btn-u-blue')); ?>
	</div>
