<table class="detail-view table table-striped table-condensed" ><tbody>
<tr class="odd"><th><?php echo CHtml::encode($data->getAttributeLabel('nombre_contrato')); ?></th>
<td> <?php echo CHtml::encode($data->nombre_contrato); ?></td></tr>
<tr class="even"><th><?php echo CHtml::encode($data->getAttributeLabel('oferta_mercantil')); ?></th>
<td><?php echo CHtml::encode($data->oferta_mercantil)==1 ? 'Si' : 'No' ?></td></tr>
<tr class="odd"><th><?php echo CHtml::encode($data->getAttributeLabel('proveedor')); ?></th>
<td> <?php echo CHtml::encode($data->proveedor); ?></td></tr>
<tr class="odd"><th><?php echo CHtml::encode($data->getAttributeLabel('fecha_inicio')); ?></th>
<td><?php echo CHtml::encode($data->fecha_inicio); ?></td></tr>
<tr class="even"><th><?php echo CHtml::encode($data->getAttributeLabel('fecha_fin')); ?></th>
<td><?php echo CHtml::encode($data->fecha_fin); ?></td></tr>
<tr class="odd"><th><?php echo CHtml::encode($data->getAttributeLabel('objeto')); ?></th>
<td style="text-align:justify"><?php echo CHtml::encode($data->objeto); ?></td></tr>
<tr class="even"><th><?php echo CHtml::encode($data->getAttributeLabel('valor')); ?></th>
<td><?php echo CHtml::encode($data->valor); ?></td></tr>
<tr class="odd"><th><?php echo CHtml::encode($data->getAttributeLabel('fecha_firma')); ?></th>
<td><?php echo CHtml::encode($data->fecha_firma); ?></td></tr>
<tr class="even"><th><?php echo CHtml::encode($data->getAttributeLabel('tiempo_preaviso')); ?></th>
<td><?php echo CHtml::encode($data->tiempo_preaviso); ?></td></tr>
<tr class="odd"><th><?php echo CHtml::encode($data->getAttributeLabel('cuerpo_contrato')); ?></th>
<td><?php echo CHtml::encode($data->cuerpo_contrato); ?></td></tr>
<tr class="even"><th><?php echo CHtml::encode($data->getAttributeLabel('proroga_automatica')); ?></th>
<td><?php echo CHtml::encode($data->proroga_automatica); ?></td></tr>
<tr class="odd"><th><?php echo CHtml::encode($data->getAttributeLabel('tiempo_proroga')); ?></th>
<td><?php echo CHtml::encode($data->tiempo_proroga); ?></td></tr>
<tr class="even"><th><?php echo CHtml::encode($data->getAttributeLabel('consecutivo_contrato')); ?></th>
<td><?php echo CHtml::encode($data->consecutivo_contrato); ?></td></tr> 
<tr class="odd"><th><?php echo CHtml::encode($data->getAttributeLabel('responsable_compras')); ?></th>
<td><?php echo CHtml::encode($data->responsable_compras); ?></td></tr>
<tr class="even"><th><?php echo CHtml::encode($data->getAttributeLabel('responsable_proveedor')); ?></th>
<td><?php echo CHtml::encode($data->responsable_proveedor); ?></td></tr>
<tr class="odd"><th><?php echo CHtml::encode($data->getAttributeLabel('polizas')); ?></th>
<td><?php echo CHtml::encode($data->polizas); ?></td></tr>
<tr class="even"><th><?php echo CHtml::encode($data->getAttributeLabel('anexos')); ?></th>
<td><?php echo CHtml::encode($data->anexos); ?></td></tr>

</tbody></table>