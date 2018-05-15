<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'jefaturas-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'nombre', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255, 'onblur' => 'this.value = this.value.toUpperCase();' )))); ?>

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
					'prompt' => 'No Aplica'
				), 
				'data'=>$gerencias
			)
		)); ?>

	<?php echo $form->textFieldGroup($model,'atribuciones', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 numerico','maxlength'=>2)))); ?>

	<div class="form-group">
		<?php echo CHtml::label('Cargo Asociado','cargo_asociado', array('class'=>'control-label'));?>
		<?php echo CHtml::textField('cargo_asociado',Cargos::model()->findByAttributes(array('id_jefatura'=>$model->id, 'es_jefe'=>'Si'))->nombre, array('class'=>'span5 form-control', 'disabled'=>'disabled'));?>
		
	</div>
	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
	$(document).ready(function(){

	    $('.numerico').keypress(function(e){
	            var tecla = document.all ? tecla = e.keyCode : tecla = e.which;
	            if((tecla >= 48 && tecla <= 57) || tecla==8 || tecla==0){
	                    return true
	            }else{
	                    return false;
	            }			
	    });
	});
</script>