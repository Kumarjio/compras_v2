<?php
$volver= ($fn)? 'crearContratoConsulta':(($tipo_documento_p==1 or $tipo_documento_p==2 ) ? 'crearContrato' : 'CrearTemporal');
$this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor")),
		array( 'label'=>'Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/view",array("id_proveedor"=>base64_encode($model[proveedor])))),		
		array( 'label'=>"Principal", 'url'=>Yii::app()->createUrl("documentoProveedor/".$volver,array("id_docpro"=>base64_encode($model[id_doc_pro_padre]), 'fn'=>$fn))),
		array( 'label'=>"Agregar Documentos", 'url'=>Yii::app()->createUrl("documentoProveedor/adjuntoDocumento",
			array(	"id_proveedor"=>base64_encode($model[proveedor]), 
					"id_docpro"=>base64_encode($model[id_doc_pro_padre]),
					"tipo_documento"=>base64_encode($tipo_documento_p),
                                        'fn'=>$fn
				))),
		array( 'label'=>"Poliza", 'url'=>'#', "active"=>true),
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
echo $form->labelEx($model,'fecha_inicio'); 
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'fecha_inicio',
			'language' => 'es',
			'options'=>array(
				'showAnim'=>'fold', 
				'dateFormat' => 'yy-mm-dd',
				'changeMonth'=> true,
                'changeYear'=> true,
				),'htmlOptions'=>array(
					'style'=>'height:20px;',
					'data-sync' => 'true',
					'class' => 'span4'
					)
			)
		); 	?>
		<p> <?php 
		 echo $form->labelEx($model,'fecha_fin');
		 $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'fecha_fin',
			'language' => 'es',
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat' => 'yy-mm-dd',
				'changeMonth'=> true,
                    'changeYear'=> true,
				),'htmlOptions'=>array(
					'style'=>'height:20px;',
					'data-sync' => 'true',
					'class' => 'span3'
					)
			)
		); ?>
		 <?php echo $form->checkBox($model,'fecha_fin_ind',	array('class'=>"span1")); ?> Indefinido
		</p>
		<label>Tipo Poliza <span class="required">*</span></label>
			<?php echo $form->dropDownList($model,
						 'id_tipo_poliza',
						 CHtml::listData(TipoPoliza::model()->findAll(),"id_tipo_poliza","tipo_poliza"),
						 array('class'=>'form-control', 'multiple' => 'multiple'));
?>
		<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
		</div>
                
	</div>
	<div class="span7">
	<?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo));  ?>
	<br/>
            <p>Si requiere modificar un archivo pdf por favor ingrese en el siguiente campo una o varias sucesiones de im&aacute;genes por ejemplo: 1-5,8,10-20, se guardara un archivo con las p&aacute;ginas 1 a la 5, 8, continuando con las p&aacute;ginas 10 a la 20.</p>
            <?php echo CHtml::textField('paginas'); ?>
				<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Guardar Datos',
			)); ?>
	<br/><br/>
            <?php echo $form->fileField($model,'archivo_cambio');?>
				<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Reemplazar Imagen',
			)); ?>
        <br/><br/>
	<?php $this->endWidget(); ?>
</div>

<script>
 $('#DocumentoProveedor_id_tipo_poliza').multipleSelect({
            width: 460,
 });
 $(document).ready(function() {    
     
$("#DocumentoProveedor_fecha_inicio").change(function(){
	    	$("#DocumentoProveedor_fecha_fin").val("");
	    	$('#DocumentoProveedor_fecha_fin').datepicker('option','minDate', $("#DocumentoProveedor_fecha_inicio").val());
			$('#DocumentoProveedor_fecha_fin').datepicker('option','defaultDate', $("#DocumentoProveedor_fecha_inicio").val());
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

        $(".prevent").on("click", function(e){
            e.preventDefault();
        })
});
		verifica_bloqueo();
  function verifica_bloqueo(){
	if( $('#DocumentoProveedor_fecha_fin_ind').is(':checked')) {
        $('#DocumentoProveedor_fecha_fin').val('');
        $("#DocumentoProveedor_fecha_fin").prop('disabled', true);
    }
  }

</script>