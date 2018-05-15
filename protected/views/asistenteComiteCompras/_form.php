<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModal')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>Seleccionar empleado</h3>
</div>
 
<div class="modal-body">
    <p>Puede buscar un empelado en la lista utilizando los diferentes filtros.</p>
</div>
<div style="margin:10px;">
<script type="text/javascript">
function setEmpleado(event){
	//var element_clicked = $("#"+event.target.id);
	var arr = event.href.split("#");
	var id_empleado = arr[1];
	var nombre_empleado = arr[2];
	var input_name = "input[name='AsistenteComiteCompras[id_empleado]']";
	$(input_name).val(id_empleado);
	var input_nombre = "input[name='AsistenteComiteCompras[id_empleado]_2']"; 
	$(input_nombre).val(nombre_empleado);
	$("#cerrar_modal").click();
}
</script>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'empleado-grid',
	'type'=>'striped bordered condensed',
    'dataProvider'=>$empleado_model->search(),
	'filter'=>$empleado_model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'pager'=>array(
	        'class'=>'bootstrap.widgets.BootPager',
	        'displayFirstAndLast'=>true,
	),
	'columns'=>array(
		array('name'=>'nombre_completo', 'header'=>'Nombre Completo'),
		array('name'=>'genero', 'header'=>'Genero', 'htmlOptions'=>array('width'=>'80px')),
		array('name'=>'tipo_documento', 'header'=>'Tipo Documento', 'htmlOptions'=>array('width'=>'100px')),
        array('name'=>'numero_identificacion', 'header'=>'Numero Identificación', 'htmlOptions'=>array('width'=>'140px')),
		array('name'=>'activo', 'header'=>'Activo?', 'htmlOptions'=>array('width'=>'40px')),
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{select}',
				'buttons'=>array
				    (
				        'select' => array
				        (
							'url' => '"#".$data->id."#".$data->nombre_completo',
							'label' => "<i class='icon-ok'></i>",
							'options'=>array('title' => 'seleccionar este empleado', 'onClick' => "setEmpleado(this);"),
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
        'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'asistente-comite-compras-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

	<label for="AsistenteComiteCompras_id_empleado">Empleado</label><input class="span5" name="AsistenteComiteCompras[id_empleado]_2" id="AsistenteComiteCompras_id_empleado_nombre" type="text" disabled="disabled" value="<?php 
	$query = Empleados::model()->findAllByPk($model->id_empleado);
	if(count($query) >0){
		$empleado = $query[0];
		echo $empleado->nombre_completo;
	} ?>">
	
	<?php echo $form->hiddenField($model,'id_empleado',array('class'=>'span5')); ?><?php $this->widget('bootstrap.widgets.BootButton', array(
	    'label'=>'Seleccionar Empleado',
	    'url'=>'#myModal',
	    'type'=>'primary',
	    'htmlOptions'=>array('data-toggle'=>'modal', 'style' => 'margin:-9px 0px 0px 5px;'),
	)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Editar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
