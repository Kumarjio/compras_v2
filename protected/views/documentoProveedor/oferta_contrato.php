<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico"), 'visible'=>array_intersect( array('CYC998'), Yii::app()->user->permisos )),
		array( 'label'=>'Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/view",array("id_proveedor"=>base64_encode($model[proveedor]))), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Editar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC986'), Yii::app()->user->permisos )),
		array( 'label'=>"Contrato", 'url'=>'#', "active"=>true),
		array( 'label'=>"Trazabilidad", 'itemOptions'=>array('id'=>'trazabilidad','data-toggle'=>'modal',
        'data-target'=>'#myModal')),
    );
	?>
<div class="row"><div class='span5' id='nomProv'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>
<div class='row'>
	<div class='span5'>
	<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
		'id'=>'documento-proveedor-form',
		'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); ?>
	<? echo CHtml::hiddenField("id_cont", $model->id_docpro, array("id"=>"id_cont") ); ?>
	<?php echo $form->errorSummary($model); ?>
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
			<?php echo $form->checkBox($model,'valor_indefinido',array('class'=>'span1')); ?>
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
?> <p> <?php 
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
					'class' => 'span3'
					)
			)
		); ?>
		 <?php echo $form->checkBox($model,'fecha_fin_ind',	array('class'=>"span1")); ?> Indefinido
		</p>
		<?php
		 echo $form->labelEx($model,'proroga_automatica'); ?>
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

		 <?php echo $form->checkBox($model,'terminar_cualquier_momento',	array('class'=>"span1")); ?> ¿Posibilidad de terminar en cualquier momento?</br></br>
	
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
                        					agregarEmail(data.jefe.email);
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


		<?php //echo $form->textFieldRow($model,'email_responsable[]',array('class'=>'span5')); ?>
	    <?php echo $form->labelEx($model,'email_responsable'); ?>
	    <div class="row">
	    	
	    <?php //echo $form->textField($model,'email_responsable[]', array('class' => 'span4')); ?>
	    <div class="span5">
	    	
	    <?php
		$this->widget('bootstrap.widgets.BootButton', array(
                            'label'=>'Agregar Email',
                            'url'=>'#myModalEmail',
                            'type'=>'primary',
                            'htmlOptions'=>array('class'=> 'prevent nuevoEmail'),
                        )); 
                 


        $this->widget('bootstrap.widgets.BootGridView', array(
            'id' => 'emails-grid',
            'dataProvider' => DocProveedorEmailAviso::model()->search($model->id_docpro),
            'type' => 'striped bordered condensed',
            'enableSorting'=>false,
            'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
            'columns' => array(
            	'email',
                array(
                    'class' => 'bootstrap.widgets.BootButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array
                        (
                        'delete' => array
                            (
                            'visible' =>'true'//'$data->permitirEliminarCaus()'
                        )
                    ),
                    //'afterDelete' => 'function(link, success, data){ if(success){  $(\'#proveedores-seleccion-grid\').yiiGridView.update(\'proveedores-seleccion-grid\'); }}',
                    'deleteButtonUrl' => 'Yii::app()->createUrl(\'documentoProveedor/deleteEmail/id/\'. $data->id)',
                ),
            ),
        ));
        ?>
	    </div>


	    </div>
	    <?php echo $form->error($model,'email_responsable'); ?>
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
			<?php	if($model->id_docpro>0){
				$this->widget( 'bootstrap.widgets.BootButton',array(
					'buttonType'=>'submit',
		            'type'=>'primary',
		            'icon'=>'arrow-up white',
		            'label'=>'Guardar y Cargar Documentos'
				) );
			} ?>
			<br><br>
			<?php
				if(array_intersect( array('CYC987'), Yii::app()->user->permisos)){ 
					$this->widget( 'bootstrap.widgets.BootButton',array(
	                    	'buttonType'=>'button', 
	                        'type'=>'danger', 
	                        'icon'=>'trash white',
	                        'label'=>'Eliminar Contrato',
	                        'htmlOptions'=>array(
								'id'=>'btnElim'
							),
	                    )						
					); 
                }  
             ?>
		</div>

	</div>
	<div class="span7" id="divCont">
	<?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo));  ?>
	<br/>
            <p>Si requiere modificar un archivo pdf por favor ingrese en el siguiente campo una o varias sucesiones de im&aacute;genes por ejemplo: 1-5,8,10-20, se guardara un archivo con las p&aacute;ginas 1 a la 5, 8, continuando con las p&aacute;ginas 10 a la 20.</p>
            <?php echo CHtml::textField('paginas'); ?>
				<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Guardar Datos',
			)); ?>
	<br/><br/>
            <?php echo $form->fileField($model,'archivo_cambio');?>
				<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Reemplazar Imagen',
			)); ?>
        <br/><br/>
        <div class="well">
        <br/>
                <?php $this->widget('bootstrap.widgets.BootButton', array(
                                                    'label'=>'Relacionar Otro Proveedor',
                                                    'url'=>'#myModalProv',
                                                    'type'=>'primary',
                                                    'htmlOptions'=>array('data-toggle'=>'modal', 'style' => 'margin:-9px 0px 0px 35px; '),
                                                )); ?>
                 
                <?php 
                $this->widget('bootstrap.widgets.BootGridView',array(
                  	'id'=>'proveedores-grid',
                  	'dataProvider'=> DocumentoProveedorAdicional::model()->search($model->id_docpro),
                  	'type'=>'striped bordered condensed',
                    'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
                  	'columns'=>array(
                    'proveedor',
                    array(
                        'header'=>'Razón Social',
                        'value'=>'$data->idProveedor->razon_social'
                    ),
                    array(
                    	'header'=>'Ceder Contrato',
                    	'class'=>'CButtonColumn',
                      	//'class'=>'bootstrap.widgets.BootButtonColumn',
                      	'template' => '{asigna}',
                      	'buttons'=>array(
					        'asigna' => array(
					        	'label'=>false,
					            'url'=>'$data->id_docproadi',
					            'click'=>'function(){asignaProveedor($(this).parent().find("a").attr("href"));return false;}',
					            'options'=>array('class'=>'icon-retweet'),
					        ),
					    ),
                    ),
                    array(
                    	'header'=>'Eliminar',
                      	'class'=>'bootstrap.widgets.BootButtonColumn',
                      	'template' => '{delete}',
                      	'buttons'=>array(
					        'delete' => array(
					        	'label'=>false,
					            'url'=>'$data->id_docproadi',
					            'click'=>'function(){deleteProveedor($(this).parent().find("a").attr("href"));return false;}',
					            'options'=>array('class'=>'icon-trash'),
					        ),
					    ),
                    ),
                  ),
                )); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        
	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModalProv', 'htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar cuenta contable</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
  	<div align="right">
	  	<?
	  		$this->widget( 'bootstrap.widgets.BootButton',array(
	            	'buttonType'=>'button', 
	                'type'=>'primary', 
	                'icon'=>'plus-sign white',
	                'label'=>'Crear Proovedor',
	                'htmlOptions'=>array(
						'id'=>'btnCrea'
					),
	            )						
			); ?>
	</div>
	<br>      
  <?php 
  $this->widget('bootstrap.widgets.BootGridView',array(
    'id'=>'proveedores-seleccion-grid',
    'dataProvider'=>  $proveedores->searchAgregar($model->id_docpro),
    'type'=>'striped bordered condensed',
    'filter'=>  $proveedores,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'columns'=>array(
      'nit',
      'razon_social',
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
        'template' => '{select}',
        'buttons'=>array
                  (
                    'select' => array
                                    (
                                      'label' => "<i class='icon-ok'></i>", 
                                      'url' => 'Yii::app()->createUrl("documentoProveedor/addProveedor", array("id_docpro"=>'.$model->id_docpro.', "nit" => $data->nit))',
                                      'options'=>array(
                                         'title' => 'Seleccionar',  
                                          'class'=> 'adiccionar-proveedor',
                                         "onClick"  => '(function(e, obj){ 
                                            $("#myModalProv").modal("hide");
                                          })(event, this)', 
//                                        'onClick'=>	'jQuery.ajax({\'url\':\'$(this).attr("href")\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
//                                                if(data.status == \'success\'){
//                                                        $(\'#myModalProv\').modal(\'hide\');
//                                                        resetGridView("proveedores-grid");
//                                                }else{
//                                                    alert(\'algo paso\');
//                                                }
//                                        },\'cache\':false});return false;'                               
                                      ),
                                    ),
                  ),
      ),
    ),
  )); ?>

  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("cuenta-contable-grid");$("#myModal2").modal("hide");$("#crearCostosModal").modal();'),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>


	    <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModalEmail', 'htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Agregar Email</h3>
  </div>
   
  <div id="modal-content-email" class="modal-body">
  

  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Aceptar',
          'url'=>Yii::app()->createUrl('documentoProveedor/addEmail/id/'.$model->id_docpro),
          //'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("cuenta-contable-grid");$("#myModal2").modal("hide");$("#crearCostosModal").modal();'),
        	'htmlOptions' => array('id' => 'form_email', 'type' => 'submit'),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>


</div>
<?php
	$this->renderPartial('documento_detalle',array('model_detalle'=>$model_detalle,'model'=>$model));
 $this->renderPartial('_trazabilidad',array('model_traza'=>$model_traza,'model'=>$model));

 ?>

 <script>
 $(document).ready(function() {


        $(document).on("click", ".nuevoEmail", function (e) {
        	
            e.preventDefault();
            var url = '<?php echo Yii::app()->createUrl('documentoProveedor/addEmail/id/'.$model->id_docpro) ?>';
            $.ajax({'url': url, 'type': 'post', 'dataType': 'json', 'success': function (data)
                {
                    if (data.status == 'success') {
                        $('#modal-content-email').html(data.content);
                        $('#myModalEmail').modal('show');
                    }
                    else {
                        return false;
                    }
                }, 'cache': false});
        });


        $(document).on("click", "#form_email", function (e) {
            e.preventDefault();
            var form = $('#email-form');
            var url = $('#email-form').attr('action');
            $.ajax({'url': url, 'type': 'post', 'dataType': 'json',
                'data': form.serialize(),
                'success': function (data)
                {
                    if (data.status == 'success') {
                        $('#myModalEmail').modal('toggle');
                        $('#modal-content-email').html('');
                        $('#emails-grid').yiiGridView.update('emails-grid');
                    }
                    else {
                        $('#modal-content-email').html(data.content);
                    }
                }, 'cache': false});
        });

        $('#DocumentoProveedor_valor').maskMoney({decimal:'.',precision:2});
        $('#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_dia').maskMoney();
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

	/*$("#myModal").on('hidden', function(){
    	$('#miSolicitudGrid').yiiGridView('update');
    	location.href="<?=Yii::app()->getBaseUrl(true).Yii::app()->getHomeUrl()?>/credito/consulta/miSolicitud";
    });*/

    $('#myModal').on('hide.bs.modal', function (e) {
	 	$("#divCont").show();
	});
	$('#myModal').on('show.bs.modal', function (e) {
	  	$("#divCont").hide();
	});
	$('#myModalProv').on('hide.bs.modal', function (e) {
	 	$("#divCont").show();
	});
	$('#myModalProv').on('show.bs.modal', function (e) {
	  	$("#divCont").hide();
	});	

	$('#btnElim').on('click', function(){
  		if(confirm("¿Esta seguro de Eliminar el contrato?, esta acción no tiene reversa.")){
  			var idCon = $("#id_cont").val();

	       	<?	echo CHtml::ajax(array(
	            'url'=>array('documentoProveedor/eliminaContrato'), 
	            'data'=>array('id'=>'js:idCon'), 
	            'dataType'=>'json',
	            'success'=> "function(data){
	            	if(data.save){
	            		alert('El contrato fue eliminado correctamente.');
	            		location.href='gestion';
	            	}else{
	            		alert('El contrato no pudo ser eliminado.');
	            	}
	            }"
	        ))
			?>;
		}

  	});

  	$('#btnCrea').on('click', function(){  
  		location.href="<?=Yii::app()->getBaseUrl(true).Yii::app()->getHomeUrl()?>/proveedor/create";	
  	});

	//Bloqueo de campos
	$('#DocumentoProveedor_valor_indefinido').click(function() {
        if ($('#DocumentoProveedor_valor_indefinido').is(':checked')) {
                        $('#DocumentoProveedor_valor').val(0);
                        $('#DocumentoProveedor_moneda').val('');
			$("#DocumentoProveedor_valor").prop('disabled', true);
			$("#DocumentoProveedor_moneda").prop('disabled', true);
		}else{
			$("#DocumentoProveedor_valor").prop('disabled', false);
			$("#DocumentoProveedor_moneda").prop('disabled', false);
		}
	});
	
	$('#DocumentoProveedor_fecha_fin_ind').click(function() {
        if ($('#DocumentoProveedor_fecha_fin_ind').is(':checked')) {
            $('#DocumentoProveedor_fecha_fin').val('');
			$("#DocumentoProveedor_fecha_fin").prop('disabled', true);
		}else{
			$("#DocumentoProveedor_fecha_fin").prop('disabled', false);
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
	
	if( $('#DocumentoProveedor_fecha_fin_ind').is(':checked')) {
        $('#DocumentoProveedor_fecha_fin').val('');
        $("#DocumentoProveedor_fecha_fin").prop('disabled', true);
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
          //  console.log(data);
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
    $(".adiccionar-proveedor").live("click", function(e){
        e.preventDefault();
        addProveedor($(this).attr("href"));
    });
    function addProveedor(url)
    {
    jQuery.ajax({'url': url ,'type':'post','dataType':'json','success':function(data)
        {
            if(data.status == 'success'){
                $('#myModalProv').modal('hide');
                resetGridView("proveedores-grid");
                resetGridView("proveedores-seleccion-grid");
            }

        } ,'cache':false});
    
    return false;  
    }

});

    function agregarEmail(email)
    {
    	var url = '<?php echo Yii::app()->createUrl('documentoProveedor/agregarEmail/id/'.$model->id_docpro) ?>';
        $.ajax({'url': url, 'type': 'post', 'dataType': 'json',
            'data': {'email': email},
            'success': function (data)
            {
                if (data.status == 'success') {
                    $('#emails-grid').yiiGridView.update('emails-grid');
                }
                else {
                	alert('No Guardo');
                }
            }, 'cache': false});
    	return false;  
    }
	function asignaProveedor(id_pro){
    	if(confirm("¿Esta seguro de ceder el contrato al nuevo proveedor?")) {
	    	<?	echo CHtml::ajax(array(
	            'url'=>array('documentoProveedor/asignaProveedor'), 
	            'data'=>array('id_pro'=>'js:id_pro'), 
	            'dataType'=>'json',
	            'success'=> "function(data){
	            	if(data.save){
	            		alert('El contrato fue cedido correctamente.');	  
	            		resetGridView('proveedores-grid');
	            		$('#nomProv').html('<h4>'+data.nombre+'</h4>');          		
	            	}else{
	            		alert('El contrato no pudo ser cedido.');
	            	}
	            }"
	        ))
			?>;
		}
    }

    function deleteProveedor(id){
    	if(confirm("¿Esta seguro de eliminar el proveedor?")) {
	    	<?	echo CHtml::ajax(array(
	            'url'=>array('documentoProveedor/deleteProvAdicional'), 
	            'data'=>array('id'=>'js:id'), 
	            'dataType'=>'json',
	            'success'=> "function(data){	  
            		resetGridView('proveedores-grid'); 
	            }"
	        ))
			?>;
		}
    }
</script>