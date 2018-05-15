<?php echo $this->renderPartial('/orden/orden_ro', array('model' => $orden), true); ?>
<div class="well">
	<h2>II. Productos</h2><br />
	<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
		'id'=>'producto-orden-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<?php echo $form->errorSummary($orden); ?>
	
<?php
	$solicitudes = OrdenSolicitud::model()->findAllByAttributes(array('id_orden' => $orden->id), array('order' => 'id ASC'));
	if(count($solicitudes) > 0){
		foreach($solicitudes as $s){
			$model_orden_solicitud_costos=new OrdenSolicitudCostos('search');
			$model_orden_solicitud_costos->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudCostos'])){
				$model_orden_solicitud_costos->attributes=$_GET['OrdenSolicitudCostos'];
			}
			
			$model_orden_solicitud_proveedor=new OrdenSolicitudProveedor('search');
			$model_orden_solicitud_proveedor->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudProveedor'])){
				$model_orden_solicitud_proveedor->attributes=$_GET['OrdenSolicitudProveedor'];
			}
			
			$model_orden_solicitud_direccion=new OrdenSolicitudDireccion('search');
			$model_orden_solicitud_direccion->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudDireccion'])){
				$model_orden_solicitud_direccion->attributes=$_GET['OrdenSolicitudDireccion'];
			}
			
			$arch=new AdjuntosOrden('search');
			$arch->unsetAttributes();  // clear any default values
			if(isset($_GET['AdjuntosOrden'])){
				$arch->attributes=$_GET['AdjuntosOrden'];
			}
			
			echo $this->renderPartial('/orden/_orden_solicitud_readonly', array('model' => $s, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'divid' => $s->id, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'cotizacion_model' => $cotizacion_model, 'archivos' => $arch), true);
		}
	}

?>
</div>

<hr />

<div class="well">
	<b>Observaciones</b>
	<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'observaciones-wfs-grid',
			'dataProvider'=>$observaciones->search("Orden", $_GET['orden']),
			'type'=>'striped bordered condensed',
			'filter'=>$observaciones,
			'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
			'columns'=>array(
				array(
					'header'=>'Usuario',
					'name' => 'usuario',
					'value' => '$data->idUsuario->nombre_completo'
				),
				array(
				    'header'=>'Est. anterior',
				    'name'=>'estado_anterior',
				    'filter'=>SWHelper::allStatuslistData($orden),
				    'value'=>'Orden::model()->labalEstado($data->estado_anterior)'
				),
				array(
				    'header'=>'Est. nuevo',
				    'name'=>'estado_nuevo',
				    'filter'=>SWHelper::allStatuslistData($orden),
				    'value'=>'Orden::model()->labalEstado($data->estado_nuevo)'
				),
				
				'observacion',
				'fecha',
			),
		)); ?>
</div>
<?php $orden_actual = Orden::model()->findByPk($orden->id); ?>
<?php if($orden_actual->paso_wf == 'swOrden/aprobar_por_comite' or $orden_actual->paso_wf == 'swOrden/aprobado_por_comite' or $orden_actual->paso_wf == 'swOrden/aprobar_por_presidencia' or $orden_actual->paso_wf == 'swOrden/aprobado_por_presidencia') { ?>
	<div class="well">		
		<b>Asistentes</b><br /><br /><br />
		<?php 
		if($orden_actual->paso_wf == 'swOrden/aprobar_por_comite' or $orden_actual->paso_wf == 'swOrden/aprobar_por_presidencia') {
			$this->widget('bootstrap.widgets.BootButton', array(
				'type'=>'warning',
				'label'=>'Seleccionar Empleados',
				'htmlOptions' => array(
					'onclick'=> '$(\'#AsistentesModal\').modal()',
					'style' => 'margin-bottom:15px;'
				)
			)); 
		}
		?>
		
		<?php 
		if($orden_actual->paso_wf == 'swOrden/aprobar_por_comite') {
			$this->widget('bootstrap.widgets.BootButton', array(
				'type'=>'inverse',
				'label'=>'Cargar Últimos Asistentes',
				'htmlOptions' => array(
					'onclick'=> 'jQuery.ajax({\'url\':\'/index.php/orden/cargarUltimosAsistentesComite/id/'.$orden->id.'/comite/Compras\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
						if(data.status == \'success\'){
							$(\'#asistentes-grid\').yiiGridView.update(\'asistentes-grid\');
						}
					},\'cache\':false});return false;',
					'style' => 'margin-bottom:15px;'
				)
			)); 
		}
		?>
		<?php 
		if($orden_actual->paso_wf == 'swOrden/aprobar_por_presidencia') {
			$this->widget('bootstrap.widgets.BootButton', array(
				'type'=>'inverse',
				'label'=>'Cargar Últimos Asistentes',
				'htmlOptions' => array(
					'onclick'=> 'jQuery.ajax({\'url\':\'/index.php/orden/cargarUltimosAsistentesComite/id/'.$orden->id.'/comite/Presidencia\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
						if(data.status == \'success\'){
							$(\'#asistentes-grid\').yiiGridView.update(\'asistentes-grid\');
						}
					},\'cache\':false});return false;',
					'style' => 'margin-bottom:15px;'
				)
			)); 
		}
		?>
		
		<?php $this->widget('bootstrap.widgets.BootGridView',array( 
		    'id'=>'asistentes-grid', 
		    'dataProvider'=>$asistentes_model->search($orden->id), 
		    'type'=>'striped bordered condensed', 
			'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
		    'columns'=>array( 
				array('name'=>'empleado.nombre', 'value'=>'$data->empleado->nombre_completo', 'header'=>'Nombre'),
				array('name'=>'empleado.tipo_documento', 'value'=>'$data->empleado->tipo_documento', 'header'=>'Tipo Documento'),
				array('name'=>'empleado.numero_identificacion', 'value'=>'$data->empleado->numero_identificacion', 'header'=>'Numero de Identificacion'),
		        array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{delete}',
					    'buttons'=>array
					    (
					        'delete' => array
					        (
					            'url'=>'Yii::app()->createUrl("asistenteComite/delete", array("id"=>$data->id))',
								'options'=>array('class'=>'delete'),
								'visible' => '"'.$orden->paso_wf.'" == "swOrden/aprobar_por_comite" or "'.$orden->paso_wf.'" == "swOrden/aprobar_por_presidencia"',
					        ),
					    ),
				),
		    ), 
		)); ?>
		
	</div>
<?php } ?>



<div class="alert alert-block alert-warning fade in">		
	<?php echo $form->textAreaRow($orden,'observacion', array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
</div>
<?php if($orden_actual->paso_wf == 'swOrden/gerente_compra'){ ?>
<div class="alert alert-block alert-warning fade in">		
	<?php 
	$atribucion = Atribucion::model()->findByAttributes(array('id_empleado' => Yii::app()->user->id_empleado));
	echo  "<p>Atribuciónes Utilizadas: ".str_replace(".000","","$".number_format($atribucion->atribucion_disponible, 3))."</p>"; 
	echo "<p>Costo total de la orden: ".str_replace(".000","","$".number_format($orden->costo_total(), 3))."</p>";
	?>
</div>
<?php } ?>

<div class="alert alert-block alert-warning fade in">

      <?php echo $form->dropDownListRow($orden,'paso_wf',SWHelper::nextStatuslistData($orden),array('class'=>'span5')); ?>
		<a class="badge badge-info" rel="popover" data-content="El paso marcado con '*' es el actual. Puede dejar este paso si quiere continuar mas adelante con el diligenciamiento de este formulario" style="cursor:pointer;" data-original-title="Ayuda">?</a>
</div>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.BootButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=> 'Enviar',
		'htmlOptions' => array('onClick' => "$(\".guardarSolicitud\").click();if($(\"#solicitudes-container .alert-error\").length != 0 ){ showProductsWithErrors(); setTimeout(function(){alert('Error en los productos. Verifique para continuar.'); updateProductNumber();}, 500); return false;	}else{ me_puedo_ir = true }"
		)
	)); ?>
</div>

<?php $this->endWidget(); ?>




<?php 
if($orden_actual->paso_wf == 'swOrden/aprobar_por_comite' or $orden_actual->paso_wf == 'swOrden/aprobar_por_presidencia') {
$this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'AsistentesModal')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>Seleccionar empleados</h3>
</div>
 
<div class="modal-body">
    <p>Puede buscar un empelado en la lista utilizando los diferentes filtros.</p>
</div>
<div style="margin:10px;">
<script type="text/javascript">

function setEmpleado(event){
	//var element_clicked = $("#"+event.target.id);

}
</script>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'empleados-grid',
	'type'=>'striped bordered condensed',
    'dataProvider'=>$empleados_model->search_2($orden->id),
	'filter'=>$empleados_model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'pager'=>array(
	        'class'=>'bootstrap.widgets.BootPager',
	        'displayFirstAndLast'=>true,
	),
	'columns'=>array(
		array('name'=>'nombre_completo', 'header'=>'Nombre Completo'),
		array('name'=>'tipo_documento', 'header'=>'Tipo Documento', 'htmlOptions'=>array('width'=>'100px')),
        array('name'=>'numero_identificacion', 'header'=>'Numero Identificación', 'htmlOptions'=>array('width'=>'140px')),
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{select}',
				'buttons'=>array
				    (
				        'select' => array
				        (
							'url' => '"/index.php/productoOrden/agregarAsistente/id_orden/'.$orden->id.'/id_asistente/".$data->id',
							'label' => "<i class='icon-ok'></i>",
							'options'=>array('title' => 'seleccionar este empleado', 'class' => 'agregar-asistente'),
				        ),
				    ),
		),
	),
)); ?>
 </div>
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Cerrar',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => "$(\".guardarSolicitud\").click();"),
    )); ?>
</div>
 
<?php $this->endWidget();
} ?>