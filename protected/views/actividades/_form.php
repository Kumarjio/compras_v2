	<div class="form-group">
		<?php echo $form->labelEx($model,'actividad', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'actividad',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'actividad'); ?>
	</div>

	
	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class' => 'btn-u btn-u-blue')); ?>
	</div>
