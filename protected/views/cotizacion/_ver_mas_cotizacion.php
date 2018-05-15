<p><strong>Descripción: </strong><?php echo $model->descripcion; ?></p>
<p><strong>Valor Unitario: </strong><?php echo str_replace(".000","","$".number_format($model->valor_unitario, 3)); ?></p>
<p><strong>Total Compra: </strong><?php echo str_replace(".000","","$".number_format($model->total_compra, 3)); ?></p>
<?php echo ($model->moneda == "Peso")?"":"<p><strong>TRM: </strong>".str_replace(".000","","$".number_format($model->trm, 3))."</p>"; ?>
<p><strong>Total Compra Pesos: </strong><?php echo str_replace(".000","","$".number_format($model->total_compra_pesos, 3)); ?></p>
<p><strong>Ahorro Potencial: </strong><?php echo number_format((Cotizacion::ahorro($model->id, $model->productoOrden->id)*100),2)."%"; ?></p>
<p><strong>Total por regalos: </strong><?php echo "$".number_format($regalos); ?></p>
<p><strong>Ahorro Potencial Pesos: </strong><?php echo str_replace(".000","","$".number_format((Cotizacion::ahorro($model->id, $model->productoOrden->id)*$model->total_compra_pesos), 0)); ?></p>
<p><strong>Total Ahorro en Pesos: </strong><?php echo str_replace(".000","","$".number_format((Cotizacion::ahorro($model->id, $model->productoOrden->id)*$model->total_compra_pesos) + $regalos, 0)); ?></p>
<p><strong>Descuento por Pronto Pago: </strong><?php echo $model->descuento_prontopago; ?></p>
<p><strong>Porcentaje del Descuento: </strong><?php echo str_replace(".000","",number_format($model->porcentaje_descuento,2))."%"; ?></p>
<p><strong>Dias Para el Pago de la Factura: </strong><?php echo $model->dias_pago_factura; ?></p>

