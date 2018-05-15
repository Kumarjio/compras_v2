<html>
<head>
	<meta charset="utf-8">
</head>
<body>

<p>Señor usuario,</p>


<p>A continuación se relaciona los contratos que estan pronto a vencerse.<p/>
<br/>
<b>Resumen de Contratos</b>
<br/><br/>
<table border='1' bordercolor="#CCC" cellpadding="4">
	<tr>
		<td bgcolor="#E9E9E9">Tipo Documento</td>
		<td bgcolor="#E9E9E9">Proveedor</td>
		<td bgcolor="#E9E9E9">Nombre Proveedor</td>
		<td bgcolor="#E9E9E9">Nombre Contrato</td>
		<td bgcolor="#E9E9E9">Fecha Inicio</td>
		<td bgcolor="#E9E9E9">Fecha Fin</td>
		<td bgcolor="#E9E9E9">No. Documentos</td>
		<td bgcolor="#E9E9E9">Estado</td>
	</tr>
	<?php foreach($contratos as $model) {?>
	<tr>
		<td><?php echo $model->tipo_documento_rel->tipo_documento; ?></td>
		<td><?php echo $model->traerNits(); ?></td>
		<td><?php echo $model->traerRazonSocial(); ?></td>
		<td><?php echo $model->nombre_contrato; ?></td>
		<td><?php echo (strlen($model->fecha_inicio)>0) ? date("Y-m-d",strtotime($model->fecha_inicio) ) : ""; ?></td> 	
		<td><?php echo (strlen($model->fecha_fin)>0) ? date("Y-m-d",strtotime($model->fecha_fin) ) : ""; ?></td>
		<td><?php echo DocumentoProveedor::numDocs($model->id_docpro); ?></td>
		<td><?php echo $model->estado_rel->estado; ?></td>
	</tr>
	<?php } ?>
</table>

<br/>

<br/>
<b>Resumen de Pólizas</b>
<br/><br/>
<table border='1' bordercolor="#CCC" cellpadding="4">
	<tr>
		<td bgcolor="#E9E9E9">Tipo Documento</td>
		<td bgcolor="#E9E9E9">Proveedor</td>
		<td bgcolor="#E9E9E9">Nombre Proveedor</td>
		<td bgcolor="#E9E9E9">Fecha Inicio</td>
		<td bgcolor="#E9E9E9">Fecha Fin</td>
		<td bgcolor="#E9E9E9">Póliza</td>
		<td bgcolor="#E9E9E9">Tipo póliza</td>
		<td bgcolor="#E9E9E9">Fecha Inicio</td>
		<td bgcolor="#E9E9E9">Fecha fin</td>
	</tr>
	<?php foreach($polizas as $p) {
		$model = DocumentoProveedor::model()->findByAttributes(array('id_docpro'=>$p->id_doc_pro_padre));
		$poliza = PolizaDocumento::model()->findByAttributes(array('id_docpro' => $p->id_docpro ));
	?>
	<tr>
		<td><?php echo $model->tipo_documento_rel->tipo_documento; ?></td>
		<td><?php echo $model->traerNits(); ?></td>
		<td><?php echo $model->traerRazonSocial(); ?></td>
		<td><?php echo (strlen($model->fecha_inicio)>0) ? date("Y-m-d",strtotime($model->fecha_inicio) ) : ""; ?></td> 	
		<td><?php echo (strlen($model->fecha_fin)>0) ? date("Y-m-d",strtotime($model->fecha_fin) ) : ""; ?></td>
		<td><?php echo $poliza->id_docpro; ?></td>
		<td><?php echo $poliza->tipoPoliza->tipo_poliza; ?></td>
		<td><?php echo $poliza->fecha_inicio; ?></td>
		<td><?php echo $poliza->fecha_fin; ?></td>
	</tr>

	<?php } ?>
</table>

<p>Muchas gracias.</p>

<em>Esta es una notificación automática, por favor no responder.</em>

</body>
</html>