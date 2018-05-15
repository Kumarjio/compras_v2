<?php
$volver= ($tipo_documento_p==1 or $tipo_documento_p==2)  ? 'crearContratoJuridico' : 'CrearTemporalJuridico';
$this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico")),
		array( 'label'=>"Principal", 'url'=>Yii::app()->createUrl("documentoProveedor/".$volver,array("id_docpro"=>base64_encode($model[id_doc_pro_padre])))),
		array( 'label'=>"Acuerdo de Confidencialidad", 'url'=>'#', "active"=>true),
    ); ?>
	<div class="row"><div class='span5'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>
<div class='row'>
	<div class='span5'>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'documento-proveedor-form',
	'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 

 	echo $form->errorSummary($model); 
	echo $form->labelEx($model,'fecha_firma');
	 $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'attribute'=>'fecha_firma',
							'language' => 'es',
							'options'=>array(
								'showAnim'=>'fold',
								'dateFormat' => 'yy-mm-dd',
								'changeMonth'=> true,
								'changeYear'=> true,
								),'htmlOptions'=>array(
									'style'=>'height:20px;',
									'data-sync' => 'true',
									'class' => 'span5'
									)
							)
						);
	?>

        <?php echo $form->checkBox($model,'parte_del_contrato',	array('class'=>"span1")); ?>   ¿Hace Parte del Contrato?
		<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
		</div>

<?php $this->endWidget(); ?>
	</div>
	<div class="span7">
	<?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo));  ?>
	</div>
</div>
<br/>
<script>
 $(document).ready(function() {
		$("#DocumentoProveedor_fecha_inicio").change(function(){
	    	$("#DocumentoProveedor_fecha_fin").val("");
			$("#DocumentoProveedor_fecha_firma").val("");
	    	$('#DocumentoProveedor_fecha_fin').datepicker('option','minDate', $("#DocumentoProveedor_fecha_inicio").val());
			$('#DocumentoProveedor_fecha_fin').datepicker('option','defaultDate', $("#DocumentoProveedor_fecha_inicio").val());
		//	$('#DocumentoProveedor_fecha_firma').datepicker('option','minDate', $("#DocumentoProveedor_fecha_inicio").val());
			$('#DocumentoProveedor_fecha_firma').datepicker('option','defaultDate', $("#DocumentoProveedor_fecha_inicio").val());
		});




	//Bloqueo de campos

	
	$('#DocumentoProveedor_fecha_fin_ind').click(function() {
        if ($('#DocumentoProveedor_fecha_fin_ind').is(':checked')) {
            $('#DocumentoProveedor_fecha_fin').val('');
			$("#DocumentoProveedor_fecha_fin").prop('disabled', true);
		}else{
			$("#DocumentoProveedor_fecha_fin").prop('disabled', false);
		}
	});
});
verifica_bloqueo();
  function verifica_bloqueo(){
	if( $('#DocumentoProveedor_fecha_fin_ind').is(':checked')) {
        $('#DocumentoProveedor_fecha_fin').val('');
        $("#DocumentoProveedor_fecha_fin").prop('disabled', true);
    }
  }
 </script>