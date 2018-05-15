<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'cotizacion-pago-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<?php 
	$a = CotizacionPago::model()->findAllByAttributes(array('id_cotizacion' => $id_cotizacion));


	if((count($a) > 0) and $model->tipo != "Anticipo"){
		$options = array('Pago' => 'Pago');
    }else{
      $options = array('Anticipo' => 'Anticipo', 'Pago' => 'Pago','Mensualidad' => 'Mensualidad');
	}
	echo $form->dropDownListRow($model,'tipo',$options,array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'porcentaje',array('class'=>'span5')); ?>
	
	<?php echo $form->textAreaRow($model,'observacion',array('rows'=>3, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
			'htmlOptions' => array('onClick' => '
				jQuery.ajax({"url":"/index.php/cotizacionPago/'.(($model->isNewRecord)?'create/id_cot/'.$id_cotizacion : 'update/id/'.$model->id) .'","data":$(\'#cotizacion-pago-form\').serialize(), "type":"post","dataType":"json","success":function(data){
		                if (data.status == "saved"){
							$("#agregar-pago-modal").modal("hide");
							$("#cotizacion-pago-grid").yiiGridView.update("cotizacion-pago-grid");
							$("#genericModal").modal("show");
		                }else{
		                    $("#genericModal").modal("hide");
					        $("#agregar-pago-modal-content").html(data.content);
							$("#agregar-pago-modal").modal("show");
		                }

		            } ,"cache":false
				}); 
					return false;')
		)); ?>
	</div>

<?php $this->endWidget(); ?>
