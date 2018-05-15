<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico")),
		array( 'label'=>"Contrato", 'url'=>'#', "active"=>true),
		array( 'label'=>"Trazabilidad", 'itemOptions'=>array('id'=>'trazabilidad','data-toggle'=>'modal',
        'data-target'=>'#myModal')),
    );

	?>
  <div class="row"><div class='span5'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>
  <div class='row'>
  	<div class='span5'>
  	<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
  		'id'=>'documento-proveedor-form',
  		'enableAjaxValidation'=>false,
  			'htmlOptions' => array('enctype' => 'multipart/form-data'),
  	)); ?>
  	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->errorSummary($model_estado); ?> 
  	<?php echo $form->labelEx($model,'tipo_documento');
  	 echo $form->dropDownList($model, 'tipo_documento',
  		 array('1'=>'Contrato','2'=>'Oferta Mercantil'),
  		 array('prompt' => 'Seleccione...',
  			   'class'=>'span5')); ?>

  	<?php echo $form->textAreaRow($model,'nombre_contrato',array('class'=>'span5')); ?>
  	<?php echo $form->textAreaRow($model,'objeto',array('class'=>'span5')); ?>
  	<div class='row'>
  		<div class='span3'>
  			<?php echo $form->textFieldRow($model,'valor',array('class'=>'span3','maxlength'=>19)); ?>
  		</div>
  		<div class='span1'>
  		 <?php echo $form->labelEx($model,'valor_indefinido'); ?>
  			<?php echo $form->checkBox($model,'valor_indefinido',array('class'=>'span2')); ?>
  		</div>
      <div class='span1'>
                        <?php echo $form->dropDownListRow($model, 'moneda', CHtml::listData(Cotizacion::model()->getMonedas(), "id", "nombre"), array('class'=>'span1','prompt'=>'seleccione')); ?>
       </div>
  	</div>
  	<?php
  		echo $form->labelEx($model,'fecha_inicio');
  		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
  			'model'=>$model,
  			'attribute'=>'fecha_inicio',
  			'language' => 'es',
  			'options'=>array(
  				'showAnim'=>'fold',
  				'dateFormat' => 'yy-mm-dd',
  				'changeMonth'=> true,
                      'changeYear'=> true,

  				),'htmlOptions'=>array(
  					'style'=>'height:20px;',
  					'data-sync' => 'true',
  					'class' => 'span5'
  					)
  			)
  		);

  		 echo $form->labelEx($model,'fecha_fin');
  		 $this->widget('zii.widgets.jui.CJuiDatePicker', array(
  			'model'=>$model,
  			'attribute'=>'fecha_fin',
  			'language' => 'es',
  			'options'=>array(
  				'showAnim'=>'fold',
  				'dateFormat' => 'yy-mm-dd',
  				'changeMonth'=> true,
                      'changeYear'=> true,
  				),'htmlOptions'=>array(
  					'style'=>'height:20px;',
  					'data-sync' => 'true',
  					'class' => 'span5'
  					)
  			)
  		); ?>
  		<?php echo $form->labelEx($model,'proroga_automatica'); ?>
  		<?php echo $form->dropDownList($model,
  			'proroga_automatica',
  			DocumentoProrroga::model()->GetListaProrroga(),
  	  array('prompt' => 'Seleccione...','class'=>'span5','data-sync'=>'true')); ?>

  		<?php echo $form->labelEx($model,'tiempo_proroga',array('class'=>'span5')); ?>

  	<?php echo "Años:";
  		echo $form->textField($model,'tiempo_pro_anio',	array('class'=>"span1"));
  		echo " Meses: ";
  		echo $form->textField($model,'tiempo_pro_mes',	array('class'=>"span1"));
  		echo " Dias: ";
  		echo $form->textField($model,'tiempo_pro_dia',	array('class'=>"span1"));
  				?>
  <br>

  		<?php echo $form->labelEx($model,'tiempo_preaviso',array('class'=>'span5')); ?>
  	<?php echo "Años:";
  		echo $form->textField($model,'tiempo_pre_anio',	array('class'=>"span1"));
  		echo " Meses: ";
  		echo $form->textField($model,'tiempo_pre_mes',	array('class'=>"span1"));
  		echo " Dias: ";
  		echo $form->textField($model,'tiempo_pre_dia',	array('class'=>"span1"));
  				?>

  		<?php echo $form->textFieldRow($model,'cuerpo_contrato',array('class'=>'span5')); ?>

  		<?php echo $form->textFieldRow($model,'anexos',array('class'=>'span5')); ?>

  		<?php echo $form->textFieldRow($model,'polizas',array('class'=>'span5')); ?>
  	<?
  	 echo $form->labelEx($model,'fecha_firma');
  		 $this->widget('zii.widgets.jui.CJuiDatePicker', array(
  			'model'=>$model,
  			'attribute'=>'fecha_firma',
  			'language' => 'es',
  			'options'=>array(
  				'showAnim'=>'fold',
  				'dateFormat' => 'yy-mm-dd',
  				'changeMonth'=> true,
                      'changeYear'=> true,
  				),'htmlOptions'=>array(
  					'style'=>'height:20px;',
  					'data-sync' => 'true',
  					'class' => 'span5'
  				)
  			)
  		);
  		?>

     <?php echo $form->checkBox($model,'terminar_cualquier_momento',  array('class'=>"span1")); ?> ¿Posibilidad de terminar en cualquier momento? </br></br>

  		 <?php echo $form->labelEx($model,'id_orden'); ?>
  		 <?php /* echo $form->dropDownList($model,
  											 'id_orden',
  											 DocumentoProveedor::model()->getOrdenesCompra($model->proveedor),
  											 array('prompt' => 'Seleccione...',
  												   'class'=>'span5')); */

                             $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                              'model'=>$model,
                         	    'attribute'=>'id_orden',
                              'name'=>'id_orden',
                         	    'source'=>array_map(function($key, $value) {
          return array('label' => $value, 'value' => $key);
      }, array_keys(DocumentoProveedor::model()->getOrdenesCompra($model->proveedor)), DocumentoProveedor::model()->getOrdenesCompra($model->proveedor)),
       	));
       ?>

      <?php echo $form->dropDownListRow($model,'cancelado',array('true'=>'Vigente', 'false'=>'Cancelado'),array('class'=>'span5')); ?>

  		<label >Gerencia <span class="required">*</span></label>
  			<?php echo $form->dropDownList($model,
  											 'id_gerencia',
  											 CHtml::listData(Gerencias::model()->findAll(),"id","nombre"),
  											 array('prompt' => 'Seleccione...',
  												   'class'=>'span5',
  								   'data-sync'=>'true',
  												   'onChange' => CHtml::ajax(array(
  														'type' => 'post',
  														'dataType' => 'json',
  														'data' => array('gerencia' => 'js:this.value','model'=>'DocumentoProveedor'),
  														'url' => $this->createUrl("gerencias/jefaturasDoc"),
  														'success' => 'function(data){
  															if(data.status == "ok"){
  																$("#DocumentoProveedor_id_jefatura").replaceWith(data.combo);
  																$("#DocumentoProveedor_id_gerente").val(data.gerente.id);
  																 $("#DocumentoProveedor_responsable_proveedor").val("");
  															}else{
  																alert(data.mensaje);
  																$("#DocumentoProveedor_id_gerente").val("");

  																					$("#DocumentoProveedor_responsable_proveedor").val("");

  															}

  														}')))); ?>


  		  <?php if($model->id_gerencia != ""): ?>
  							<label >Jefatura  <span class="required">*</span></label>
  				<?php echo $form->dropDownList($model,
  					 'id_jefatura',
  					 CHtml::listData(
  					 Jefaturas::model()->findAllByAttributes(array('id_gerencia' => $model->id_gerencia)),
  						"id",
  						"nombre"
  					 ),
  					array('prompt' => 'Seleccione...',
  						'class' => 'span5',
  					    'data-sync'=>'true',
  					    'id' => 'DocumentoProveedor_id_jefatura',
  					    'onChange' => CHtml::ajax(array(
  								   'type' => 'post',
  									'dataType' => 'json',
  									'data' => array('jefatura' => 'js:this.value'),
  									'url' => $this->createUrl("jefaturas/nombrejefe"),
  									'success' => 'function(data){
  										if(data.status == "ok"){
  											$("#DocumentoProveedor_responsable_proveedor").val(data.jefe.nombre);
                        $("#DocumentoProveedor_email_responsable").val(data.jefe.email);
  										}else{
  											alert(data.mensaje);
  											$("#DocumentoProveedor_id_jefatura").val("");
  											$("#DocumentoProveedor_responsable_proveedor").val("");
  										}
  									}'
  										  )
  									)
  					)); ?>

  		  <?php else: ?>

  				<?php echo $form->dropDownListRow($model,
  												 'id_jefatura',
  												 array(),
  	  array('prompt' => 'Seleccione una gerencia...','class'=>'span5','data-sync'=>'true')); ?>

  			<?php endif ?>
  		<?php //echo $form->textFieldRow($model,'area',array('class'=>'span5')); ?>

  		<?php echo $form->textFieldRow($model,'responsable_proveedor',array('class'=>'span5','readonly'=>'readonly')); ?>
      
      <?php echo $form->textFieldRow($model,'email_responsable',array('class'=>'span5')); ?>

  		<?php echo $form->labelEx($model,'responsable_compras'); ?>

  		<?php echo $form->dropDownList($model,
  			'responsable_compras',
  			DocumentoResponsableCompras::model()->GetListaResponsableCompras(),
  	  array('prompt' => 'Seleccione...','class'=>'span5','data-sync'=>'true')); ?>
			<br>
		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Guardar Datos',
			)); ?>

		</div>
<?php echo $form->textAreaRow($model_estado,'observacion',array('class'=>'span5')); ?>
	<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Aprobar'
			)); ?>
			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Devolver'
			)); ?>

		</div>
	<?php $this->endWidget(); ?>
	</div>
	<div class="span7" id="divCont">
    <?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo));  ?>
	</div>

</div>
<?php
	$this->renderPartial('documento_detalle_juridico',array('model_detalle'=>$model_detalle,'model'=>$model));

 $this->renderPartial('_trazabilidad',array('model_traza'=>$model_traza,'model'=>$model));

 ?>
 <script>
 $(document).ready(function() {
  $('#DocumentoProveedor_valor,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_dia').maskMoney();
 $('#DocumentoProveedor_tiempo_pre_anio,#DocumentoProveedor_tiempo_pre_mes,#DocumentoProveedor_tiempo_pre_dia').maskMoney();
 $('#DocumentoProveedor_cuerpo_contrato,#DocumentoProveedor_anexos,#DocumentoProveedor_polizas').maskMoney();
   $("#DocumentoProveedor_fecha_inicio").change(function(){
       $("#DocumentoProveedor_fecha_fin").val("");
     $("#DocumentoProveedor_fecha_firma").val("");
       $('#DocumentoProveedor_fecha_fin').datepicker('option','minDate', $("#DocumentoProveedor_fecha_inicio").val());
     $('#DocumentoProveedor_fecha_fin').datepicker('option','defaultDate', $("#DocumentoProveedor_fecha_inicio").val());
   //	$('#DocumentoProveedor_fecha_firma').datepicker('option','minDate', $("#DocumentoProveedor_fecha_inicio").val());
     $('#DocumentoProveedor_fecha_firma').datepicker('option','defaultDate', $("#DocumentoProveedor_fecha_inicio").val());
   });


$("#DocumentoProveedor_nombre_contrato").bind('keyup', function (e) {
    if (e.which >= 97 && e.which <= 122) {
        var newKey = e.which - 32;
        // I have tried setting those
        e.keyCode = newKey;
        e.charCode = newKey;
    }
    $("#DocumentoProveedor_nombre_contrato").val(($("#DocumentoProveedor_nombre_contrato").val()).toUpperCase());
});

$("#DocumentoProveedor_objeto").bind('keyup', function (e) {
    if (e.which >= 97 && e.which <= 122) {
        var newKey = e.which - 32;
        // I have tried setting those
        e.keyCode = newKey;
        e.charCode = newKey;
    }
    $("#DocumentoProveedor_objeto").val(($("#DocumentoProveedor_objeto").val()).toUpperCase());
});

  $('#myModal').on('hide.bs.modal', function (e) {
    $("#divCont").show();
  });
  $('#myModal').on('show.bs.modal', function (e) {
      $("#divCont").hide();
  });

 //Bloqueo de campos
 $('#DocumentoProveedor_valor_indefinido').click(function() {
        if ($('#DocumentoProveedor_valor_indefinido').is(':checked')) {
            $('#DocumentoProveedor_valor').val(0);
     $("#DocumentoProveedor_valor").prop('disabled', true);

   }else{
     $("#DocumentoProveedor_valor").prop('disabled', false);
   }
 });

 $('#DocumentoProveedor_proroga_automatica').change(function() {
   if($('#DocumentoProveedor_proroga_automatica').val()=='2'){
      $('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').val(0);
      $('#DocumentoProveedor_tiempo_pre_anio,#DocumentoProveedor_tiempo_pre_mes,#DocumentoProveedor_tiempo_pre_dia').val(0);
      $('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').prop('disabled', true);
   }else{
     $('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').prop('disabled', false);
   }

 });
verifica_bloqueo();
  function verifica_bloqueo(){
    if($('#DocumentoProveedor_proroga_automatica').val()==2){
        $('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').val(0);
        $('#DocumentoProveedor_tiempo_pre_anio,#DocumentoProveedor_tiempo_pre_mes,#DocumentoProveedor_tiempo_pre_dia').val(0);
        $('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').prop('disabled', true);
    }

    if( $('#DocumentoProveedor_valor_indefinido').is(':checked')) {
        $('#DocumentoProveedor_valor').val(0);
        $("#DocumentoProveedor_valor").prop('disabled', true);
    }
  }

  $('#id_orden').blur(function(){
    var urlr='<?=Yii::app()->createUrl('documentoProveedor/datosOrden'); ?>';
    var url2='<?=Yii::app()->createUrl('gerencias/jefaturasDoc'); ?>';
     $.ajax({
       url: urlr,
       type: 'post',
       data: { id_orden:$('#id_orden').val() },
       success: function(data){
         var datos=jQuery.parseJSON(data );
         $('#DocumentoProveedor_id_gerencia').val(datos.id_gerencia);
         $.ajax({
          type: 'post',
          dataType : 'json',
          url : url2,
          data : { gerencia : datos.id_gerencia, model : 'DocumentoProveedor' },
          success : function(data){
            console.log(data);
            if(data.status == "ok"){
              $("#DocumentoProveedor_id_jefatura").html();
              $("#DocumentoProveedor_id_jefatura").replaceWith(data.combo);
              $("#DocumentoProveedor_id_gerente").val(data.gerente.id);
               $("#DocumentoProveedor_responsable_proveedor").val("");
              $('#DocumentoProveedor_id_jefatura').val(datos.id_jefatura);
               $('#DocumentoProveedor_id_jefatura').change();
            }else{
              alert(data.mensaje);
              $("#DocumentoProveedor_id_gerente").val("");
              $("#DocumentoProveedor_responsable_proveedor").val("");
            }
          }

        });

       }
     });


  });

});
 </script>
