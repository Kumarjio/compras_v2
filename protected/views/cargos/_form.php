<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'cargos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'nombre', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->dropDownListGroup(
		$model,
		'tipo_cargo',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5', 
					'prompt' => 'Ninguno',
				), 
				'data'=>array('1'=>'Jefe', '2'=>'Gerente', '3'=>'Vicepresidente')
			)
		)); ?>

	<?php echo $form->dropDownListGroup(
		$model,
		'id_vice',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5', 
					'prompt' => 'No Aplica',
					'ajax'=>array(
                        'type'=>'POST',
                        'url'=>CController::createUrl('selectGerencia'),
		                'success'=>'function(data){
		                	$("#"+data.id).html(data.options);
		                	$("#"+data.id_vacio).html(data.vacio);
		                	$("#"+data.id).tooltip({\'trigger\':\'focus\', \'title\': \'Seleccione\'});
		                	$("#"+data.id).focus();
		                }',
                        'update'=>'#'.CHtml::activeId($model,'id_gerencia'),
                    ),
				), 
				'data'=>CHtml::listData(Vicepresidencias::model()->findAll(), "id", "nombre")
			)
		)); ?>

	<?php echo $form->dropDownListGroup(
		$model,
		'id_gerencia',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5', 
					'prompt' => 'No Aplica',
					'ajax'=>array(
		                'type'=>'POST',
		                'url'=>CController::createUrl('selectJefatura'),
		                'update'=>'#'.CHtml::activeId($model,'id_jefatura'),
		            ),
				), 
				'data'=>$gerencias
			)
		)); ?>

	<?php echo $form->dropDownListGroup(
		$model,
		'id_jefatura',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5', 
					'prompt' => 'No Aplica',
				), 
				'data'=>$jefaturas
			)
		)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
