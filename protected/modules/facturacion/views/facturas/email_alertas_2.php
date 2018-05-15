<html>
<head>
	<meta charset="utf-8">
</head>
<body>

<p>Señor usuario,</p>


<p>Se ha creado una factura para el número de identificación <?php echo $factura->nit_proveedor ?> el cual tiene alertas que se relacionan a continuación.<p/>
<br/>
<b>Alertas</b>
<br/><br/>
<table border='1' bordercolor="#CCC" cellpadding="4">
    
	<tr>
		<td bgcolor="#E9E9E9">Clientes No Deseables</td>
		<td>Este nit se encuentra en al menos una lista de clientes no deseables</td>
	</tr>
        
</table>
<br/>
<p>Muchas gracias.</p>

<em>Esta es una notificación automática. Por favor no responder.</em>

</body>
</html>