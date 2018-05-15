<table border='1' bordercolor="#CCC" cellpadding="4">
<tr>
<td colspan="2" bgcolor="#E9E9E9"><b><?php echo $model->nombre; ?></b></td>
</tr>
<tr>
<td bgcolor="#E9E9E9">Cantidad</td>
<td><?php echo $model->cantidad; ?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Fecha Entrega</td>
<td><?php echo $model->fecha_entrega; ?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Acuerdo Nivel de Servicios</td>
<td><?php echo ($model->requiere_acuerdo_servicios)?"Si":"No"; ?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Acuerdo de Confidencialidad</td>
<td><?php echo ($model->requiere_acuerdo_confidencialidad)?"Si":"No"; ?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Contrato</td>
<td><?php echo ($model->requiere_acuerdo_servicios)?"Si":"No"; ?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Detalle</td>
<td><?php echo $model->detalle; ?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9" colspan="2">Centro de Costos</td>
</tr>


<?php
foreach($model_orden_solicitud_costos as $s){
?>
<tr>
<td bgcolor="#E9E9E9">Porcent. o Cantidad</td>
<td><?php echo $s->porcentaje_o_cantidad ;?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Proporción</td>
<td><?php echo $s->numero ;?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Centro Costos</td>
<td><?php echo $s->idCentroCostos->nombre ;?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Cuenta Contable</td>
<td><?php echo $s->idCuentaContable->nombre ;?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Presupuestado?</td>
<td><?php echo $s->presupuestado ;?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Valor Presupuestado</td>
<td><?php echo $s->valor_presupuestado ;?></td>
</tr>

<tr>
<td bgcolor="#E9E9E9">Mes Presupuestado</td>
<td><?php echo $s->mes_presupuestado; ?></td>
</tr>

<tr>
<td colspan="2">&nbsp;</td>
</tr>

<?php } ?>

</table>
<br /><br />
