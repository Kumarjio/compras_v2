<html>
<head>
	<meta charset="utf-8">
</head>
<body>

<p>Señor usuario,</p>


<p>El contrato con la compañia <?php echo $model->proveedor_rel->razon_social ?> y que se relaciona el resumen a continuación esta pronto a vencerse .<p/>
<br/>
<b>Resumen del Contrato</b>
<br/><br/>
<table border='1' bordercolor="#CCC" cellpadding="4">
	<tr>
		<td bgcolor="#E9E9E9">Tipo Documento</td>
		<td><?php echo $model->tipo_documento_rel->tipo_documento; ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Proveedor</td>
		<td><?php echo $model->traerNits(); ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Nombre Proveedor</td>
		<td><?php echo $model->traerRazonSocial(); ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Fecha Inicio</td>
		<td><?php echo (strlen($model->fecha_inicio)>0) ? date("Y-m-d",strtotime($model->fecha_inicio) ) : ""; ?></td> 
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Fecha Fin</td>
		<td><?php echo (strlen($model->fecha_fin)>0) ? date("Y-m-d",strtotime($model->fecha_fin) ) : ""; ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">No. Documentos</td>
		<td><?php echo DocumentoProveedor::numDocs($model->id_docpro); ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Estado</td>
		<td><?php echo $model->estado_rel->estado; ?></td>
	</tr>
</table>

<br/>

<p>Muchas gracias.</p>

<em>Esta es una notificación automática, por favor no responder.</em>

</body>
</html>