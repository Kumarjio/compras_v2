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


	<div class="well" id="info-orden-id">
		<h2>I. Datos Generales de la Orden</h2><br />
        <p><strong>Nombre de la compra: </strong><?php echo $model->nombre_compra; ?></p>
		<p><strong>Tipo de la compra: </strong><?php echo $model->tipo_compra; ?></p>
		<p><strong>Descripcion: </strong><?php echo $model->resumen_breve; ?></p>
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
	
	<div class="well">
		<h2>II. Productos</h2><br />
		
			<?php
				$solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $model->id), array('order' => 'id ASC'));
				if(count($solicitudes) > 0){
					$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
					    'id'=>'documentos-vpj-form', 
					    'enableAjaxValidation'=>false, 
						'action' => '/index.php/orden/colocarPedido/id/'.$model->id
					));
          foreach($solicitudes as $i => $s){
            $p = ProductoOrden::model()->findByAttributes(array("orden_solicitud" => $s->id));
            if($p->rechazado)
              continue;
						$direcciones = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $s->id));
						$producto = Producto::model()->findByPk($s->getIdProducto());
						$cotizacion = Cotizacion::model()->findByPk($s->getIdCotizacion());
                        //$proveedor = Proveedor::model()->findByPk($s->getNitProveedor());
                        $proveedor = Proveedor::model()->findByPk($cotizacion->nit);
						?>
						<div class="well">
							<p><strong>Producto: </strong><?php echo $producto->nombre; ?></p>
							<p><strong>NIT Proveedor: </strong><?php echo $Proveedor->nit; ?></p>
							<p><strong>Razon Social Proveedor: </strong><?php echo $proveedor->razon_social; ?></p>
						<table class="table table-striped table-bordered table-condensed" width="100%">
							<tr>
								<th>Direccion</th>
								<th>Ciudad</th>
								<th width="140px;">Cantidad Disponible</th>
								<th width="140px">Cantidad a Solicitar</th>
                                <th width="110px">Fecha Entrega</th>
							</tr>
						<?php
						foreach($direcciones as $j =>$d){
							?>
								<tr>
									<td><?php echo $d->direccion_entrega; ?></td>
									<td><?php echo $d->ciudad; ?></td>
									<td><center><?php echo $d->cantidadDisponible(); ?><center></td>
							<?php
							$do = new DetalleOrdenCompra;
							$do->id_orden_solicitud = $s->id;
							$do->id_orden = $s->id_orden;
							$do->id_producto = $producto->id;
							$do->id_proveedor = $proveedor->nit;
							$do->id_direccion = $d->id;
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
									echo $form->hiddenField($do,"[$i][$j]id_orden_solicitud");
									echo $form->hiddenField($do,"[$i][$j]id_producto");
									echo $form->hiddenField($do,"[$i][$j]id_orden");
									echo $form->hiddenField($do,"[$i][$j]id_cotizacion");
                                    echo $form->hiddenField($do,"[$i][$j]id_proveedor");
									echo $form->hiddenField($do,"[$i][$j]id_direccion");
									echo $form->textField($do,"[$i][$j]cantidad", array('style'=>'width:130px'));
                                    ?>
                                    </td><td>
                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                                  'model'=>$do,
                                                                                  'attribute'=>"[$i][$j]fecha_entrega",
                                                                                  'name'=>"[$i][$j]fecha_entrega",
                                                                                  'language' => 'es',
                                                                                  // additional javascript options for the date picker plugin
                                                                                  'options'=>array(
                                                                                                   'showAnim'=>'fold',
                                                                                                   'dateFormat' => 'yy-mm-dd',
                                                                                                   'minDate' => '+1d'
                                                                                                   ),
                                                                                  'htmlOptions'=>array(
                                                                                                       'style'=>'width:100px;'
                                                                                                       ),
                                                                                  ));
                                    ?>
									</td>
								</tr>
							<?php
						}
						?>
						</table>
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

	</div>
