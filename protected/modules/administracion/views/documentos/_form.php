	<div class="form-group">
		<?php echo $form->labelEx($model,'nombre_documento', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'nombre_documento',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'nombre_documento'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'estado', array('class' => 'control-label')); ?>
		<?php echo $form->dropDownList($model,'estado',array('1'=>'Activo','0'=>'Inactivo'),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	
	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class' => 'btn-u btn-u-blue')); ?>
	</div>
