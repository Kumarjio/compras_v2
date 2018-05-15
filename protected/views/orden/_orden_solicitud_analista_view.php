<?php
if (Yii::app()->request->isAjaxRequest) {
    $cs = Yii::app()->clientScript;
    $cs->scriptMap['jquery.js'] = false;
    $cs->scriptMap['jquery.min.js'] = false;
}

$this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Seleccionar Productos',
        'context' => 'primary',
        'htmlOptions' => array(
            'onClick' => '$("#modalNuevoProducto").modal("hide");$("#modalProductos").modal("show");'
        ),
    )
);

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
  	'id'=>'orden-marco-compras-form',
  	'enableAjaxValidation'=>false,
	'htmlOptions' => array('onSubmit' => 'return false')
)); ?>

<?php //echo $form->errorSummary($model, null, null, array('class' => 'alert alert-block alert-error')); ?>
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-md-12">
    	<?php echo $form->hiddenField($model, 'id_producto');?>
        <?php echo $form->textFieldGroup($model,'nombre_producto',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span6','maxlength'=>255, 'campo'=>'nombre','id_sol_direc'=>$model->id, 'readonly'=>'readonly', 'value'=>$nombre_p))));//'onBlur' => 'actualizarNombre("'.$model->id.'")'?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php echo $form->textFieldGroup($model,'nombre',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span6 autoGuardar','maxlength'=>255, 'campo'=>'nombre','id_sol_direc'=>$model->id, 'readonly'=>'readonly'))));//'onBlur' => 'actualizarNombre("'.$model->id.'")'?>
    </div>
    <div class="col-md-6">
        <?php echo $form->textFieldGroup($model,'cantidad',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span6 autoGuardar','maxlength'=>255, 'campo'=>'cantidad','id_sol_direc'=>$model->id, 'readonly'=>'readonly')))); //'onkeypress' => "return isNumberKey(event)", 'onBlur' => 'actualizarNombre("'.$model->id.'")' ?>
    </div>
</div>


<?php 
if($model->isNewRecord){
	echo '<input name="OrdenSolicitud[id]" id="OrdenSolicitud_id" type="hidden" value="-1">';
}else{
 	 echo $form->hiddenField($model,'id');
} 
echo $form->hiddenField($model,'id_orden');
?>

<div class="row">
    <div class="col-md-6">

<?php
echo $form->textFieldGroup($model,'fecha_maxima_aprobacion',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span6 autoGuardar','maxlength'=>255, 'campo'=>'cantidad','id_sol_direc'=>$model->id, 'readonly'=>'readonly')))); 
?>


    </div>
    <div class="col-md-6">

<?php 
echo $form->textFieldGroup($model,'fecha_entrega',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span6 autoGuardar','maxlength'=>255, 'campo'=>'cantidad','id_sol_direc'=>$model->id, 'readonly'=>'readonly')))); 
 ?>
    </div>
</div>

<?php echo $form->textAreaGroup($model,'detalle', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8','readonly'=>'readonly')))); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_acuerdo_servicios',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;',
				'readonly'=>'readonly'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_acuerdo_confidencialidad',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_contrato',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>


<?php 
$poliza_bool = false;
if($model->requiere_polizas_cumplimiento == 1 or $model->requiere_seriedad_oferta == 1 or $model->requiere_buen_manejo_anticipo == 1 or $model->requiere_calidad_suministro == 1 or $model->requiere_calidad_correcto_funcionamiento == 1 or $model->requiere_pago_salario_prestaciones == 1 or $model->requiere_estabilidad_oferta == 1 or $model->requiere_calidad_obra == 1 or $model->requiere_responsabilidad_civil_extracontractual == 1){
	$poliza_bool = true;
}
$model->requiere_polizas = $poliza_bool;

echo $form->checkboxGroup(
	$model,
	'requiere_polizas',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;',
				'onChange' => 'if(this.checked){$("#polizas").slideDown();}else{if(confirm("Esta seguro que no desea incluir ninguna póliza?")){ $("#polizas input").attr("checked", false); $( "#polizas").slideUp();}else{this.checked = true;}}'
			)
		),
	)
); ?>


<div id="polizas" style="<?php if(!$poliza_bool){ ?>display:none; <?php } ?> margin-left:15px;">

<?php echo $form->checkboxGroup(
	$model,
	'requiere_polizas_cumplimiento',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_seriedad_oferta',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_buen_manejo_anticipo',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_calidad_suministro',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_calidad_correcto_funcionamiento',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_pago_salario_prestaciones',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_estabilidad_oferta',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_calidad_obra',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>

<?php echo $form->checkboxGroup(
	$model,
	'requiere_responsabilidad_civil_extracontractual',
	array(
		'widgetOptions' => array(
			'htmlOptions' => array(
				'class' => 'icheckbox_flat-green',
				'style' => 'position: relative;'
			)
		),
	)
); ?>	
</div>

<?php 
if(!$model->isNewRecord){
	echo '<div class="well">';
	echo '<div>';
	$this->widget('booster.widgets.TbGridView',array( 
				'id'=>'orden-solicitud-direccion-grid', 
				'dataProvider'=>$model_orden_solicitud_direccion->search($model->id), 
				//'filter'=>$model_orden_solicitud_costos,
				'afterAjaxUpdate'=>'function(id, data){var obj=JSON.parse(data);actualizarModalProductos('.$model->id.');}',
				'type'=>'striped bordered condensed',
				'columns'=>array( 
					array('header' => 'Cantidad', 'value' => '$data->cantidad'),
					array('header' => 'Responsable', 'value' => '$data->responsable'),
					array('header' => 'Direccion de Entrega', 'value' => '$data->direccion_entrega'),
					array('header' => 'Ciudad', 'value' => '$data->ciudad'),
					array('header' => 'Departamento', 'value' => '$data->departamento'),
					array('header' => 'Telefono', 'value' => '$data->telefono'),
					/*array( 
						'htmlOptions' => array('nowrap'=>'nowrap', 'class'=>'grid-direcc'),
						'class'=>'booster.widgets.TbButtonColumn', 
						'template' => '{update} {eliminar} ',
						'buttons'=>array(
							'eliminar' => array(
								'label'=>'<i class="glyphicon glyphicon-trash"></i>',
								'url'=>'Yii::app()->createUrl("orden/deleteDireccion", array("id"=>$data->id))',
								'options'=>array('class'=>'delete'),
							),
						),
                		'updateButtonUrl'=>'CController::createUrl("/orden/updateDireccion", array("id_orden_solicitud"=>$data->id_orden_solicitud, "id" => $data->id))',
					), */
				), 
				)); 
				echo '</div>';
				echo '</div>';
			}
?>
	
				<?php 
				if(!$model->isNewRecord){
					echo '<div class="well">';
					echo '<div>';
					$this->widget('booster.widgets.TbGridView',array( 
								'id'=>'orden-solicitud-proveedor-grid', 
								'dataProvider'=>$model_orden_solicitud_proveedor->search($model->id), 
								//'filter'=>$model_orden_solicitud_costos,
								'type'=>'striped bordered condensed',
								'columns'=>array( 
									array('header' => 'NIT', 'value' => '$data->nit'),
									array('header' => 'Proveedor', 'value' => '$data->proveedor'),
									array(
										'header' => 'Valor Unitario',
										'value' => 'Orden::formatoMoneda($data->valor_unitario)'
									),
									array('header' => 'Moneda', 'value' => '$data->moneda'),
									array(
										'header' => 'Total Compra',
										'value' => 'Orden::formatoMoneda($data->total_compra)' 
									),
									/*array( 
										'htmlOptions' => array('nowrap'=>'nowrap', 'class'=>'grid-proveed'),
										'class'=>'booster.widgets.TbButtonColumn', 
										'template' => '{subir} {update} {eliminar}',
										'buttons'=>array(
											/*'subir' => array(
												'url' => '"/index.php/orden/subir/orden_solicitud_proveedor/".$data->id',
												'icon' => 'file',
												'label' => 'Ver/Adjuntar Archivos',
												'options' => array(
													'class' => 'subir-archivos'
												)	
											),*/
											/*'eliminar' => array(
												'label'=>'<i class="glyphicon glyphicon-trash"></i>',
												'url'=>'Yii::app()->createUrl("orden/deleteProveedor", array("id"=>$data->id))',
												'options'=>array('class'=>'delete'),
											),
										),
                						'updateButtonUrl'=>'CController::createUrl("/orden/updateProveedor", array("id_orden_solicitud"=>$data->id_orden_solicitud, "id" => $data->id))',
									), */
								), 
								)); 
								echo '</div>';
								echo '</div>';
							}
				?>
				
				<?php 
				if(!$model->isNewRecord){
					echo '<div class="well">';
					echo '<div style="overflow:scroll;">';
					$this->widget('booster.widgets.TbGridView',array( 
								'id'=>'orden-solicitud-costos-grid-'.$model->id, 
								'dataProvider'=>$model_orden_solicitud_costos->search($model->id), 
								//'filter'=>$model_orden_solicitud_costos,
								'type'=>'striped bordered condensed',
								//'htmlOptions' => array('style' => 'width:758px;'),
								'columns'=>array( 
									//'id',
									//'id_orden_solicitud',
									array('header' => 'Cantidad o Porcentaje', 'value' => '$data->porcentaje_o_cantidad'),
									//'porcentaje_o_cantidad',
									array('header' => 'Cantidad o Porcentaje', 'value' => '$data->numero'),
									//'numero',
									array('header' => 'Centro de Costos', 'value' => '$data->idCentroCostos->nombre'),
									array('header' => 'Cuenta Contable', 'value' => '$data->idCuentaContable->nombre'),
									//'id_centro_costos',
									//'id_cuenta_contable',
									array('header' => 'Presupuestado o Estimado?', 'value' => '$data->presupuestado'),
									array('header' => 'Valor', 'value' => '(Orden::formatoMoneda($data->valor_presupuestado))'),
									//'presupuestado',
									//'valor_presupuestado',
									array(
										'value' => '$data->mes_presupuestado',
										'header' => 'Mes'
									),
									//'paso_wf',

									/*array( 
										'htmlOptions' => array('nowrap'=>'nowrap', 'class'=>'grid-costos'),
										'class'=>'booster.widgets.TbButtonColumn', 
										'template' => '{update} {eliminar}',
										'buttons'=>array(
											'eliminar' => array(
												'label'=>'<i class="glyphicon glyphicon-trash"></i>',
												'url'=>'Yii::app()->createUrl("orden/deleteCostos", array("id"=>$data->id))',
												'options'=>array('class'=>'delete'),
											),
										),
                						'updateButtonUrl'=>'CController::createUrl("/orden/updateCostos", array("id_orden_solicitud"=>$data->id_orden_solicitud, "id" => $data->id))',
									), */
								), 
								)); 
								echo '</div>';
								echo '</div>';
							}


				?>
				  <div class="well">
					<b>Archivos Adjuntos</b><br/><br/>
				  	<?php $this->widget('bootstrap.widgets.BootGridView',array(
					'id'=>'adjuntos-orden-grid',
					'dataProvider'=>$archivos->search($model->id),
				    //'ajaxUrl' => $this->createUrl("/adjuntosCotizacion/admin"),
					'type'=>'striped bordered condensed',
					'filter'=>$archivos,
					'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
					'columns'=>array(
				        'nombre',
						'tipi',
						array(
							'class'=>'bootstrap.widgets.BootButtonColumn',
				            'template' => '{download}{delete}',
				            'deleteButtonUrl'=>'Yii::app()->createUrl("/adjuntosOrden/delete", array("id" =>  $data["id"], "ajax" => 1))',
				            'buttons' => array(
				                'download' => array(
				                  'icon'=>'arrow-down',
				                  'url'=>'Yii::app()->createUrl("/adjuntosOrden/download", array("id" =>  $data["id"]))',
				                  'options' => array(
				                      'target' => '_blank'
				                   )
				                ),
				                'delete' => array(
				                  'visible' => 'true',
				                 )
				            )
						),
					),
					)); ?>

				  </div>
				  <div class="form-actions"> 
					<?php $this->widget('bootstrap.widgets.BootButton', array( 
						'buttonType'=>'submit', 
						'htmlOptions'=>array(
							'id'=>'btn_guardar_solicitud',
						),
						'type'=>'primary', 
						'label'=>$model->isNewRecord ? 'Crear' : 'Editar', 
						)); ?>
				</div> 
				<div style="display: none;">
				<?php
		            $this->widget('booster.widgets.TbGridView',array(
		                              'id'=>'orden-solicitud-grid',
		                              'dataProvider'=>Producto::model()->search(),
		                              //'template' => "{items}",
		                              //'filter' => $productos,
		                              'type' => 'striped bordered condensed',
		                              'responsiveTable' => true,
		                              'columns'=>array(
		                                  'nombre',  
		                              ),
		                            ));
		            $this->widget('booster.widgets.TbGridView',array(
		                              'id'=>'productos-om-grid',
		                              'dataProvider'=>Producto::model()->search(),
		                              //'template' => "{items}",
		                              //'filter' => $productos,
		                              'type' => 'striped bordered condensed',
		                              'responsiveTable' => true,
		                              'columns'=>array(
		                                  'nombre',  
		                              ),
		                            ));
		          ?>
		      </div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
	$("#productos-om-grid").yiiGridView.update("productos-om-grid");
	
</script>