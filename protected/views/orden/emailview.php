<b>Resumen de la Solicitud</b>
<br/><br/>
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
	<tr>
		<td bgcolor="#E9E9E9">Justificación</td>
		<td><?php echo $orden->resumen_breve; ?></td>
	</tr>
	<?php if($orden->id_vicepresidencia != ""): ?>
	<tr>
		<td bgcolor="#E9E9E9">Vicepresidencia</td>
		<td><?php echo $orden->idVice->nombre; ?></td>
	</tr>
	<?php endif; ?>
	<?php if($orden->id_gerencia != ""): ?>
	<tr>
		<td bgcolor="#E9E9E9">Gerencia</td>
		<td><?php echo $orden->idGerencia->nombre; ?></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td bgcolor="#E9E9E9">Jefatura</td>
		<td><?php echo $orden->idJefatura->nombre; ?></td>
	</tr>
</table>
<br/><br/>
<b>1. INFORMACIÓN DE LOS SOLICITANTES:</b>
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
		<td><?php echo $orden->idJefe->nombre_completo; ?></td>
	</tr>
	<?php if($orden->id_vicepresidencia != ""): ?>
	<tr>
		<td>Vicepresidente</td>
		<td><?php echo $orden->idVicepte->nombre_completo; ?></td>
	</tr>
	<?php endif; ?>
	<?php if($orden->id_gerencia != ""): ?>
	<tr>
		<td>Gerente</td>
		<td><?php echo $orden->idGerente->nombre_completo; ?></td>
	</tr>
	<?php endif; ?>
</table>
<br/>

<br/><br/>
<b>2. DESCRIPCIÓN DETALLADA:</b>
<br/>

<?php

	$ordenes_solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $orden->id));
	foreach($ordenes_solicitudes as $os){
		$osc = OrdenSolicitudCostos::model()->findAllByAttributes(array('id_orden_solicitud' => $os->id));
		echo $this->renderPartial('/orden/_view_email', array('model' => $os, 'model_orden_solicitud_costos' => $osc), true);
	}
?>
<br/>
<?php 

if($orden->paso_wf != 'swOrden/usuario'){
  echo $orden->getActionLinks();
  echo '<br/><br/><br/>';
}
?>




