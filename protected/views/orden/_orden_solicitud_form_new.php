<div class="accordion-group" id='grupo-<?php echo $model->id; ?>'>
    <div id="accordion-heading-<?php echo $model->id; ?>" class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse-<?php echo $model->id; ?>">Producto #<span class="numero-producto"></span>:   <span id="accordion-title-<?php echo $model->id; ?>"><?php echo ($model->nombre == '')?'Producto sin Nombre':$model->nombre.' - '.$model->cantidad.' - '.$model->fecha_entrega; ?></span>
      </a>
    </div>
    <div id="collapse-<?php echo $model->id; ?>" class="accordion-body collapse in">
      <div class="accordion-inner">

<div class="orden-solicitud-accordion-inner<?php if($model->cantidad == null){echo ' no-guardado-aun';} ?>" style="<?php 
$hoy = time();
$nf = $hoy + (60*60*24*7);
$fecha_f = date('Y-m-d',$nf);
if($model->fecha_entrega != "" && $model->fecha_entrega <= $fecha_f){ ?>background-color:#F2DEDE;<?php }else{ ?> background-color:#F2F2F2; <?php } ?>" id="orden-solicitud-<?php if(!$model->isNewRecord){echo $model->id;} ?>" >
<div class="porque-rojo alert alert-block alert-info" style="
<?php if($model->fecha_entrega != "" && $model->fecha_entrega <= $fecha_f){ ?>display:block;<?php }else{ ?> display:none; <?php } ?>"><span style="color:#C00;"><b>La fecha máxima de aprobación para la compra está muy próxima.</b></span></div>
  <?php echo CHtml::errorSummary($model, null, null, array('class' => 'alert alert-block alert-error')); ?>
	<div style="overflow:hidden;">
		<div class="orden_solicitud_row">
			<label for="OrdenSolicitud_nombre">Nombre <span class="required">*</span></label>
   <?php echo CHtml::activeTextField($model,'nombre',array('class'=>'span4', 'data-sync' => 'true', 'onBlur' => 'actualizarNombre("'.$model->id.'")')); ?>
		</div>
		<div class="orden_solicitud_row">
			<label for="OrdenSolicitud_cantidad">Cantidad/Número de Horas<span class="required"> * </span><a class="badge badge-info" rel="popover" data-content="Ingrese el número de horas si la solicitud es un desarrollo de software" data-original-title="Ayuda">?</a></label>
   <?php echo CHtml::activeTextField($model,'cantidad',array('class'=>'span4 numeric','data-sync' => 'true', 'onkeypress' => "return isNumberKey(event)", 'onBlur' => 'actualizarNombre("'.$model->id.'")')); ?>
<script type="text/javascript">
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>
			<?php 
			if($model->isNewRecord){
				echo '<input name="OrdenSolicitud[id]" id="OrdenSolicitud_id" type="hidden" value="-1">';
			}else{
			  echo CHtml::activeHiddenField($model,'id');
			} 
			echo CHtml::activeHiddenField($model,'id_orden');
			?>
		</div>
		<div class="orden_solicitud_row">
			<label for="OrdenSolicitud_fecha_entrega">Fecha Máxima de Aprobación para la Compra <span class="required">*</span></label>
			<?php 
			$div_id ="";
			if(!$model->isNewRecord){
				$div_id = "#orden-solicitud-".$model->id;
			}else{
				$div_id = "#orden-solicitud-";
			}
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'attribute'=>'fecha_maxima_aprobacion',
				'language' => 'es',
				// additional javascript options for the date picker plugin
				'options'=>array(
					'showAnim'=>'fold', 
					'dateFormat' => 'yy-mm-dd',
					'beforeShowDay' => 'js:jQuery.datepicker.noWeekends', 
					'onClose' => 'js:function(dateT, obj){
                        $("#OrdenSolicitud_fechaentrega_'.$model->id.'").datepicker("option", "minDate", dateT);         
						var today = new Date();
						var i = 0;
						while(i < 5){
							today.setDate(today.getDate() + 1);
							var dia = today.getDay();
							if(dia > 0 && dia < 6){
								i++;
							}					        		
						}
						//var eleccion = new Date(dateT + " 05:00:00 GMT");

                                                var eleccion_a = $.datepicker.parseDate("yy-mm-dd", dateT);
                                                //var eleccion = $.datepicker.formatDate( "yy-mm-dd", eleccion_a);

						if(eleccion_a < today){
							$("#myModalAjax .modal-header h3").html("Información Importante!");
							$("#myModalAjax .modal-body").html("La fecha de entrega seleccionada está muy próxima.\
								Contratación y  compras no puede garantizar que se realice el proceso para la fecha ingresada.");
							$("#myModalAjax").modal();
							$("'.$div_id.'").css("background-color", "#F2DEDE");
                                                        $("'.$div_id.' .porque-rojo").css("display", "block");

						}else{
							$("'.$div_id.'").css("background-color", "#F2F2F2");
                                                        $("'.$div_id.' .porque-rojo").css("display", "none");
						}
					}',
					'minDate' => '+1d'    
					),
					'htmlOptions'=>array(
						'style'=>'height:20px;',
						'data-sync' => 'true',
						'class' => 'span4',
						'id' => 'OrdenSolicitud_fecha_maxima_aprobacion_'.$model->id, 
						'onBlur' => 'setTimeout(function(){actualizarNombre("'.$model->id.'");},2000); 						               
									 setTimeout(function(){
										var forma = "OrdenSolicitud[fecha_maxima_aprobacion]="+$("#OrdenSolicitud_fecha_maxima_aprobacion_'.$model->id.'").val();
									    jQuery.ajax({
										    url:"/index.php/orden/autosavesol/id/'.$model->id.'",
										    type : \'post\',
										    data: forma,
										    success: function(data) {}
										});
									},
									2100);'
						),
						));
						?>
					</div>	
					<div class="orden_solicitud_row">
						<label for="OrdenSolicitud_fecha_entrega">Fecha de Entrega <span class="required">*  </span><a class="badge badge-info" rel="popover" data-content="La fecha de entrega esta sujeta a la negociación con el proveedor" data-original-title="Ayuda">?</a></label>
						<?php 
						$div_id ="";
						if(!$model->isNewRecord){
							$div_id = "#orden-solicitud-".$model->id;
						}else{
							$div_id = "#orden-solicitud-";
						}
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'attribute'=>'fecha_entrega',
							'language' => 'es',
							// additional javascript options for the date picker plugin
							'options'=>array(
								'showAnim'=>'fold', 
								'dateFormat' => 'yy-mm-dd',
								'minDate' => $model->fecha_maxima_aprobacion
								),
								'htmlOptions'=>array(
									'style'=>'height:20px;',
									'data-sync' => 'true',
									'class' => 'span4',
									'id' => 'OrdenSolicitud_fechaentrega_'.$model->id,
									'onClick' => 'if($("#OrdenSolicitud_fecha_maxima_aprobacion_'.$model->id.'").val() == ""){alert("Primero debe seleccionar la fecha máxima de negociación."); return false;}',
									'onBlur' => 'setTimeout(function(){
														var forma = "OrdenSolicitud[fecha_entrega]="+$("#OrdenSolicitud_fechaentrega_'.$model->id.'").val();
													    jQuery.ajax({
														    url:"/index.php/orden/autosavesol/id/'.$model->id.'",
														    type : \'post\',
														    data: forma,
														    success: function(data) {}
														});
													},
													2100);'
									),
									));
									?>
								</div>			
				</div>
				<label for="OrdenSolicitud_detalle">Detalle <span class="required">*</span></label>
			  <?php echo CHtml::activeTextArea($model,'detalle',array('rows'=>6, 'cols'=>50, 'style'=>'width:600px;','data-sync' => 'true')); ?>
				
				<p>Seleccione los que considere necesarios para este tipo de compra:</p>
				<label class="checkbox" for="OrdenSolicitud_requiere_acuerdo_servicios">
					<?php echo CHtml::activeCheckBox($model,'requiere_acuerdo_servicios', array('data-sync' => 'true')); ?>
					Acuerdo de Nivel de Servicios
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_acuerdo_confidencialidad">
					<?php echo CHtml::activeCheckBox($model,'requiere_acuerdo_confidencialidad', array('data-sync' => 'true')); ?>
					Acuerdo de Confidencialidad
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_contrato">
					<?php echo CHtml::activeCheckBox($model,'requiere_contrato', array('data-sync' => 'true')); ?>
					Contrato
				</label>
				
				<label class="checkbox" for="OrdenSolicitud_requiere_polizas">
					<?php 
					$poliza_bool = false;
					if($model->requiere_polizas_cumplimiento == 1 or $model->requiere_seriedad_oferta == 1 or $model->requiere_buen_manejo_anticipo == 1 or $model->requiere_calidad_suministro == 1 or $model->requiere_calidad_correcto_funcionamiento == 1 or $model->requiere_pago_salario_prestaciones == 1 or $model->requiere_estabilidad_oferta == 1 or $model->requiere_calidad_obra == 1 or $model->requiere_responsabilidad_civil_extracontractual == 1){
						$poliza_bool = true;
					}
					$model->requiere_polizas = $poliza_bool;
					echo CHtml::activeCheckBox($model,'requiere_polizas', array('data-sync' => 'true', 'onChange' => 'if(this.checked){$("#grupo-'.$model->id.' #polizas").slideDown();}else{if(confirm("Esta seguro que no desea incluir ninguna póliza?")){ $("#grupo-'.$model->id.' #polizas input").attr("checked", false); $("#grupo-'.$model->id.' #polizas").slideUp();}else{this.checked = true;}}')); 
					?>
					Polizas:
				</label>
				
				<div id="polizas" style="<?php if(!$poliza_bool){ ?>display:none; <?php } ?> margin-left:15px;">
				<label class="checkbox" for="OrdenSolicitud_requiere_polizas_cumplimiento">
					<?php echo CHtml::activeCheckBox($model,'requiere_polizas_cumplimiento', array('data-sync' => 'true')); ?>
					Póliza de Cumplimiento
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_seriedad_oferta">
					<?php echo CHtml::activeCheckBox($model,'requiere_seriedad_oferta', array('data-sync' => 'true')); ?>
					Seriedad de la Oferta
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_buen_manejo_anticipo">
					<?php echo CHtml::activeCheckBox($model,'requiere_buen_manejo_anticipo', array('data-sync' => 'true')); ?>
					Buen Manejo Anticipo
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_calidad_suministro">
					<?php echo CHtml::activeCheckBox($model,'requiere_calidad_suministro', array('data-sync' => 'true')); ?>
					Calidad de Suministro
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_calidad_correcto_funcionamiento">
					<?php echo CHtml::activeCheckBox($model,'requiere_calidad_correcto_funcionamiento', array('data-sync' => 'true')); ?>
					Calidad y Correcto Funcionamiento
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_pago_salario_prestaciones">
					<?php echo CHtml::activeCheckBox($model,'requiere_pago_salario_prestaciones', array('data-sync' => 'true')); ?>
					Pago de Salarios y Prestaciones
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_estabilidad_oferta">
					<?php echo CHtml::activeCheckBox($model,'requiere_estabilidad_oferta', array('data-sync' => 'true')); ?>
					Estabilidad de la Obra
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_calidad_obra">
					<?php echo CHtml::activeCheckBox($model,'requiere_calidad_obra', array('data-sync' => 'true')); ?>
					Calidad de la Obra
				</label>
				<label class="checkbox" for="OrdenSolicitud_requiere_responsabilidad_civil_extracontractual">
					<?php echo CHtml::activeCheckBox($model,'requiere_responsabilidad_civil_extracontractual', array('data-sync' => 'true')); ?>
					Responsabilidad Civil Extracontractual
				</label>
				</div>
				
				<?php 
				if(!$model->isNewRecord){
					echo '<div class="well">';
					echo '<div style="width:100%; overflow:hidden;" >';
					$this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'warning',
						'label'=> 'Agregar Dirección de Envío',
						'htmlOptions' => array(
							'onClick'=>	
								'jQuery.ajax({\'url\':\'/index.php/orden/createDireccion/id_orden_solicitud/'.$model->id.'\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
								if(data.status == \'success\'){
									$(\'#direccion-modal-content\').html(data.content);
									$(\'#crearDireccionModal\').modal(\'show\');
								}else{
								}
							},\'cache\':false});return false;',
							'style' => 'float:right; margin-bottom:5px;'
								)
								)); 
					echo '</div>';
					echo '<div>';
					$this->widget('bootstrap.widgets.BootGridView',array( 
								'id'=>'orden-solicitud-direccion-grid-'.$model->id, 
								'dataProvider'=>$model_orden_solicitud_direccion->search($model->id), 
								//'filter'=>$model_orden_solicitud_costos,
								'type'=>'striped bordered condensed',
								'columns'=>array( 
									array('header' => 'Cantidad', 'value' => '$data->cantidad'),
									array('header' => 'Responsable', 'value' => '$data->responsable'),
									array('header' => 'Direccion de Entrega', 'value' => '$data->direccion_entrega'),
									array('header' => 'Ciudad', 'value' => '$data->ciudad'),
									array('header' => 'Departamento', 'value' => '$data->departamento'),
									array('header' => 'Telefono', 'value' => '$data->telefono'),
									array( 
										'class'=>'bootstrap.widgets.BootButtonColumn', 
										'template' => '{update}{delete}',
										'buttons'=>array
											(
										'update' => array
											(
										'url'=>'Yii::app()->createUrl("orden/updateDireccion", array("id_orden_solicitud"=>'.$model->id.', "id" => $data->id))',
										'options' => array(
											'class' => 'actualizar-direccion'
												)
											),
											'delete' => array
												(
											'url'=>'Yii::app()->createUrl("orden/deleteDireccion", array("id"=>$data->id))',
											'options'=>array('class'=>'delete')
											),
										),
									), 
								), 
								)); 
								echo '</div>';
								echo '</div>';
							}
				?>
				
				<?php 
				if(!$model->isNewRecord){
					echo '<div class="well">';
					echo '<div style="width:100%; overflow:hidden;">';
					$this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'warning',
						'label'=> 'Agregar Proveedor Recomendado',
						'htmlOptions' => array(
							'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/orden/createProveedor/id_orden_solicitud/'.$model->id.'\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
								if(data.status == \'success\'){
									$(\'#proveedor-modal-content\').html(data.content);
									$(\'#crearProveedorModal\').modal(\'show\');
								}else{
								}
							},\'cache\':false});return false;',
							'style' => 'float:right; margin-bottom:5px;'
								)
								)); 
					echo '</div>';
					echo '<div>';
					$this->widget('bootstrap.widgets.BootGridView',array( 
								'id'=>'orden-solicitud-proveedor-grid-'.$model->id, 
								'dataProvider'=>$model_orden_solicitud_proveedor->search($model->id), 
								//'filter'=>$model_orden_solicitud_costos,
								'type'=>'striped bordered condensed',
								'columns'=>array( 
									array('header' => 'NIT', 'value' => '$data->nit'),
									array('header' => 'Proveedor', 'value' => '$data->proveedor'),
									array(
										'header' => 'Valor Unitario',
										'value' => 'Orden::formatoMoneda($data->valor_unitario)'
									),
									array('header' => 'Moneda', 'value' => '$data->moneda'),
									array(
										'header' => 'Total Compra',
										'value' => 'Orden::formatoMoneda($data->total_compra)' 
									),
									array( 
										'class'=>'bootstrap.widgets.BootButtonColumn', 
										'template' => '{subir}{update}{delete}',
										'buttons'=>array
											(
											'subir' => array
											(
												'url' => '"/index.php/orden/subir/orden_solicitud_proveedor/".$data->id',
												'icon' => 'file',
												'label' => 'Ver/Adjuntar Archivos',
												'options' => array(
													'class' => 'subir-archivos'
												)	
											),
										'update' => array
											(
										'url'=>'Yii::app()->createUrl("orden/updateProveedor", array("id_orden_solicitud"=>'.$model->id.', "id" => $data->id))',
										'options' => array(
											'class' => 'actualizar-proveedor'
												)
											),
											'delete' => array
												(
											'url'=>'Yii::app()->createUrl("orden/deleteProveedor", array("id"=>$data->id))',
											'options'=>array('class'=>'delete')
											),
										),
									), 
								), 
								)); 
								echo '</div>';
								echo '</div>';
							}
				?>
				
				<?php 
				if(!$model->isNewRecord){
					echo '<div class="well">';
					echo '<div style="width:100%; overflow:hidden;">';
					$this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'warning',
						'label'=> 'Agregar Centro de Costos / Cuenta',
						'htmlOptions' => array(
							'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/orden/createCostos/id_orden_solicitud/'.$model->id.'\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
								if(data.status == \'success\'){
									$(\'#costos-modal-content\').html(data.content);
									$(\'#crearCostosModal\').modal(\'show\');
								}else{
								}
							},\'cache\':false});return false;',
								)
								)); 
					echo '</div>';
					echo '<div style="overflow:scroll;">';
					$this->widget('bootstrap.widgets.BootGridView',array( 
								'id'=>'orden-solicitud-costos-grid-'.$model->id, 
								'dataProvider'=>$model_orden_solicitud_costos->search($model->id), 
								//'filter'=>$model_orden_solicitud_costos,
								'type'=>'striped bordered condensed',
								'htmlOptions' => array('style' => 'width:758px;'),
								'columns'=>array( 
									//'id',
									//'id_orden_solicitud',
									array('header' => 'Cantidad o Porcentaje', 'value' => '$data->porcentaje_o_cantidad'),
									//'porcentaje_o_cantidad',
									array('header' => 'Cantidad o Porcentaje', 'value' => '$data->numero'),
									//'numero',
									array('header' => 'Centro de Costos', 'value' => '$data->idCentroCostos->nombre'),
									array('header' => 'Cuenta Contable', 'value' => '$data->idCuentaContable->nombre'),
									//'id_centro_costos',
									//'id_cuenta_contable',
									array('header' => 'Presupuestado o Estimado?', 'value' => '$data->presupuestado'),
									array('header' => 'Valor', 'value' => '(Orden::formatoMoneda($data->valor_presupuestado))'),
									//'presupuestado',
									//'valor_presupuestado',
									array(
										'value' => '$data->mes_presupuestado',
										'header' => 'Mes'
									),
									//'paso_wf',

									array( 
										'class'=>'bootstrap.widgets.BootButtonColumn', 
										'template' => '{update}{delete}',
										'buttons'=>array
											(
										'update' => array
											(
										'url'=>'Yii::app()->createUrl("orden/updateCostos", array("id_orden_solicitud"=>'.$model->id.', "id" => $data->id))',
										'options' => array(
											'class' => 'actualizar-costos'
												)
											),
											'delete' => array
												(
											'url'=>'Yii::app()->createUrl("orden/deleteCostos", array("id"=>$data->id))',
											'options'=>array('class'=>'delete')
											),
										),
									), 
								), 
								)); 
								echo '</div>';
								echo '</div>';
							}
				?>
				
				  <div class="well">
					<b>Archivos Adjuntos</b><br/><br/>
				  	<?php $this->widget('bootstrap.widgets.BootGridView',array(
					'id'=>'adjuntos-orden-grid-'.$model->id,
					'dataProvider'=>$archivos->search($model->id),
				    //'ajaxUrl' => $this->createUrl("/adjuntosCotizacion/admin"),
					'type'=>'striped bordered condensed',
					'filter'=>$archivos,
					'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
					'columns'=>array(
				        'nombre',
						'tipi',
						array(
							'class'=>'bootstrap.widgets.BootButtonColumn',
				            'template' => '{download}{delete}',
				            'deleteButtonUrl'=>'Yii::app()->createUrl("/adjuntosOrden/delete", array("id" =>  $data["id"], "ajax" => 1))',
				            'buttons' => array(
				                'download' => array(
				                  'icon'=>'arrow-down',
				                  'url'=>'Yii::app()->createUrl("/adjuntosOrden/download", array("id" =>  $data["id"]))',
				                  'options' => array(
				                      'target' => '_blank'
				                   )
				                ),
				                'delete' => array(
				                  'visible' => 'true',
				                 )
				            )
						),
					),
					)); ?>

				    <div class="fieldset flash" id="file-uploader-<?php echo $model->id; ?>">

				    </div>
				  </div>
				<script type="text/javascript">
				/*var uploader = new qq.FileUploader({
				    // pass the dom node (ex. $(selector)[0] for jQuery users)
				    element: $('#file-uploader-<?php echo $model->id; ?>')[0],
				    // path to server-side upload script
				    action: '<?php echo $this->createUrl("orden/subirarch_o") ?>',
				    sizeLimit: 3145728,
				    messages: {
				        typeError: "Solo puede adjuntar archivos .zip",
				        sizeError: "{file} es muy grande, suba máximo {sizeLimit}.",
				        emptyError: "{file} está vacío. Seleccione de nuevo los archivos",
				        onLeave: "Se están subiendo archivos. Si abandona la página se perderá el progreso"
				    },
				    uploadButtonText: 'Adjuntar archivos',
				    cancelButtonText: 'Cancelar',
				    failUploadText: 'El archivo NO subió',
				    onSubmit: function(id, fileName){
				     	this.params.orden = <?php echo $model->id; ?>
				    },
				    onComplete: function(a,b,c){
				    	$('#adjuntos-orden-grid-<?php echo $model->id; ?>').yiiGridView.update('adjuntos-orden-grid-<?php echo $model->id; ?>'); 
				    }
				});*/
				</script>
							
				<div class="form-actions" style="background-color:#F2F2F2;">
					<?php $this->widget('bootstrap.widgets.BootButton', array(
						'buttonType'=>'button',
						'type'=>'primary',
						'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
						'htmlOptions' => array(
							'class'=>'guardarSolicitud',
							'style'=>'display:none',
							'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/orden/updateSolicitud/id_orden/'.$model->id_orden.'\',\'async\':false, \'data\':$(\'#orden-solicitud-'.$model->id.' :input\').serialize(),\'type\':\'post\',\'success\':function(data){
								clean_response_generic("#grupo-'.$model->id.'", data, "replace");
							},\'cache\':false});return false;'
								)
								)); ?>
					<?php $this->widget('bootstrap.widgets.BootButton', array(
									'buttonType'=>'button',
									'type'=>'danger',
									'label'=> 'Eliminar Producto',
									'htmlOptions' => array(
										
										'onClick'=>	'jQuery.ajax({\'url\':\'/index.php/orden/deleteSolicitud/id_orden/'.$model->id_orden.'\',\'dataType\':\'json\',\'data\':$(\'#orden-solicitud-'.$model->id.' :input\').serialize(),\'type\':\'post\',\'success\':function(data){
											if(data.id_solicitud == -1){
												$(\'#orden-solicitud-\').remove();
												if(data.status == \'success\'){
													nueva_solicitud = false;
												}
											}else{
												if(data.status == \'success\'){
													$(\'#grupo-\'+data.id_solicitud).remove();
													updateProductNumber();
												}else{
													$(\'#orden-solicitud-\'+data.id_solicitud).prepend("<div class=\'alert alert-block alert-error\'><p>Ha ocurrido un error y no se ha podido eliminar el registro</p></div>");
												}
											}
										},\'cache\':false});return false;'
											)
					)); ?>
				</div>
</div>

</div>
</div>
</div>
