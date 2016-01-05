	<div class="form-group">
		<?php echo $form->labelEx($model,'fecha', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'fecha',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'inicio', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'inicio',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'inicio'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'fin', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'fin',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'fin'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_recurso', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_recurso',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_recurso'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'estado', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'estado',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	
	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class' => 'btn-u btn-u-blue')); ?>
	</div>
