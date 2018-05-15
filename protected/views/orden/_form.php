<?php 

Yii::app()->clientScript->registerScript('register_static_css_js', "                                                                               
$(function() {                                                                                                                                         
	script_files = $('script[src]').map(function() { return $(this).attr('src'); }).get();                                                                                                                                          
	css_files = $('link[href]').map(function() { return $(this).attr('href'); }).get();                                                                                                                                          
});");

?>

<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'orden-form',
	'enableAjaxValidation'=>false,
	)); ?>

<?php if ($paso_actual != "swOrden/en_negociacion" && $paso_actual != "swOrden/analista_compras"): ?>	
	<div class="alert alert-block alert-warning fade in">

   <?php if($model->id < 500000000): ?>
		<h2>Solicitud de Compra No. <b><?php echo $model->id; ?></b></h2> 
   <?php else: ?>
		<h2>Formato de Solicitud de Compra</h2> 
   <?php endif ?>
	</div>
<?php endif ?>

	<div id="general"></div>

	<?php echo $form->errorSummary($model); ?>

	<?if ($paso_actual == "swOrden/en_negociacion" or $paso_actual == "swOrden/analista_compras"):
		echo $this->renderPartial('orden_ro', array('model' => $model), true);
	else: ?>
	
	<div class="well" id="info-orden-id">
		<h2>I. Datos Generales de la Orden</h2><br />
		<div class="orden_row_view">
			<p><b>Usuario Solicitante: </b><?php echo $model->idUsuario->nombre_completo; ?></p>
		</div>
                <input type="hidden" id="form_saved" value="<?php echo $model->nombre_compra; ?>" />
                <label for="Orden_tipo_compra">Tipo de Compra <span class="required">*</span></label>
				
		<?php echo $form->dropDownList($model,
		'tipo_compra',
		CHtml::listData(TipoCompra::model()->findAll(),"id","nombre"),
  array('prompt' => 'Seleccione...','class'=>'span5','data-sync'=>'true')); ?>

  <label for="Orden_tipo_compra">Tipo de negociación <span class="required">*</span></label>
  <?php echo $form->dropDownList($model,
		'negociacion_directa',
		CHtml::listData(Orden::model()->tiposNegociacion(),"id","nombre"),
  array('prompt' => 'Seleccione...','class'=>'span5','data-sync'=>'true')); ?>


		<label for="Orden_nombre_compra">Nombre Solicitud de Compra <span class="required">*</span></label>
                <?php echo $form->textField($model,'nombre_compra',array('class'=>'span5','maxlength'=>255, 'data-sync'=>'true')); ?>
                <br><br>
		<label for="Orden_resumen_breve">Justificación de la Solicitud <span class="required">*</span></label>
  <?php echo $form->textArea($model,'resumen_breve',array('rows'=>6, 'cols'=>50, 'class'=>'span8','data-sync'=>'true')); ?>

		<label for="Orden_vicepresidencia">Vicepresidencia <span class="required">*</span></label>
		<?php echo $form->dropDownList($model,
		                                 'id_vicepresidencia',
		                                 CHtml::listData(Vicepresidencias::model()->findAll(),"id","nombre"),
		                                 array('prompt' => 'Seleccione...',
		                                       	'class'=>'span5',
						       					'data-sync'=>'true',
		                                       	'onChange' => CHtml::ajax(array(
		                                       		'type' => 'post',
		                                       		'dataType' => 'json',
		                                       		'data' => array('vice' => 'js:this.value'),
		                                       		'url' => $this->createUrl("Vicepresidencias/gerenciasJefaturas"),
									                'success'=>'function(data){
									                	if(data.status == "ok"){
										                	$("#Orden_"+data.id).html(data.options);
										                	$("#Orden_"+data.id_vacio).html(data.vacio);
										                	if(data.id_vacio == "id_gerencia"){
										                		$("#Orden_"+data.id_vacio).attr("disabled","disabled");
										                	}
										                	else
									                			$("#Orden_id_gerencia").removeAttr("disabled");
			                                       			$("#Orden_id_vicepresidente").val(data.id_vicepre);	
				                                       		$("#nombre_vicepresidente").val(data.nombre_vice);
		                                       				$("#Orden_id_gerente").val("");	
			                                       			$("#nombre_gerente").val("");
                                                            $("#nombre_jefe").val("");
			                                       		}
			                                       		else{
			                                       			alert(data.mensaje);
		                                       				$("#Orden_id_vicepresidencia").val("");	
			                                       			$("#nombre_vicepresidente").val("");
										                	$("#Orden_id_gerencia").html(data.options_gerencia);
		                                       				$("#Orden_id_gerente").val("");	
			                                       			$("#nombre_gerente").val("");
                                                            $("#nombre_jefe").val("");
			                                       		}
									                }',
		                                       		)))); ?>
	  
		<label for="Orden_gerencia">Gerencia <span class="required">*</span></label>
		<?php echo $form->dropDownList($model,
		                                 'id_gerencia',
		                                 ($model->id_vicepresidencia != "")? CHtml::listData(Gerencias::model()->findAll("id_vice = ".$model->id_vicepresidencia),"id","nombre") : CHtml::listData(Gerencias::model()->findAll("id_vice is null and activo = true"),"id","nombre"),
		                                 array('prompt' => 'Seleccione...',
		                                       'class'=>'span5',
						       'data-sync'=>'true',
		                                       'onChange' => CHtml::ajax(array(
		                                       		'type' => 'post',
		                                       		'dataType' => 'json',
		                                       		'data' => array('gerencia' => 'js:this.value'),
		                                       		'url' => $this->createUrl("gerencias/jefaturas"),
		                                       		'success' => 'function(data){
		                                       			if(data.status == "ok"){
		                                       				$("#Orden_id_jefatura").replaceWith(data.combo);
			                                       			$("#Orden_id_gerente").val(data.gerente.id);	
			                                       			$("#nombre_gerente").val(data.gerente.nombre);
                                                                                $("#nombre_jefe").val("");
		                                       			}else{
		                                       				alert(data.mensaje);
		                                       				$("#Orden_id_gerente").val("");	
			                                       			$("#nombre_gerente").val("");
                                                            $("#nombre_jefe").val("");
                                                            $("#Orden_id_jefatura").html(data.jefatura_vacio);
		                                       			}
		                                       				
		                                       		}')))); ?>
	  

	  <?php 
	  	if($model->id_gerencia != "") {
	  		$jefaturas = CHtml::listData( Jefaturas::model()->findAllByAttributes(array('id_gerencia' => $model->id_gerencia)), "id", "nombre");
	  		if(!$model->idGerencia->activo && $model->id_vicepresidencia != ""){
	  			$jefaturas = CHtml::listData( Jefaturas::model()->findAllByAttributes(array('id_vice' => $model->id_vicepresidencia)), "id", "nombre");
	  		}
	  	}
	  	elseif($model->id_vicepresidencia != ""){
	  		$jefaturas = CHtml::listData( Jefaturas::model()->findAllByAttributes(array('id_vice' => $model->id_vicepresidencia)), "id", "nombre");
	  	}
	  	else{
	  		$jefaturas = array();
	  	}
	  
	  ?>
                        <label for="Orden_tipo_compra">Jefatura <span class="required">*</span></label>
			<?php echo $form->dropDownList($model,
			                                 'id_jefatura',
			                                 $jefaturas,
			                                 array('prompt' => 'Seleccione...',
                                                   'class' => 'span5',
							       'data-sync'=>'true',
							       'id' => 'Orden_id_jefatura',
							       'onChange' => CHtml::ajax(array(
											       'type' => 'post',
		                                       		'dataType' => 'json',
		                                       		'data' => array('jefatura' => 'js:this.value'),
		                                       		'url' => $this->createUrl("jefaturas/nombrejefe"),
		                                       		'success' => 'function(data){
		                                       			if(data.status == "ok"){
			                                       			$("#Orden_id_jefe").val(data.jefe.id);	
			                                       			$("#nombre_jefe").val(data.jefe.nombre);
			                                       			//$("#Orden_centro_costos").val(data.costos.id);	
			                                       			//$("#centro_costos").val(data.costos.nombre);			
		                                       			}else{
		                                       				alert(data.mensaje);
		                                       				$("#Orden_id_jefe").val("");	
			                                       			$("#nombre_jefe").val("");
			                                       			//$("#Orden_centro_costos").val("");	
			                                       			//$("#centro_costos").val("");
		                                       			}	                                       				
		                                       		}'
		                                 	 			  )
																				)
																			)); ?>
	 

    <?php echo $form->textFieldRow($model,'id_vicepresidente',array('class'=>'span1', 'readonly' => true, 'style'=>'display:none','data-sync'=>'false')); ?>
		<?php if($model->id_vicepresidente != ""): ?>
		<?php $vice = Empleados::model()->findByPk($model->id_vicepresidente); ?>
			<input class="span5" name="nombre" readonly="true" id="nombre_vicepresidente" value="<?php echo $vice->nombre_completo; ?>" type="text">
		
		<?php else: ?>
			<input class="span5" name="nombre" readonly="true" id="nombre_vicepresidente" type="text">
		<?php endif ?>

    <?php echo $form->textFieldRow($model,'id_gerente',array('class'=>'span1', 'readonly' => true, 'style'=>'display:none','data-sync'=>'false')); ?>
		<?php if($model->id_gerente != ""): ?>
		<?php $gerente = Empleados::model()->findByPk($model->id_gerente); ?>
			<input class="span5" name="nombre" readonly="true" id="nombre_gerente" value="<?php echo $gerente->nombre_completo; ?>" type="text">
		
		<?php else: ?>
			<input class="span5" name="nombre" readonly="true" id="nombre_gerente" type="text">
		<?php endif ?>

		<div id="presupuesto"></div>
		
  <?php echo $form->textFieldRow($model,'id_jefe',array('class'=>'span1', 'readonly' => true, 'style'=>'display:none','data-sync'=>'false')); ?>
		<?php if($model->id_jefe != ""): ?>
		<?php $jefe = Empleados::model()->findByPk($model->id_jefe); ?>
			<input class="span5" name="nombre" readonly="true" id="nombre_jefe" value="<?php echo $jefe->nombre_completo; ?>" type="text">
		<?php else: ?>
			<input class="span5" name="nombre" readonly="true" id="nombre_jefe" type="text">
		<?php endif ?>
	</div>		
<?php endif ?>
	<div class="well">
		<h2>II. Productos</h2><br />
		<?php 
		if($paso_actual != "swOrden/en_negociacion" and $paso_actual != "swOrden/analista_compras"){
		$this->widget('bootstrap.widgets.BootButton', array(
			'type'=>'warning',
			'label'=>'Nuevo Producto',
			'htmlOptions' => array(
				'onclick'=>CHtml::ajax(array(
					'url' => '/index.php/orden/createSolicitud/id_orden/'.$model->id,
					'success' => 'function(data){
							$(".accordion-body.collapse.in").collapse("hide");
							clean_response_generic("#accordion2", data, "append");
							updateProductNumber();
					}'
				)),
				'style' => 'margin-bottom:15px;'
			)
		)); 
		}else{ ?>
			
			<script type="text/javascript">
				$(function(){
					$('#info-orden-id input, #info-orden-id textarea, #info-orden-id select').attr('disabled', 'disabled');
				});
			</script>
			
		<?php }
		?>
		<div id="detalle"></div>
		
		<div id="solicitudes-container">
			
			<div class="accordion" id="accordion2">
			
			<?php
				$solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $model->id), array('order' => 'id ASC'));
				if(count($solicitudes) > 0){
					foreach($solicitudes as $s){
						$model_orden_solicitud_costos=new OrdenSolicitudCostos('search');
						$model_orden_solicitud_costos->unsetAttributes();  // clear any default values
						if(isset($_GET['OrdenSolicitudCostos'])){
							$model_orden_solicitud_costos->attributes=$_GET['OrdenSolicitudCostos'];
						}
						
						$model_orden_solicitud_proveedor=new OrdenSolicitudProveedor('search');
						$model_orden_solicitud_proveedor->unsetAttributes();  // clear any default values
						if(isset($_GET['OrdenSolicitudProveedor'])){
							$model_orden_solicitud_proveedor->attributes=$_GET['OrdenSolicitudProveedor'];
						}
						
						$model_orden_solicitud_direccion=new OrdenSolicitudDireccion('search');
						$model_orden_solicitud_direccion->unsetAttributes();  // clear any default values
						if(isset($_GET['OrdenSolicitudDireccion'])){
							$model_orden_solicitud_direccion->attributes=$_GET['OrdenSolicitudDireccion'];
						}
						
						$arch=new AdjuntosOrden('search');
						$arch->unsetAttributes();  // clear any default values
						if(isset($_GET['AdjuntosOrden'])){
							$arch->attributes=$_GET['AdjuntosOrden'];
						}
						?>
						
						      
					<?php
						if($paso_actual == "swOrden/en_negociacion" or $paso_actual == "swOrden/analista_compras"){
							echo $this->renderPartial('_orden_solicitud_readonly', array('model' => $s, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'divid' => $s->id, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
						}else{
							echo $this->renderPartial('_orden_solicitud_form', array('model' => $s, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'divid' => $s->id, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
						}
						?>
						<?php
					}
				}
			
			?>
		</div>
	</div>

	
</div>

<div class="well">
		<h2>III. Compras reemplazadas</h2><br />

		<p>Relacione, en caso de ser necesario, las ordenes que se estan reemplazanado con la solicitud actual.
			Esto permitirá cancelar ordenes que ya fueron aprobadas y que nunca serán utilizadas.</p>

			<div class="well">
				<div style="width:100%; overflow:hidden;">
					<button onclick="jQuery.ajax({'url':'/index.php/orden/crearReemplazo/id_orden/<?php echo $model->id ?>','dataType':'json','type':'post','success':function(data){
										if(data.status == 'success'){
											$('#crearProveedorModal #proveedor-modal-content').html(data.content);
											$('#crearProveedorModal h3').html('Agregar orden a reemplazar');
											$('#crearProveedorModal').modal('show');
										}else{
										}
									},'cache':false});return false;"
									 class="btn btn-warning" type="button">Agregar orden a reemplazar</button>
	            </div>

	            <div style="overflow:scroll;">
					<?php $this->widget('bootstrap.widgets.BootGridView',array(
						'id'=>'orden-reemplazos-grid',
						'dataProvider'=>$reemplazos->search($model->id),
						'type'=>'striped bordered condensed',
						'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
						'filter'=>$reemplazos,
						'columns'=>array(
							array(
						      'header' => 'Orden Vieja',
						      'name' => 'id',
						      'type' => 'raw',
						      'value' => 'CHtml::link($data->orden_vieja, Yii::app()->createUrl("orden/print", array("orden"=>$data->orden_vieja)), array("target" => "_blank"))'
						    ),
							array(
								'name' => 'nombre_compra',
								'value' => '$data->orden->nombre_compra',
								'filter' => false
							),
							array(
									'class'=>'bootstrap.widgets.BootButtonColumn', 
									'template' => '{delete}',
									'buttons'=>array(
										'delete' => array
											(
												'url'=>'Yii::app()->createUrl("orden/deleteReemplazo", array("id"=>$data->id))',
												'options'=>array('class'=>'delete')
											),
									  )		
							)
						),
					))?>
				</div>
			</div>

		
</div>


				<div class="well">
					<b>Observaciones</b>
					<?php $this->widget('bootstrap.widgets.BootGridView',array(
						'id'=>'observaciones-wfs-grid',
						'dataProvider'=>$observaciones->search("Orden", $model->id),
						'type'=>'striped bordered condensed',
						'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
						'filter'=>$observaciones,
						'columns'=>array(
							array(
								'header'=>'Usuario',
								'name' => 'usuario',
								'value' => '$data->idUsuario->nombre_completo'
								),
								array(
									'header'=>'Est. anterior',
									'name'=>'estado_anterior',
									'filter'=>SWHelper::allStatuslistData($model),
									'value'=>'Orden::model()->labalEstado($data->estado_anterior)'
									),
									array(
										'header'=>'Est. nuevo',
										'name'=>'estado_nuevo',
										'filter'=>SWHelper::allStatuslistData($model),
										'value'=>'Orden::model()->labalEstado($data->estado_nuevo)'
										),

										'observacion',
										'fecha',
									),
									)); ?>
								</div>

								<div class="alert alert-block alert-warning fade in">

									<?php echo $form->textAreaRow($model,'observacion', array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
								</div>

				


					<?php if($paso_actual == "swOrden/llenaroc" || $paso_actual == "swOrden/suspendida" || $paso_actual == "swOrden/devolucion"): ?>
						<div class="alert alert-block alert-warning fade in">
				  <?php $model->validacion_usuario = null; echo $form->checkBoxRow($model,'validacion_usuario'); 
				 		//echo $form->checkBoxRow($model,'negociacion_directa');
					?>
						</div>
					<?php endif ?>

					<?php if($paso_actual == "swOrden/jefe"): ?>
						<div class="alert alert-block alert-warning fade in">
				  <?php $model->validacion_jefe = null; echo $form->checkBoxRow($model,'validacion_jefe');
				 		//echo $form->checkBoxRow($model,'negociacion_directa');
 						?>
						</div>
					<?php endif ?>

					<?php if($paso_actual == "swOrden/gerente"): ?>
						<div class="alert alert-block alert-warning fade in">
				  <?php $model->validacion_gerente = null; echo $form->checkBoxRow($model,'validacion_gerente');
				 		//echo $form->checkBoxRow($model,'negociacion_directa');
 						?>
						</div>
					<?php endif ?>

				
				


				<div class="alert alert-block alert-warning fade in">
				  
				  

				  <label for="Orden_paso_wf">Estado Siguiente <span class="required">*</span></label>
				  <?php echo $form->dropDownList($model,'paso_wf',SWHelper::nextStatuslistData($model), array('class' => 'span5')); ?>
									<a class="badge badge-info" rel="popover" data-content="El paso marcado con '*' es el actual. Puede dejar este paso si quiere continuar mas adelante con el diligenciamiento de este formulario" data-original-title="Ayuda">?</a>
								</div>



								<div class="form-actions">
									<?php $this->widget('bootstrap.widgets.BootButton', array(
										'buttonType'=>'submit',
										'type'=>'primary',
										'label'=>$model->isNewRecord ? 'Crear' : 'Enviar',
										//'htmlOptions' => array('onClick' => "if($('#solicitudes-container').find('div.no-guardado-aun').size() != 0){return confirm('Tiene un producto sin guardar, desea proceder?');	}"
										'htmlOptions' => array('onClick' => "$(\".guardarSolicitud\").click();if($(\"#solicitudes-container .alert-error\").length != 0 ){ showProductsWithErrors(); setTimeout(function(){alert('Error en los productos. Verifique para continuar.'); updateProductNumber();}, 500); return false;	}else{ me_puedo_ir = true }"
										)
										)); ?>
									</div>


									<?php $this->endWidget(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		var id_gerencia = '<?php echo $model->id_gerencia?>';
		if(id_gerencia == '')
			$("#Orden_id_gerencia").attr("disabled","disabled");
	});
</script>