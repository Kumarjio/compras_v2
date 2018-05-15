<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'cotizacion-regalos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldRow($model,'valor',array('class'=>'span5 numeric')); ?>

	<?php echo $form->textAreaRow($model,'descripcion',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
			'htmlOptions' => array('onClick' => '
				jQuery.ajax({"url":"/index.php/cotizacionRegalos/'.(($model->isNewRecord)?'create/id_cot/'.$id_cotizacion : 'update/id/'.$model->id) .'","data":$(\'#cotizacion-regalos-form\').serialize(), "type":"post","dataType":"json","success":function(data){
		                if (data.status == "saved"){
							$("#agregar-pago-modal").modal("hide");
							$("#cotizacion-regalos-grid").yiiGridView.update("cotizacion-regalos-grid");
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
