<b>Resumen de la Factura</b>
<br/><br/>
<table border='1' bordercolor="#CCC" cellpadding="4">
	<tr>
		<td bgcolor="#E9E9E9">Número de la Factura</td>
		<td><?php echo $factura->nro_factura; ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Nit</td>
		<td><?php echo $factura->nitProveedor->nit; ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Nombre Proveedor</td>
		<td><?php echo $factura->nitProveedor->razon_social; ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">fecha Recibido</td>
		<td><?php echo $factura->fecha_recibido; ?></td>
	</tr>
</table>


