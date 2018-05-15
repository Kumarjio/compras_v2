<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
		'id'=>'documento-proveedor-form',
		'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); ?>
<table class="detail-view table table-striped table-condensed" ><tbody>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('nombre_contrato')); ?></th>
<td> <?php echo CHtml::encode($data->nombre_contrato); ?></td>
</tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('proveedor')); ?></th>
<td> <?php echo CHtml::encode($data->proveedor); ?></td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('fecha_inicio')); ?></th>
<td><?php echo CHtml::encode($data->fecha_inicio); ?></td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('fecha_fin')); ?></th>
<td><div id="fecha_fin_vista">
	<? if($data->fecha_fin > 0)
		echo CHtml::encode($data->fecha_fin);
	if($data->fecha_fin_ind  )
		echo 'Indefinido'; ?>
	</div>
</td>
</tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('objeto')); ?></th>
<td style="text-align:justify"><?php echo CHtml::encode($data->objeto); ?></td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('fecha_firma')); ?></th>
<td><?php echo CHtml::encode($data->fecha_firma); ?></td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('valor')); ?></th>
<td><div id="valor_vista">
	<? if($data->valor > 0)
		echo CHtml::encode( ($data->valor/intval($data->valor))==1 ? number_format($data->valor) : round($data->valor*100)/100 )." ( ".$data->moneda." )";?>
	</div>
</td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('cuerpo_contrato')); ?>
</th><td><?php echo CHtml::encode($data->cuerpo_contrato); ?>
</td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('proroga_automatica')); ?>
</th><td>
	<div id="proroga_vista">
		<?php echo DocumentoProrroga::getNombreProrroga($data->proroga_automatica); ?>
	</div>
</td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('tiempo_proroga')); ?>
</th><td>
	<div id="tiempo_pro_vista">
		<?php echo CHtml::encode($data->tiempo_proroga); ?>
	</div>
</td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('tiempo_preaviso')); ?></th>
<td><div id="tiempo_pre_vista">
		<?php echo CHtml::encode($data->tiempo_preaviso); ?>
	</div>
</td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('responsable_proveedor')); ?></th>
<td><?php echo CHtml::encode($data->responsable_proveedor); ?></td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('polizas')); ?></th>
<td><?php echo CHtml::encode($data->polizas); ?></td></tr>
<tr ><th><?php echo CHtml::encode($data->getAttributeLabel('anexos')); ?></th>
<td><?php echo CHtml::encode($data->anexos); ?></td></tr>
</td></tr>
<tr><th>Fecha Firma
</th><td><? echo CHtml::encode($model->fecha_firma); ?>
</td></tr>
<tr><th>Descripción de la Modificación
</th><td><? echo $form->textArea($model,'observacion_otrosi',array('class'=>'span5', 'readonly'=> true)); ?>
</td></tr>
<tr><th colspan="2" align="center">Proveedores Relacionados
</th></tr>
<tr><td colspan="2">
<?php 
    $this->widget('bootstrap.widgets.BootGridView',array(
      	'id'=>'proveedores-grid-otrosi',
      	'dataProvider'=> DocumentoProveedorAdicional::model()->search($model->id_docpro),
      	'type'=>'striped bordered condensed',
        'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
      	'columns'=>array(
        'proveedor',
        array(
            'header'=>'Razón Social',
            'value'=>'$data->idProveedor->razon_social'
        )
      ),
    )); ?>

</td></tr>
</tbody></table>
<?php $this->endWidget(); ?>