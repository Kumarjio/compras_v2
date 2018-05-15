
<div class="alert alert-block alert-warning fade in">

		<h2>Solicitud de Compra No. <b><?php echo $model->id; ?></b></h2> 

</div>


<div class="well" id="info-orden-id">
	<h2>I. Datos Generales de la Orden</h2><br />
	
	<div style="overflow:hidden;">
		<div class="orden_row_view">
			<p><b>Usuario Solicitante: </b><?php echo $model->idUsuario->nombre_completo; ?></p>
		</div>
		<div class="orden_row_view">
			<p><b>Nombre: </b><?php echo $model->nombre_compra; ?></p>
		</div>
		<div class="orden_row_view">
			<p><b>Tipo: </b><?php echo $model->tipoCompra->nombre; ?></p>
		</div>
		<div class="orden_row_view">
			<p><b>Justificación de la solicitud: </b><?php echo $model->resumen_breve; ?></p>
		</div>
		<div class="orden_row_view">
			<p><b>Vicepresidencia: </b><?php echo ($model->id_vicepresidencia == null)?'':$model->idVice->nombre; ?></p>
		</div>
		<div class="orden_row_view">
			<p><b>Vicepresidente: </b><?php echo ($model->id_vicepresidente == null)?'':$model->idVicepte->nombre_completo; ?></p>
		</div>
		<div class="orden_row_view">
			<p><b>Gerencia: </b><?php echo ($model->id_gerencia == null)?'':$model->idGerencia->nombre; ?></p>
		</div>
		<div class="orden_row_view">
			<p><b>Gerente: </b><?php echo ($model->id_gerente == null)?'':$model->idGerente->nombre_completo; ?></p>
		</div>
		<div class="orden_row_view">
			<p><b>Jefatura: </b><?php echo ($model->id_jefatura == null)?'':$model->idJefatura->nombre; ?></p>
		</div>	
		<div class="orden_row_view">
			<p><b>Jefe: </b><?php echo ($model->id_jefe == null)?'':$model->idJefe->nombre_completo; ?></p>
		</div>
		<div class="orden_row_view">
			<p><b>Tipo de Negociación: </b><?php echo Orden::model()->tiposNegociacionById($model->negociacion_directa); ?></p>
		</div>
	</div>
</div>
