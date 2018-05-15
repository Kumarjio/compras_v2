<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'elegir-compras-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('onSubmit' => 'return false')
)); ?>

<?php 	
echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-md-6">
<?php echo $form->dropDownListGroup(
			$model,
			'forma_negociacion',
			array(
				'widgetOptions' => array(
					'data' => array(
						'cantidad'=> 'Por Cantidad',
						'valor'=>'Por Valor',
					),
					'style' => 'margin-left: 0px;'
				),
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5'
				),
			)
		); ?>
	</div>
	<div class="col-md-6">
<?php echo $form->textFieldGroup(
			$model,
			'cant_valor',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
			)
		);?>
	</div>
</div>
<?php echo $form->textAreaGroup($model,'razon_eleccion_compras',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>3, 'cols'=>50, 'class'=>'span8')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType'=>'submit',
		'context'=>'primary',
		'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
	)); ?>
</div>

<?php $this->endWidget(); ?>