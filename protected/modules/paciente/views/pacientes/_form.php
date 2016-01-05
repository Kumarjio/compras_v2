	<!--<div class="form-group">-->
		<?php // echo $form->labelEx($model,'cedula', array('class' => 'control-label')); ?>
		<?php echo $form->textFieldGroup($model,'cedula',array('maxlength'=>15)); ?>
		<?php echo $form->error($model,'cedula'); ?>
	<!--</div>-->

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
		<?php echo $form->checkboxListGroup(
			$model,
			'sexo',
			array(
				'widgetOptions' => array(
					'data' => array('m'=>'Masculino', 'f'=>'Femenino')
				),
				'inline'=>true
			)
		); ?>
		<?php echo $form->error($model,'sexo'); ?>
	</div>

	<div class="form-group">
		<?php // echo $form->labelEx($model,'fecha_nacimiento', array('class' => 'control-label')); ?>
		<?php echo $form->datePickerGroup($model,'fecha_nacimiento',
			array(
				'widgetOptions' => array(
					'options' => array(
						'language' => 'es',
                                                'autoclose'=>'true',
                                                'format'=>'yyyy-mm-dd',
					),
				),
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
			)); ?>
		<?php echo $form->error($model,'fecha_nacimiento'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_estado_civil', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_estado_civil',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_estado_civil'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_ciudad', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_ciudad',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_ciudad'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'barrio', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'barrio',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'barrio'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'direccion', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'direccion',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'telefono', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'telefono',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'telefono'); ?>
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
		<?php echo $form->labelEx($model,'id_grupo_poblacion', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_grupo_poblacion',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_grupo_poblacion'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_clasificacion', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_clasificacion',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_clasificacion'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_grupo_etnico', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_grupo_etnico',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_grupo_etnico'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_categoria', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_categoria',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_categoria'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_tipo_afiliado', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_tipo_afiliado',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_tipo_afiliado'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_eps', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_eps',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_eps'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_ocupacion', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_ocupacion',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_ocupacion'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_nivel_educativo', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_nivel_educativo',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_nivel_educativo'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'nombre_acompanante', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'nombre_acompanante',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'nombre_acompanante'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'cc_acompanante', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'cc_acompanante',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'cc_acompanante'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_ciudad_acompanante', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_ciudad_acompanante',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_ciudad_acompanante'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'telefono_acompanante', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'telefono_acompanante',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'telefono_acompanante'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_parentezco', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'id_parentezco',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_parentezco'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'fecha_ingreso', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'fecha_ingreso',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'fecha_ingreso'); ?>
	</div>

	
	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class' => 'btn-u btn-u-blue')); ?>
	</div>
