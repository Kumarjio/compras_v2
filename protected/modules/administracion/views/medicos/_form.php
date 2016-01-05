	<div class="form-group">
		<?php echo $form->labelEx($model,'cedula', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'cedula',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'cedula'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'primer_nombre', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'primer_nombre',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'primer_nombre'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'segundo_nombre', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'segundo_nombre',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'segundo_nombre'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'primer_apellido', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'primer_apellido',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'primer_apellido'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'segundo_apellido', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'segundo_apellido',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'segundo_apellido'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'direccion', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'direccion',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'telefono_fijo', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'telefono_fijo',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'telefono_fijo'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'ciudad', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'ciudad',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'ciudad'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'celular', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'celular',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'celular'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'correo', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'correo',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'correo'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'tarjeta_profesional', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'tarjeta_profesional',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'tarjeta_profesional'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'nro_cuenta_bancaria', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'nro_cuenta_bancaria',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'nro_cuenta_bancaria'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'entidad_bancaria', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'entidad_bancaria',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'entidad_bancaria'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'estado', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'estado',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	
	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class' => 'btn-u btn-u-blue')); ?>
	</div>
