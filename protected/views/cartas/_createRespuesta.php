<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-crear-respuesta',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> "jQuery.ajax({
			'url':'".Yii::app()->createUrl('cartas/creaRespuesta')."',
			'dataType':'json',
			'data':$(this).serialize(),
			'type':'post',
			'success':function(data){
				if(data.status == 'success'){ 
					cartasRespuesta('".$model->na."', '".$model->id_trazabilidad."');
					$('#modal_respuesta').modal('hide');
					$('#modal-gestiontraza').modal('show');
				}else{
					$('#body_respuesta').html(data.content);
				}
			},
			'cache':false
		});
		return false;"
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model) ?>
<?= $form->hiddenField($model, 'na')?>
<?= $form->hiddenField($model, 'carta')?>
<?= $form->hiddenField($model, 'id_trazabilidad')?>
<?= $form->hiddenField($model, 'principal')?>
<?= $form->hiddenField($model, 'id_plantilla')?>
<div class="row">
	<div class='col-md-6'>
		<?php echo $form->labelEx($model,'nombre_destinatario', array('class' => 'control-label')); ?>
		<div class="form-group">
			<?php echo $form->textField($model,'nombre_destinatario',array('class'=>'form-control', 'readonly'=>($model->principal == "Si") ? true : false )); ?>
		</div>
	</div>
</div>
<div class="row">
	<div class='col-md-6'>
		<?php echo $form->labelEx($model,'id_tipo_entrega', array('class' => 'control-label')); ?>
		<div class="form-group">
			<?php echo $form->dropDownList($model,'id_tipo_entrega', TipoEntrega::model()->cargaEntrega(),array('class'=>'form-control', 
	  'prompt'=>'...')); ?>
	  	</div>
	</div>
	<div class='col-md-6'>
		<?php echo $form->labelEx($model,'id_proveedor', array('class' => 'control-label')); ?>
		<div class="form-group">
			<?php echo $form->dropDownList($model,'id_proveedor', Proveedores::model()->cargaProveedores(),array('class'=>'form-control', 
	    'prompt'=>'...')); ?>
		</div>
	</div>	
</div>
<div class="row oculto fisico">
	<div class='col-md-6'>
		<? echo CHtml::label('Departamento *', 'lb_departamento', array('class' => 'control-label')) ?>
		<div class="form-group">
			<?php echo $form->dropDownList($model, 'departamento',
			                               	CHtml::listData(Departamento::model()->findAll(array('order' => 'nombre_departamento')), 
			                               		"id_departamento", "nombre_departamento"),
			                               	array(
			                               		'prompt' => 'Seleccione',
                                                'class' => 'form-control',
                                            )
			);?>
		</div>
	</div>
	<div class='col-md-6'>
		<? echo CHtml::label('Ciudad *', 'lb_ciudad', array('class' => 'control-label')) ?>
		<div class="form-group">
			<?php echo $form->dropDownList($model, 'id_ciudad', array(), array('prompt'=>'Seleccione', 'class'=>'form-control')); ?>
	  	</div>
	</div>
</div>
<div class="row oculto fisico">
	<div class='col-md-6'>
		<? echo CHtml::label('Dirección *', 'lb_direccion', array('class' => 'control-label')) ?>
		<div class="form-group">
			<?php echo $form->textField($model,'direccion',array('class'=>'form-control inicial')); ?>
		</div>
	</div>
	<div class='col-md-6'>
		<? echo CHtml::label('Teléfono *', 'lb_telefono', array('class' => 'control-label')) ?>
		<div class="form-group">
			<?php echo $form->telField($model,'telefono',array('class'=>'form-control', 'maxlength'=>'10', 'onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;')); ?>
		</div>
	</div>
</div>
<div class="row oculto fisico">
	<div class='col-md-6'>
		<? echo CHtml::label('Firma *', 'lb_firma', array('class' => 'control-label')) ?>
		<div class="form-group">
			<?php echo $form->dropDownList($model,'id_firma', Firmas::model()->cargaFirmas(),array('class'=>'form-control', 
	  'prompt'=>'...')); ?>
		</div>
	</div>
</div>
<div class="row oculto mail">
	<div class='col-md-6'>
		<? echo CHtml::label('Correo *', 'lb_correo', array('class' => 'control-label')) ?>
		<div class="form-group">
			<?php echo $form->emailField($model,'correo',array('class'=>'form-control')); ?>
		</div>
	</div>
</div>
<div class="row">
</div>
<div class='col-md-1'>
<div class="form-actions"> 
<?php $this->widget('bootstrap.widgets.BootButton', array( 
	'buttonType'=>'submit', 
	'type'=>'success', 
	'label'=>$model->isNewRecord ? 'Guardar': 'Actualizar', 
)); ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
	$( document ).ready(function(){
		var auxTipoEntrega = "<?=$model->id_tipo_entrega ?>";
		if( auxTipoEntrega != ""){
			cargaForm();
		}
		var auxDepartamnto = "<?=$model->departamento ?>";
		if( auxDepartamnto != ""){
			var auxCiudad = "<?=$model->id_ciudad ?>";
			if( auxCiudad != ""){
				cargaCiudades(auxCiudad);
			}else{
				cargaCiudades($("#Cartas_id_ciudad").val());
			}
		}
	});
	$("#Cartas_id_tipo_entrega").change(function(){
		$("#Cartas_departamento").val("");
		$("#Cartas_id_ciudad").val("");
		$("#Cartas_direccion").val("");
		$("#Cartas_telefono").val("");
		$("#Cartas_id_firma").val("");
		//$("#Cartas_correo").val("");
		cargaForm();
	});
	$("#Cartas_departamento").change(function(){
		if( $("#Cartas_departamento").val() != "" ){
			if("<?=$model->id_ciudad ?>" != ""){
				cargaCiudades("<?=$model->id_ciudad ?>");
			}else{
				cargaCiudades($("#Cartas_id_ciudad").val());
			}
		}else{
			$("#Cartas_id_ciudad").val("");
		}
	});
	function cargaForm(){
		if($("#Cartas_id_tipo_entrega").val() != ""){
			if($("#Cartas_id_tipo_entrega").val() == "1"){
				$(".fisico").each(function(){
					$(this).hide();
				});
				$(".mail").each(function(){
					$(this).show();
				});
			}else{
				$(".fisico").each(function(){
					$(this).show();
				});
				$(".mail").each(function(){
					$(this).hide();
				});
			}
		}else{
			$(".fisico").each(function(){
				$(this).hide();
			});
			$(".mail").each(function(){
				$(this).hide();
			});
		}
	}
	function cargaCiudades(id_ciudad){
		var departamento = $("#Cartas_departamento").val();
		if(departamento != ""){
			<?php echo CHtml::ajax(
		        array(
		          	'type' => 'POST',
		          	'data' => array(
		          		'departamento' => 'js:departamento',
		          		'id_ciudad' => 'js:id_ciudad'
		          	),
		          	'update'=>'#'.CHtml::activeId($model,'id_ciudad'),
		          	'url' => $this->createUrl("cargaCiudades"),
		        )
		    );?>
		}
	}
	function soloLetras(e) { // 1
	  tecla = (document.all) ? e.keyCode : e.which; // 2
	  if (tecla==8) return true; // 3
	  patron =/[A-Za-z\s]/; // 4
	  te = String.fromCharCode(tecla); // 5
	  return patron.test(te); // 6
	}
</script>