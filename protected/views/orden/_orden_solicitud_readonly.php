<div class="accordion-group" id='grupo-<?php echo $model->id; ?>'>
	<div id="accordion-heading-<?php echo $model->id; ?>" class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse-<?php echo $model->id; ?>">Producto #<span class="numero-producto"></span>:   <span id="accordion-title-<?php echo $model->id; ?>"><?php echo ($model->nombre == '')?'Producto sin Nombre':$model->nombre.' - '.$model->cantidad.' - '.$model->fecha_entrega; ?></span>
		</a>
	</div>
	<div id="collapse-<?php echo $model->id; ?>" class="accordion-body collapse in">
		<div class="accordion-inner">
            <?php
              $producto_orden_model = ProductoOrden::model()->findByAttributes(array('orden_solicitud' => $model->id));
              if($producto_orden_model != null and $producto_orden_model->rechazado == true){

                echo $this->renderPartial('/orden/_producto_rechazado', array('po' => $producto_orden_model), true);
              }
            ?>
			<div class="orden-solicitud-accordion-inner<?php if($model->cantidad == null){echo ' no-guardado-aun';} ?>" style="<?php 
		$hoy = time();
		$nf = $hoy + (60*60*24*7);
		$fecha_f = date('Y-m-d',$nf);
		if($model->fecha_entrega != "" && $model->fecha_entrega <= $fecha_f){ ?>background-color:#F2DEDE;<?php }else{ ?> background-color:#F2F2F2; <?php } ?>" id="orden-solicitud-<?php if(!$model->isNewRecord){echo $model->id;} ?>" >
			<div class="porque-rojo alert alert-block alert-info" style="
			<?php if($model->fecha_entrega != "" && $model->fecha_entrega <= $fecha_f){ ?>display:block;<?php }else{ ?> display:none; <?php } ?>"><b>La fecha máxima de aprobación para la compra está muy próxima.</b></div>
				<?php 
				echo CHtml::hiddenField('ro','true');
				echo CHtml::activeHiddenField($model,'id');
				echo CHtml::activeHiddenField($model,'id_orden');
				?>
				<div style="overflow:hidden;">
					<div class="orden_solicitud_row_view">
						<p><b>Nombre: </b><?php echo $model->nombre; ?></p>
					</div>
					<div class="orden_solicitud_row_view">
						<p><b>Cantidad: </b><?php echo $model->cantidad; ?></p>
					</div>
					<div class="orden_solicitud_row_view">
						<p><b>Fecha máxima de aprobación para la compra: </b><?php echo $model->fecha_maxima_aprobacion; ?></p>
					</div>
					<div class="orden_solicitud_row_view">
						<p><b>Fecha de Entrega: </b><?php echo $model->fecha_entrega; ?></p>
					</div>
					<div class="orden_solicitud_row_view" style="width:625px; float:none;">
						<p><b>Detalle: </b><?php echo $model->detalle; ?></p>
					</div>
				</div>
				<div style="margin:20px 0 0 20px; ">
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
						Requiere Póliza de Cumplimiento
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
			</div>				
				<?php 
				if(!$model->isNewRecord){
					echo '<div class="well">';
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
						), 
						));
						echo '</div>';
					}
					?>

					<?php 
					if(!$model->isNewRecord){
						echo '<div class="well">';
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
											'template' => '{subir}',
											'buttons'=>array
												(
											'subir' => array
												(
											'url' => '"/index.php/orden/subir/ro/true/orden_solicitud_proveedor/".$data->id',
											'icon' => 'file',
											'label' => 'Archivos',
											'options' => array(
												'class' => 'subir-archivos'
													)	
												),
											),
										), 
									), 
									));
									echo '</div>';
								}
								?>

								<?php 
								if(!$model->isNewRecord){
									echo '<div class="well">';
									$this->widget('bootstrap.widgets.BootGridView',array( 
										'id'=>'orden-solicitud-costos-grid-'.$model->id, 
										'dataProvider'=>$model_orden_solicitud_costos->search($model->id), 
										//'filter'=>$model_orden_solicitud_costos,
										'type'=>'striped bordered condensed',
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
										), 
										)); 
										echo '</div>';
									}
									?>

									<div class="well">
										<b>Archivos Adjuntos</b><br/><br/>
									  	<?php $this->widget('bootstrap.widgets.BootGridView',array(
										'id'=>'adjuntos-orden-grid'.$model->id,
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
									</div>
									
									<?php
									if($model->idOrden->paso_wf != 'swOrden/analista_compras'): 
										$producto = ProductoOrden::model()->findByAttributes(array('orden_solicitud' => $model->id));
										?>
										
										<div class="well">
											
											
											<div style="display:inline; font-size:18px; margin-right:5px;"><b>Nombre del producto: </b><span id="nombre-producto-<?php echo $producto->id ?>"><?php echo ($producto->producto == null)?'Producto no seleccionado aún':$producto->producto0->nombre; ?></span>    </div>
											<?php 
											if($model->idOrden->paso_wf == 'swOrden/en_negociacion'){ 
											$this->widget('bootstrap.widgets.BootButton', array(
													    'label'=>'Seleccionar Producto',
													    'url'=>'#productoModal',
													    'type'=>'primary',
													    'htmlOptions'=>array('data-toggle'=>'modal', 'style' => 'margin:-9px 0px 0px 5px;', 'onClick' => 'id_producto_actual ='.$producto->id.';'),
													)); 
											}		
                                            $this->widget('bootstrap.widgets.BootButton', array(
													    'label'=>'Rechazar Producto',
													    'type'=>'danger',
													    'htmlOptions'=>array('data-toggle'=>'modal', 'style' => 'cursor:pointer; margin:-9px 0px 0px 5px;', 'onClick' => 'id_producto_actual ='.$producto->id.';',
                                                          'id' => 'rechazar-producto-'.$model->id,
                                                          'class' => 'razon_rechazo',
                                                          'data-model' => $model->id,
                                                          'data-url' => Yii::app()->controller->createAbsoluteUrl('productoOrden/rechazarProducto', array('id' => $model->id))
                                                        ),
                                                        
											)); 
											
											?>
											<br/>
											<br/>
											<div style="overflow:hidden; width:100%;">
											<div class="pull-right" style="margin-bottom:10px;">
												<?php 
												if($model->idOrden->paso_wf == 'swOrden/en_negociacion'){ 
												$this->widget('bootstrap.widgets.BootButton', array(
													'buttonType'=>'submit',
													'type'=>'warning',
													'label'=>'Nueva Cotización',
													'htmlOptions' => array(
														'class'=>"crear-cotizacion",
														'data-url' => $this->createUrl('cotizacion/create', array('prodorden' => $producto->id))
													 )
												)); 
												}
												?>
											</div>
											</div>
											<div>

												<?php $this->widget('bootstrap.widgets.BootGridView',array(
													'id'=>'cotizacion-grid_'.$producto->id,
													'dataProvider'=>$cotizacion_model->search($producto->id),
													'type'=>'striped bordered condensed',
													'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
													'filter'=>$cotizacion_model,
													'columns'=>array(

														array(
															'header' => 'Razon Social',
															'name' => 'razon_social',
															'value' => '$data->nit0->razon_social'
														),
														'cantidad',
														array(
															'name' => 'valor_unitario',
															'value' => 'Orden::formatoMoneda($data->valor_unitario)'
														),
														array(
															'name' => 'total_compra',
															'value' => 'Orden::formatoMoneda($data->total_compra)'
														),
														array(
															'name' => 'moneda',
														),
														array(
															'name' => 'descripcion',
															'header' => 'Descripcion de la Negociación',
															'type' => 'raw',
															'value' => 'ProductoOrden::model()->get_descripcion_2($data->descripcion, $data->id, "A")',
															'visible' => '$data->razon_eleccion_usuario != null'
														),
														/*
														array(
															'name' => 'razon_eleccion_usuario',
															'type' => 'raw',
															'value' => 'ProductoOrden::model()->get_descripcion($data->razon_eleccion_usuario, $data->id, "B")',
															'visible' => '$data->razon_eleccion_usuario != null'
														),
														array(
															'name' => 'razon_eleccion_compras',
															'type' => 'raw',
															'value' => 'ProductoOrden::model()->get_descripcion($data->razon_eleccion_compras, $data->id, "C")',
															'visible' => '$data->razon_eleccion_usuario != null'
														),
														array(
															'name' => 'razon_eleccion_comite',
															'type' => 'raw',
															'value' => 'ProductoOrden::model()->get_descripcion($data->razon_eleccion_comite, $data->id, "D")',
															'visible' => '$data->razon_eleccion_comite != null'
														),		
														*/
														array(			
															'header' => 'Elección',	
									            			'type'=>'raw',
									            			'value'=>'Orden::model()->elecciones($data->elegido_compras, $data->elegido_comite, $data->elegido_usuario, $data);'	            
												        ),	
														array(
									            			'type'=>'raw',
									            			'value'=>'($data->enviar_cotizacion_a_usuario == 1)?"<i class=\"icon-user\"></i>":""',
									           				'visible' => Orden::model()->iconoUsuarioVisible($model->idOrden->id)
												        ),
												/*
														array(
															'name'=>'elegido_compras',					
									            			'type'=>'html',
									            			'value'=>'($data->elegido_compras)?"<span class=\"label label-warning\">Elegido</span>":""'		            
												        ),
												        array(
															'name'=>'elegido_usuario',					
									            			'type'=>'html',
									            			'value'=>'($data->elegido_usuario)?"<span class=\"label label-warning\">Elegido</span>":""'		            
												        ),
														array(
															'name'=>'elegido_comite',					
									            			'type'=>'html',
									            			'value'=>'($data->elegido_comite)?"<span class=\"label label-warning\">Elegido</span>":""'		            
												        ),
												*/
														/*
														'descripcion',
														'elegido_compras',
														'elegido_usuario',
														*/
														array(
															'class'=>'bootstrap.widgets.BootButtonColumn',
															'template' => '{elegir}{enviar}{ver}{subir}{consultar}{update}{duplicate}{regalos}{delete}',
															'htmlOptions' => array(
																'style'=>'width:112px'
															),
															'buttons'=>array
															    (
																	'subir' => array
																	(
																		'url' => '"/index.php/cotizacion/subir/id/".$data->id',
																		'icon' => 'file',
																		'label' => 'Archivos',
																		'options' => array(
																			'class' => 'subir-archivos'
																		),
																		'visible' => '$data->productoOrden->orden0->paso_wf == "swOrden/en_negociacion" or $data->productoOrden->orden0->paso_wf == "swOrden/validacion_cotizaciones" or $data->productoOrden->orden0->paso_wf == "swOrden/gerente_compra" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobar_por_atribuciones" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobar_por_comite" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobado_por_comite" or $data->productoOrden->orden0->paso_wf == "swOrden/vicepresidente_compra" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobar_por_junta" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobado_por_presidencia" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobado_por_atribuciones"'
																	),
																	'enviar' => array
																	(
																		'url' => '"/index.php/cotizacion/agregarPagosACotizacion/id/".$data->id',
																		'icon' => 'share',
																		'label' => 'Enviar a Usuario',
																		'options' => array(
																			'class' => 'enviar-cotizacion-a-usuario'
																			),
																		'visible' => '$data->productoOrden->orden0->paso_wf == "swOrden/en_negociacion"'
																	),
																	'ver' => array
																	(
																		'url' => '"/index.php/cotizacion/verMas/id/".$data->id',
																		'icon' => 'eye-open',
																		'label' => 'Ver',
																		'options' => array(
																			'class' => 'ver-mas-cotizacion'
																		)	
																	),
																	'elegir' => array
															        (
																		'url' => (Yii::app()->user->getState('analista_compras'))?
																				 '"/index.php/cotizacion/elegir/prodord/".$data->producto_orden."/id/".$data->id':
																				 ((Yii::app()->user->getState('comite_compras') && $model->idOrden->paso_wf =="swOrden/aprobar_por_comite")? 
																				 '"/index.php/cotizacion/elegircomite/prodord/".$data->producto_orden."/id/".$data->id':


																				 ((Yii::app()->user->getState('presidencia') || Yii::app()->user->getState('junta'))?
																				 '"/index.php/cotizacion/elegircomite/prodord/".$data->producto_orden."/id/".$data->id':
																				 '"/index.php/cotizacion/elegirUsuario/prodord/".$data->producto_orden."/id/".$data->id'
																				)),
																		'icon' => 'check',
																		'label' => 'Elegir',
																		'visible' => '($data->productoOrden->orden0->paso_wf == "swOrden/en_negociacion" or $data->productoOrden->orden0->paso_wf == "swOrden/validacion_cotizaciones" or $data->productoOrden->orden0->paso_wf == "swOrden/gerente_compra" or $data->productoOrden->orden0->paso_wf == "swOrden/vicepresidente_compra" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobar_por_junta" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobar_por_comite") and $data->enviar_cotizacion_a_usuario == 1',
																		'options' => array(
                                                                                       'class' => (Yii::app()->user->getState('analista_compras'))?'elegir-cotizacion':
																						((Yii::app()->user->getState('comite_compras'))? 
																						 'elegir-cotizacion-comite':
																						 ((Yii::app()->user->getState('presidencia') || Yii::app()->user->getState('junta'))?
																						 'elegir-cotizacion-comite':
																						 'elegir-cotizacion-us'
                                                                                          )),
																			'data-prodorden' => $producto->id
																		)

															        ),
																	'consultar' => array
															        (
																		'url' => '"/index.php/cotizacion/proveedor/prodord/".$data->producto_orden."/nit/".$data->nit."/excluir/".$data->id',
																		'icon' => 'th-list',
																		'label' => 'Ver Todas',
																		'visible' => (Yii::app()->user->getState('analista_compras') and false)?'true':'false',
																		'options' => array(
																			'class' => 'ver-otras'
																		)

															        ),
															        'update' => array
															        (
																		'url' => '"/index.php/cotizacion/update/id/".$data->id',
																		'visible' => (Yii::app()->user->getState('analista_compras'))?'true':'false',
																		'options' => array(
																			'class' => 'actualizar-cotizacion'
																		)	
															        ),
																	'duplicate' => array
															        (
																		'url' => '"/index.php/cotizacion/create/prodorden/'.$producto->id.'/cid/".$data->id',
																		'icon' => 'icon-plus',
																		'label' => 'Duplicar',
																		'visible' => (Yii::app()->user->getState('analista_compras'))?'true':'false',
																		'options' => array(
																			'class' => 'duplicar-cotizacion'
																		)	
															        ),
																	'regalos' => array
																	(
																		'url' => '"/index.php/cotizacion/agregarRegalosCotizacion/id/".$data->id',
																		'icon' => 'headphones',
																		'label' => 'Asignar Regalos',
																		'options' => array(
																			'class' => 'asignar-regalos'
																			),
																		'visible' => '$data->productoOrden->orden0->paso_wf == "swOrden/en_negociacion"'
																	),

																	'delete' => array
															        (
																		'url' => '"/index.php/cotizacion/delete/id/".$data->id',
																		'visible' => (Yii::app()->user->getState('analista_compras'))?'true':'false'					
															        )
															    ),
														),
													),
												)); ?>
												
											</div>
										</div>
										
									<?php endif ?>
									
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
												
								</div>
							</div>
						</div>
					</div>
