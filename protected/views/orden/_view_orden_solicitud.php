<?php
$p = ProductoOrden::model()->findByAttributes(array("orden_solicitud" => $model->id));
$rechazado="";
if($p->rechazado)
  $rechazado = "(Rechazado)";

?>
<h2><?php echo $model->nombre. " " . $rechazado; ?></h2>
<div class="well" style="background-color:#F2F2F2;" id="orden-solicitud-<?php echo $model->id; ?>">
	<div style="overflow:hidden;">
		<div class="orden_solicitud_row_view">
			<p><b>Cantidad: </b><?php echo $model->cantidad; ?></p>
		</div>
		<div class="orden_solicitud_row_view">
			<p><b>Fecha de entrega: </b><?php echo $model->fecha_entrega; ?></p>
		</div>
		<!-- 
		<div class="orden_solicitud_row_view">
			<p><b>NIT: </b><?php //echo $model->nit; ?></p>
		</div>
		<div class="orden_solicitud_row_view">
			<p><b>Proveedor: </b><?php //echo $model->proveedor; ?></p>
		</div>
		<div class="orden_solicitud_row_view">
			<p><b>Valor unitario: </b><?php //echo $model->valor_unitario; ?></p>
		</div>
		<div class="orden_solicitud_row_view">
			<p><b>Total Compra: </b><?php //echo $model->total_compra; ?></p>
		</div>
		-->
		<div class="orden_solicitud_row_view">
			<p><b>Detalle: </b><?php echo $model->detalle; ?></p>
		</div>
		
		<?php if($model->requiere_acuerdo_servicios == 1){  ?>

		<div class="orden_solicitud_row_view">
			<p><b>Acuerdo de nivel de servicios: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_acuerdo_confidencialidad == 1){ ?>

		<div class="orden_solicitud_row_view">
            <p><b>Acuerdo de Confidencialidad: </b>Si</p>
        </div>

        <?php } ?>

        <?php if($model->requiere_contrato == 1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Contrato: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_polizas_cumplimiento == 1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Póliza de Cumplimiento: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_seriedad_oferta == 1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Seriedad de la Oferta: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_buen_manejo_anticipo == 1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Buen Manejo Anticipo: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_calidad_suministro == 1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Calidad de Suministro: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_calidad_correcto_funcionamiento == 1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Calidad y Correcto Funcionamiento: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_pago_salario_prestaciones == 1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Pago de Salarios y Prestaciones: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_estabilidad_oferta == 1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Estabilidad de la Obra: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_calidad_obra == 1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Calidad de la Obra: </b>Si</p>
		</div>

        <?php } ?>

        <?php if($model->requiere_responsabilidad_civil_extracontractual ==  1){ ?>

		<div class="orden_solicitud_row_view">
			<p><b>Responsabilidad Civil Extracontractual: </b>Si</p>
		</div>


        <?php } ?>


	</div>
	
	<?php
		$q = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $model->id));
		if(count($q) > 0){
			?>
				<table class="items table table-striped table-bordered table-condensed" style="margin-top:15px;">
					<tr>
						<th><center>Cantidad</center></th>
						<th><center>Responsable</center></th>
						<th><center>Direccion</center></th>
						<th><center>Ciudad</center></th>
						<th><center>Departamento</center></th>
						<th><center>Telefono</center></th>
					</tr>
					<?php
						foreach($q as $p){
							echo '<tr>';
							echo '<td>'.$p->cantidad.'</td>';
							echo '<td>'.$p->responsable.'</td>';
							echo '<td>'.$p->direccion_entrega.'</td>';
							echo '<td>'.$p->ciudad.'</td>';
							echo '<td>'.$p->departamento.'</td>';
							echo '<td>'.$p->telefono.'</td>';
							echo '</tr>';
						}
					?>
				</table>
			<?php
		}
	?>
	
	<?php
		$q = OrdenSolicitudProveedor::model()->findAllByAttributes(array('id_orden_solicitud' => $model->id));
		if(count($q) > 0){
			?>
				<table class="items table table-striped table-bordered table-condensed" style="margin-top:15px;">
					<tr>
						<th><center>NIT</center></th>
						<th><center>Proveedor</center></th>
						<th><center>Cantidad</center></th>
						<th><center>Valor Unitario</center></th>
						<th><center>Moneda</center></th>
						<th><center>Total Compra</center></th>
					</tr>
					<?php
						foreach($q as $p){
							echo '<tr>';
							echo '<td>'.$p->nit.'</td>';
							echo '<td>'.$p->proveedor.'</td>';
							echo '<td>'.$model->cantidad.'</td>';
							echo '<td>'.Orden::formatoMoneda($p->valor_unitario).'</td>';
							echo '<td>'.$p->moneda.'</td>';
							echo '<td>'.Orden::formatoMoneda($p->total_compra).'</td>';
							echo '</tr>';
						}
					?>
				</table>
			<?php
		}
	?>
	
	<table class="items table table-striped table-bordered table-condensed" style="margin-top:15px;">
		<tr>
			<th><center>% o #</center></th>
			<th><center>Proporción</center></th>
			<th><center>Código</center></th>
			<th><center>Centro costos</center></th>
			<th><center>Cuenta contable</center></th>
			<th><center>Presupuestado?</center></th>
			<th><center>Valor</center></th>
			<th><center>Mes</center></th>
		</tr>
		<?php
			foreach($model_orden_solicitud_costos as $s){
				echo '<tr>';
				echo '<td>'.$s->porcentaje_o_cantidad.'</td>';
				echo '<td>'.$s->numero.'</td>';
				echo '<td>'.$s->idCentroCostos->codigo.'</td>';
				echo '<td>'.$s->idCentroCostos->nombre.'</td>';
				echo '<td>'.$s->idCuentaContable->nombre.'</td>';
				echo '<td>'.$s->presupuestado.'</td>';
				echo '<td>'.(Orden::formatoMoneda($s->valor_presupuestado)).'</td>';
				echo '<td>'.$s->mes_presupuestado.'</td>';
				echo '</tr>';
			}
		?>
	</table>

	<?php
		$q = AdjuntosOrden::model()->findAllByAttributes(array('orden' => $model->id));
		if(count($q) > 0){
			?>
				<table class="items table table-striped table-bordered table-condensed" style="margin-top:15px;">
					<tr>
						<th><center>Nombre archivo</center></th>
						<th><center>Accion</center></th>
					</tr>
					<?php
						foreach($q as $p){
							echo '<tr>';
							echo '<td>'.$p->nombre.'</td>';
							echo '<td>'.CHtml::link("Descargar", $this->createUrl("adjuntosOrden/download", array('id' => $p->id))).'</td>';
							echo '</tr>';
						}
					?>
				</table>
			<?php
		}
	?>

</div>
