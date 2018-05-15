<?php
$volver= ($tipo_documento_p==1 or $tipo_documento_p==2) ? 'crearContratoJuridico' : 'CrearTemporalJuridico';
$this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico")),
		array( 'label'=>"Principal", 'url'=>Yii::app()->createUrl("documentoProveedor/".$volver,array("id_docpro"=>base64_encode($model[id_doc_pro_padre])))),
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
		 echo $form->errorSummary($model_poliza); 
echo $form->labelEx($model_poliza,'fecha_inicio'); 
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model_poliza,
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
		); 	
			?>
			<p> <?php 
		 echo $form->labelEx($model_poliza,'fecha_fin');
		 $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model_poliza,
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
		 <?php echo $form->checkBox($model_poliza,'fecha_fin_ind',	array('class'=>"span1")); ?> Indefinido
		</p>
		<label>Tipo P&oacute;liza <span class="required">*</span></label>
			<?php echo $form->dropDownList($model_poliza,
				'id_tipo_poliza',
				CHtml::listData(TipoPoliza::model()->findAll(),"id_tipo_poliza","tipo_poliza"),
				array('class'=>'form-control'));
			?>
			<?php/* echo $form->dropDownList($model,
						 'id_tipo_poliza',
						 CHtml::listData(TipoPoliza::model()->findAll(),"id_tipo_poliza","tipo_poliza"),
						 array('class'=>'form-control', 'multiple' => 'multiple'));
*/?>

		<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model_poliza->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
		</div>
                <?php 
  $this->widget('bootstrap.widgets.BootGridView',array(
    'id'=>'poliza-grid',
    'dataProvider'=> PolizaDocumento::model()->search($model->id_docpro),
    'type'=>'striped bordered condensed',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'columns'=>array(
        'fecha_inicio',
        'fecha_fin',
        array(
            'name'=>'id_tipo_poliza',
            'value'=>'$data->tipoPoliza->tipo_poliza'
        ),
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
        'template' => '{delete}',
        'deleteButtonUrl'=>'Yii::app()->createUrl(\'polizaDocumento/delete/id/\'. $data->id_poldoc)',
      ),
    ),
  )); ?>
         
<?php $this->endWidget(); ?>
	</div>
	<div class="span7">
	<?php $this->renderPartial('verArchivo', array('archivo'=>$model->path_archivo));  ?>
	</div>
</div>
<br/>
<script> 
/*
$('#DocumentoProveedor_id_tipo_poliza').multipleSelect({
            width: 460,
});  
*/
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
});
		verifica_bloqueo();
  function verifica_bloqueo(){
	if( $('#DocumentoProveedor_fecha_fin_ind').is(':checked')) {
        $('#DocumentoProveedor_fecha_fin').val('');
        $("#DocumentoProveedor_fecha_fin").prop('disabled', true);
    }
  }

</script>