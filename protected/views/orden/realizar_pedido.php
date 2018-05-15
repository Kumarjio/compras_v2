<?php
$this->breadcrumbs=array(
	'Realizar Pedido',
);

$this->menu=array(
  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
  array('label'=>'Realizar Pedido','url'=>array('/Orden/realizarPedido', 'id' => $model->id),'icon'=>'headphones'),
  array('label'=>'Productos seleccionados','url'=>array('/detalleOrdenCompra/admin', 'id_orden' => $model->id),'icon'=>'tags'),
  array('label'=>'Ordenes de compra','url'=>array('/OrdenCompra/admin', 'id_orden' => $model->id),'icon'=>'list-alt'),
  array('label'=>'Solicitar cancelación','url'=>array('/orden/solicitarCancelacion', 'id' => $model->id),'icon'=>'remove-sign', 'visible' => $puede_editar),
);

?>

	<div class="alert alert-block alert-warning fade in">
		<h2>Orden de servicio No. <b><?php echo $model->id; ?></b></h2>
	</div>

	<?php if(!$puede_editar): ?>
	<div class="alert alert-error" role="alert">
      <strong>Atención!</strong> Esta orden de compra está congelada pues la solicitud de compra <?php echo $nueva ?> está en curso
      y busca reemplazarla.
    </div>
	<?php endif ?>


	<div class="panel panel-default">
		 <div class="panel-heading" align="center"><big><strong class="gris"><!--i class="fa fa-exclamation-circle"></i--> I. Datos Generales de la Orden</strong></big></div>
		 <div class="panel-body">
        <p><strong>Nombre de la compra: </strong><?php echo $model->nombre_compra; ?></p>
		<p><strong>Tipo de la compra: </strong><?php echo $model->tipo_compra; ?></p>
		<p><strong>Descripcion: </strong><?php echo $model->resumen_breve; ?></p>
	
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
</div>
	<div class="panel panel-default">
		 <div class="panel-heading" align="center"><big><strong class="gris"><!--i class="fa fa-exclamation-circle"></i--> II. Productos</strong></big></div>
		 <div class="panel-body">
			<?php
				$solicitudes = OrdenProducto::model()->findAllByAttributes(array('id_orden' => $model->id), array('order' => 'id ASC'));
				if(count($solicitudes) > 0){
					$form=$this->beginWidget('booster.widgets.TbActiveForm',array( 
					    'id'=>'documentos-vpj-form', 
					    'enableAjaxValidation'=>false, 
						'action' => $this->createUrl('colocarPedido', array('id'=>$model->id))
					));
		          foreach($solicitudes as $i => $p){
		            //$p = ProductoOrden::model()->findByAttributes(array("orden_solicitud" => $s->id));
		            if($p->rechazado)
		              continue;
						//$direcciones = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $s->id));
						$producto = Producto::model()->findByPk($p->id_producto);
						if($p->id_marco_detalle == ""){
							$cotizacion = CotizacionOp::model()->findByPk($p->getIdCotizacion());
							$marco = false;
						}
						else{
							$cotizacion = OmCotizacion::model()->findByPk($p->getIdCotizacionOm());
							$marco = true;
						}

                        //$proveedor = Proveedor::model()->findByPk($s->getNitProveedor());
                        $proveedor = Proveedor::model()->findByPk($cotizacion->nit);
						?>
						<div class="panel panel-warning">
	 						<div class="panel-heading">
							<p><strong>Producto: </strong><?php echo $producto->nombre; ?></p>
							<p><strong>NIT Proveedor: </strong><?php echo $proveedor->nit; ?></p>
							<p><strong>Razon Social Proveedor: </strong><?php echo $proveedor->razon_social; ?></p>
							</div>
	 						<div class="panel-body">
						<table class="table table-striped table-bordered table-condensed" width="100%">
							<tr>
								<th>Direccion</th>
								<th>Ciudad</th>
								<th width="140px;">Cantidad Disponible</th>
								<th width="140px">Cantidad a Solicitar</th>
                                <th width="110px">Fecha Entrega</th>
							</tr>
						<?php
						//foreach($direcciones as $j =>$d){
							?>
								<tr>
									<td><?php echo $p->direccion_entrega; ?></td>
									<td><?php echo $p->ciudad; ?></td>
									<td><center><?php echo $p->cantidadDisponible(); ?><center>
							<?php
							$do = new DetalleOrdenCompraOp;
							$do->id_orden_producto = $p->id;
							$do->id_orden = $p->id_orden;
							$do->id_producto = $p->id_producto;
							$do->id_proveedor = $proveedor->nit;
							if($marco)
								$do->id_cotizacion_om = $cotizacion->id;
							else
                            	$do->id_cotizacion = $cotizacion->id;
                            $hoy = time();
                            $nf = $hoy + (60*60*24);
                            if($s->fecha_entrega < date('Y-m-d',$nf)){
                              $do->fecha_entrega = date('Y-m-d',$nf);
                            }else{
                              $do->fecha_entrega = $s->fecha_entrega;
                            }

							?>
									<td><?php 
									echo $form->hiddenField($do,"[$i]id_orden_producto");
									echo $form->hiddenField($do,"[$i]id_producto");
									echo $form->hiddenField($do,"[$i]id_orden");
									echo $form->hiddenField($do,"[$i]id_cotizacion");
									echo $form->hiddenField($do,"[$i]id_cotizacion_om");
                                    echo $form->hiddenField($do,"[$i]id_proveedor");
									echo $form->textFieldGroup($do,"[$i]cantidad", array('label'=>array(),'widgetOptions'=>array('htmlOptions'=>array('placeholder'=>''))));
                                    ?>
                                    </td><td>
                                    <?php
                                    echo $form->datePickerGroup(
										$do,
										"[$i]fecha_entrega",
										array(
											'widgetOptions' => array(
												'options' => array(
													'language' => 'es',
									                'format' => 'yyyy-mm-dd',
									                'startDate'=>date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))),
													'autoclose' => 'true',
													'showAnim'=>'fold',
												),
											),
											'htmlOptions' => array(
												'placeholder'=>'',
											),
											'label'=>array(),
										)
									);
                                    ?>
									</td>
								</tr>
							<?php
						//}
						?>
						</table>
					</div>
				</div>	
						<?php
					}
				}
				?>

				<?php if($puede_editar): ?>

					<div class="form-actions">
						<?php $this->widget('bootstrap.widgets.BootButton', array(
							'buttonType'=>'submit',
							'type'=>'primary',
							'label'=>'Realizar Pedido',
						)); ?>
					</div>

				<?php endif ?>
				<?php
				$this->endWidget();
			?>
