<html>
<head>
	<meta charset="utf-8">
</head>
<body>

<p>Señor usuario,</p>


<p>Le ha sido pre-aprobada la siguente cita. Recuerde que debe adjuntar los documentos necerarios para la aprobación, si desea hacerlo en este momento ingrese <a href='<?php echo $url?>'>aquí</a>.<p/>
<br/>
<b>Resumen de su Cita</b>
<br/><br/>
<table border='1' bordercolor="#CCC" cellpadding="4">
	<tr>
		<td bgcolor="#E9E9E9">Fecha</td>
		<td><?php echo date("Y-m-d",strtotime($model->idDisponibilidad->fecha)); ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Hora</td>
		<td><?php echo $model->idDisponibilidad->inicio; ?></td>
	</tr>
        <?php if($model->id_especialidad == ''):?>
	<tr>
		<td bgcolor="#E9E9E9">Examen</td>
		<td><?php echo AyudasDiagnosticas::model()->findByPk($model->idDisponibilidad->idRecurso->id_relacionado)->nombre_ayuda; ?></td>
	</tr>
        <?php else: ?>
	<tr>
		<td bgcolor="#E9E9E9">Profecional</td>
		<td><?php echo Medicos::model()->nombreCompleto($model->idDisponibilidad->idRecurso->id_relacionado); ?></td>
	</tr>
	<tr>
		<td bgcolor="#E9E9E9">Especialidad</td>
		<td><?php echo $model->idEspecialidad->nombre_especialidad; ?></td> 
	</tr>
        <?php endif; ?></table>

<br/>
<p>Muchas gracias.</p>

<em>Esta es una notificación automática. Por favor no responder.</em>

</body>
</html>