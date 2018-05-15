<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'ver-mas-modal','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>
<div class="modal-header">
<a class="close" data-dismiss="modal">&times;</a>
<h3>Razón Elección</h3>
</div> 
<div id="ver-mas-modal-content" class="modal-body"></div>
<div class="modal-footer">
<?php $this->widget('bootstrap.widgets.BootButton', array(
  'label'=>'Cerrar',
  'url'=>'#',
  'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
)); ?>
</div>
<?php $this->endWidget(); ?>


<center><h2>FORMATO DE SOLICITUD DE COMPRAS</h2></center>
<br/><br/>

<?php if(in_array('CYC995',(Yii::app()->user->permisos))): ?>
<p>
<a href="<?php echo $this->createUrl('orden/solicitarCancelacion', array('id'=>$orden->id)); ?>" class="btn btn-warning">Solicitar cancelacion a compras</a>
</p>

<?php endif ?>

<table border='1' bordercolor="#CCC" cellpadding="4">
	<tr>
		<td bgcolor="#E9E9E9">Número de la Solicitud</td>
		<td><?php echo $orden->id; ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Tipo de Compra</td>
		<td><?php echo $orden->tipoCompra->nombre; ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Nombre de la Compra</td>
		<td><?php echo $orden->nombre_compra; ?></td>
	</tr>
	<?php if($orden->id_vicepresidencia != ""): ?>
	<tr>
		<td bgcolor="#E9E9E9">Vicepresidencia</td>
		<td><?php echo $orden->idVice->nombre; ?></td>
	</tr>
	<?php endif; ?>
	<?php if($orden->id_gerencia != ""): ?>
	<tr>
		<td bgcolor="#E9E9E9">Dirección</td>
		<td><?php echo $orden->idGerencia->nombre; ?></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td bgcolor="#E9E9E9">Jefatura</td>
		<td><?php echo ($orden->idJefatura == null)?"":$orden->idJefatura->nombre; ?></td>
	</tr>
</table>
<br/>

<h3>Trazabilidad</h3>
<?php echo $tabla; ?>
<br/>

<h3>Observaciones</h3>
<?php echo $observaciones; ?>
<br/>

<h3>Ordenes que reemplaza</h3>
<?php echo $tablaReemp; ?>
<br/>


<h4>INFORMACIÓN DE LOS SOLICITANTES:</h4>
<br/>
<table border='1' bordercolor="#CCC" cellpadding="5">
	<tr>
		<th bgcolor="#E9E9E9">Rol</td>
		<th bgcolor="#E9E9E9">Nombre Completo</td>
	</tr>
	<tr>
		<td>Solicitante</td>
		<td><?php echo $orden->idUsuario->nombre_completo; ?></td>
	</tr>
	<tr>
		<td>Jefe Solicitante</td>
		<td><?php echo ($orden->idJefe == null)?"":$orden->idJefe->nombre_completo; ?></td>
	</tr>
	<?php if($orden->id_gerencia != ""): ?>
	<tr>
		<td>Dirección</td>
		<td><?php echo $orden->idGerente->nombre_completo; ?></td>
	</tr>
	<?php endif; ?>
	<?php if($orden->id_vicepresidencia != ""): ?>
	<tr>
		<td>Vicepresidente</td>
		<td><?php echo $orden->idVicepte->nombre_completo; ?></td>
	</tr>
	<?php endif; ?>
</table>
<br/>
<p>Nota: Cada usuario certificó que las características y cantidades solicitadas fueron revisadas y son necesarias para desarrollo de la compañía.</p>
<br/><br/>

<h4>JUSTIFICACIÓN GENERAL:</h4>

<?php echo $orden->resumen_breve; ?>

<br/><br/>

<h4>DESCRIPCIÓN DETALLADA Y JUSTIFICACIÓN DEL(LOS) SERVICIO(S) O PRODUCTO(S) A COMPRAR:</h4>
<br/>
<?php
	$ordenes_solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $orden->id));
	foreach($ordenes_solicitudes as $os){
		$osc = OrdenSolicitudCostos::model()->findAllByAttributes(array('id_orden_solicitud' => $os->id));
		echo $this->renderPartial('_view_orden_solicitud', array('model' => $os, 'model_orden_solicitud_costos' => $osc), true);

	}
?>
<br/><br/>
<h4>RESULTADO DE LA NEGOCIACIÓN Y RESUMEN ALTERNATIVAS DE PROVEEDOR(ES):</h4>
<br/>
<?php foreach($productos_orden as $producto): ?>
	<?php 
  if($producto->rechazado)
    continue;

	$ahorro = 0;
	$ahorro_total = 0;
	foreach ($producto->cotizacions as $cot) {
		if($cot->elegido_comite == 1){

		  $ahorro += Cotizacion::ahorro($cot->id, $producto->id)*$cot->total_compra_pesos;
		  $ahorro_total += $ahorro;
		}
	}
	
	$cotizacion_model=new Cotizacion('search');
	$cotizacion_model->unsetAttributes();  // clear any default values
	if(isset($_GET['Cotizacion'])){
		$cotizacion_model->attributes=$_GET['Cotizacion'];
	}

	
	$this->widget('bootstrap.widgets.BootGridView',array(
		'id'=>'cotizacion-grid_'.$producto->id,
		'dataProvider'=>$cotizacion_model->search($producto->id),
		'type'=>'striped bordered condensed',
		'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
		'columns'=>array(
			array(
				'header' => 'Razon Social',
				'name' => 'nit',
				'value' => '$data->nit0->razon_social'
			),
			'cantidad',
			array(
				'name' => 'valor_unitario',
				'value' => 'Orden::formatoMoneda($data->valor_unitario)'
			),
			'moneda',
			array(
				'name' => 'total_compra',
				'value' => 'Orden::formatoMoneda($data->total_compra)'
			),
			array(
				'name' => 'total_compra_pesos',
				'value' => 'Orden::formatoMoneda($data->total_compra_pesos)'
			),
			array(
				'name' => 'descripcion',
				'header' => 'Descripcion de la Negociación',
				'type' => 'raw',
				'value' => '$data->descripcion',
				'visible' => '$data->razon_eleccion_usuario != null'
			),
			array(
				'header' => 'Adjuntos Cotizacion',
				'type' => 'raw',
				'value' => 'Cotizacion::model()->adjuntos($data->adjuntosCotizacions)'

			),
			array(			
				'header' => 'Elección',	
    			'type'=>'raw',
    			'value'=>'Orden::model()->elecciones($data->elegido_compras, $data->elegido_comite, $data->elegido_usuario, $data);'	            
	        ),
		),
	)); 

	if($ahorro > 0){
		echo "<b>Ahorro de las cotizaciones anteriores: ".Orden::formatoMoneda($ahorro)."</b>";
	}

	?>

<?php endforeach ?>

<?php 

if($ahorro_total > 0){
	echo "<h3>Ahorro total de la orden: ".Orden::formatoMoneda($ahorro_total)."</h3>";
}

echo "<h3>Costo total de la orden: ".Orden::formatoMoneda($orden->costo_total())."</h3>";

?>
<br/><br/>

<?php
$asistentes_comite = AsistenteComite::model()->findAllByAttributes(array('id_orden' => $orden->id));
$cuantos_asistieron = count($asistentes_comite);

if($cuantos_asistieron > 0){
?>

<h4>APROBACIÓN INSTANCIA REQUERIDA:</h4>
<br/>
<?php
	echo "<p>Instancia de aprobación: Comité de Compras.</p>";

	if($cuantos_asistieron > 0){
		echo "<table border='1' bordercolor='#CCC' cellpadding='4' width='100%'><tr><th bgcolor='#E9E9E9'>Nombre</th><th bgcolor='#E9E9E9'>Firma</th></tr>";
		foreach($asistentes_comite as $ac){
			echo "<tr><td>".$ac->empleado->nombre_completo."</td><td></td></tr>";
		}
		echo "</table>";
	}




?>

<? } ?>
<br/><br/>

<?php

if(count($pagos) > 0){
?>

<h4>FORMA DE PAGO:</h4>
<br/>


<table border='1' bordercolor='#CCC' cellpadding='4' width='100%'>
<tr>
  <th bgcolor='#E9E9E9'>Tipo</th>
  <th bgcolor='#E9E9E9'>Porcentaje/Cuotas</th>
  <th bgcolor='#E9E9E9'>Total/Mensualidad</th>
</tr>

<?php




		foreach($pagos as $p){
          $total = 0;
          if($p['tipo'] == "Mensualidad"){
            $total = $elegida->cotizacions[0]->total_compra_pesos;
          }else{
            $total = ($elegida->cotizacions[0]->total_compra_pesos * (1/$p['porcentaje']) * 100);          
          }
         echo "<tr><td>".$p['tipo']."</td><td>".$p['porcentaje']."</td><td>".Orden::formatoMoneda($total)."</td></tr>";
		}
		echo "</table>";


?>

<? } ?>

<br/>

<br/>

<h4>ORDENES DE COMPRA</h4>
<?php echo $tablaordenes; ?>
<br/>


