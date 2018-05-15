<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'proveedor-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('onSubmit' => 'return false')
)); ?>

	<p class="help-block"><strong>Recuerde!</strong> 
        Los campos marcados con <span class="required">*</span>  son obligatorios.</p>

	<?php echo $form->errorSummary($model); 
	$a = CotizacionPagosOp::model()->findAllByAttributes(array('id_cotizacion_op' => $id_cotizacion));


	if((count($a) > 0) and $model->tipo != "Anticipo"){
		$options = array('Pago' => 'Pago');
    }else{
      $options = array('Anticipo' => 'Anticipo', 'Pago' => 'Pago','Mensualidad' => 'Mensualidad');
	}
	
	echo $form->dropDownListGroup(
	    $model,
	    'tipo',
	    array(
	        'widgetOptions'=>array(
	            'htmlOptions'=>array('class'=>'span5'), 
	            'data'=> $options
	        ),
	    ));
	?>

	<?php echo $form->textFieldGroup($model,'porcentaje',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->textAreaGroup($model,'observacion',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
