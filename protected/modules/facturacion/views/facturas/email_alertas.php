<html>
<head>
	<meta charset="utf-8">
</head>
<body>

<p>Señor usuario,</p>


<p>Se ha creado una factura para el número de identificación <?php echo $factura->nit_proveedor ?> el cual tiene alertas que se relacionan a continuacion.<p/>
<br/>
<b>Alertas</b>
<br/><br/>
<table border='1' bordercolor="#CCC" cellpadding="4">
        <?php if($lista->indicador1 == 2) { ?>
        <tr>
		<td bgcolor="#E9E9E9">Maestro de Clientes</td>
		<td>El nit no existe en AS400</td>
	</tr>
        <?php } if($lista->indicador3 == 2){ ?>
	<tr>
		<td bgcolor="#E9E9E9">Documentos</td>
		<td>El proveedor tiene documentos incompletos</td>
	</tr>
        <?php }  if($lista->indicador4 == 2){ ?>
	<tr>
		<td bgcolor="#E9E9E9">Documentos</td>
		<td>El proveedor tiene documentos vencidos</td>
	</tr>
        <?php } ?>
</table>
<br/>
<p>Muchas gracias.</p>

<em>Esta es una notificación automática. Por favor no responder.</em>

</body>
</html>