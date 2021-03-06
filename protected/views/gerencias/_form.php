<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'gerencias-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'nombre', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->dropDownListGroup($model,'es_direccion',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5'), 'data'=>array('0'=>'No', '1'=>'Si')))); ?>
	
	<?php echo $form->dropDownListGroup($model,'id_vice',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'prompt' => 'Sin Vicepresidencia'), 'data'=> CHtml::listData(Vicepresidencias::model()->findAll(), "id","nombre")))); ?>

	<?php echo $form->textFieldGroup($model,'atribuciones', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>2)))); ?>

	<div class="form-group">
		<?php echo CHtml::label('Cargo Asociado','cargo_asociado', array('class' => 'control-label'));?>
		<?php echo CHtml::textField('cargo_asociado',Cargos::model()->findByAttributes(array('id_gerencia'=>$model->id, 'es_gerente'=>'Si'))->nombre, array('class'=>'span5 form-control', 'disabled'=>'disabled'));?>
	</div>


	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
            'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
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
