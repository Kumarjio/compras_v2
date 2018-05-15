<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'cotizacion-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'producto_orden',array('class'=>'span5', 'value'=> ($model->producto_orden == null)?$_GET['prodorden']:$model->producto_orden)); ?>

	<label for="Cotizacion_nit">Proveedor</label><input class="span5" name="Cotizacion[razon_social]" id="Cotizacion_razon_social" type="text" disabled="disabled" value="<?php 
	$query = Proveedor::model()->findAllByPk($model->nit);
	if(count($query) >0){
		$p = $query[0];
		echo $p->razon_social;
	} ?>">
	
	<?php echo $form->hiddenField($model,'nit',array('class'=>'span5')); ?><?php $this->widget('bootstrap.widgets.BootButton', array(
	    'label'=>'Seleccionar Proveedor',
	    'url'=>'#proveedor-modal',
	    'type'=>'primary',
	    'htmlOptions'=>array('data-toggle'=>'modal', 'style' => 'margin:-9px 0px 0px 5px;', 'onClick' => "$('#genericModal').modal('hide');"),
	)); ?>
	
	
	<?php $this->widget('bootstrap.widgets.BootButton', array(
			    'label'=>'Crear proveedor',
			    'url' => $this->createUrl("proveedor/create"),
			    'type'=>'primary',
			    'htmlOptions'=>array('style' => 'margin:-9px 0px 0px 5px;','id' => 'crear_proveedor'),
			)); ?>	
	
	<?php 
	if($model->nit != null or $model->nit != ''){
		echo $form->dropDownListRow($model, 'contacto', CHtml::listData(ContactoProveedor::model()->findAllByAttributes(array('nit' => $model->nit)), 'id', 'nombre')); 
	}else{
		echo $form->dropDownListRow($model, 'contacto'); 
	}
	?>
	
				
	<?php $this->widget('bootstrap.widgets.BootButton', array(
			    'label'=>'Crear Contacto',
			    'url' => $this->createUrl("proveedor/admin"),
			    'type'=>'primary',
			    'htmlOptions'=>array('style' => 'margin:-9px 0px 0px 5px; display:none;','id' => 'crear_contacto_proveedor'),
			)); ?>
						
	<?php echo $form->textFieldRow($model,'numero',array('class'=>'span5')); ?>
    <?php echo $form->textFieldRow($model,'referencia',array('class'=>'span5')); ?>

   <?php 
	if($model->producto_orden == null){
		$model->producto_orden = $_GET['prodorden'];
	}
	$model->cantidad = $model->productoOrden->orden_solicitud0->cantidad;
	echo $form->textFieldRow($model,'cantidad',array('class'=>'span5 numeric', 'readonly' => 'readonly', 'onblur' => '$("#Cotizacion_total_compra").val(this.value * $("#Cotizacion_valor_unitario").val());$("#Cotizacion_total_compra_pesos").val(this.value * $("#Cotizacion_valor_unitario").val() * $("#Cotizacion_trm").val())')); 
	?>

	<?php echo $form->textFieldRow($model,'valor_unitario',array('class'=>'span5 numeric', 'onblur' => '$("#Cotizacion_total_compra").val(this.value * $("#Cotizacion_cantidad").val());$("#Cotizacion_total_compra_pesos").val(this.value * $("#Cotizacion_cantidad").val() * $("#Cotizacion_trm").val())')); ?>
	
	<?php echo $form->dropDownListRow($model,
		                             'moneda',
		                             CHtml::listData(Cotizacion::model()->getMonedas(), "id", "nombre"),
		                             array('class'=>'span5', 'onChange' => 'if($("#Cotizacion_moneda option:selected").val() == "Peso"){$("#Cotizacion_trm").val(1);$("#Cotizacion_trm").attr("readonly","readonly"); $("#trm").slideUp();}else{$("#Cotizacion_trm").val("");$("#Cotizacion_trm").removeAttr("readonly"); $("#trm").slideDown();}$("#Cotizacion_total_compra").val($("#Cotizacion_valor_unitario").val() * $("#Cotizacion_cantidad").val());$("#Cotizacion_total_compra_pesos").val($("#Cotizacion_valor_unitario").val() * $("#Cotizacion_cantidad").val() * $("#Cotizacion_trm").val())')); ?>

	<?php 
	if($model->moneda == "Peso" or $model->moneda == ''){
		$model->trm = 1;
		echo "<div id='trm' style='display:none;'>";
		echo $form->textFieldRow($model,'trm',array('class'=>'span5 numeric', 'readonly' => 'readonly', 'onblur' => '$("#Cotizacion_total_compra").val($("#Cotizacion_valor_unitario").val() * $("#Cotizacion_cantidad").val());$("#Cotizacion_total_compra_pesos").val(this.value * $("#Cotizacion_cantidad").val() * $("#Cotizacion_valor_unitario").val())'));
		echo "</div>";
	}else{
		echo "<div id='trm'>";
		echo $form->textFieldRow($model,'trm',array('class'=>'span5 numeric', 'onblur' => '$("#Cotizacion_total_compra").val($("#Cotizacion_valor_unitario").val() * $("#Cotizacion_cantidad").val());$("#Cotizacion_total_compra_pesos").val(this.value * $("#Cotizacion_cantidad").val() * $("#Cotizacion_valor_unitario").val())'));
		echo "</div>";
	}
	 ?>
	<?php echo $form->textFieldRow($model,'total_compra',array('class'=>'span5 numeric', 'readonly' => 'readonly')); ?>
	<?php echo $form->textFieldRow($model,'total_compra_pesos',array('class'=>'span5 numeric', 'readonly' => 'readonly')); ?>
	
	<?php echo $form->dropDownListRow($model,
		                             'descuento_prontopago',
		                             array('Si' => 'Si', 'No' => 'No'),
		                             array('class'=>'span5', 'onChange' => 'if($("#Cotizacion_descuento_prontopago option:selected").val() == "Si"){$("#Cotizacion_porcentaje_descuento").removeAttr("disabled");$("#Cotizacion_dias_pago_factura").removeAttr("disabled");}else{$("#Cotizacion_porcentaje_descuento").attr("disabled","disabled");$("#Cotizacion_dias_pago_factura").attr("disabled","disabled");}', 'prompt' => 'Seleccione...')); ?>
		
	<?php 
	if($model->descuento_prontopago == 'Si'){
		echo $form->textFieldRow($model,'porcentaje_descuento',array('class'=>'span5 numeric'));
		echo $form->textFieldRow($model,'dias_pago_factura',array('class'=>'span5 numeric'));
	}else{
		echo $form->textFieldRow($model,'porcentaje_descuento',array('class'=>'span5 numeric', 'disabled' => 'disabled'));
		echo $form->textFieldRow($model,'dias_pago_factura',array('class'=>'span5 numeric', 'disabled' => 'disabled'));
	} 
	?>

	<?php echo $form->textAreaRow($model,'descripcion',array('rows'=>3, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
