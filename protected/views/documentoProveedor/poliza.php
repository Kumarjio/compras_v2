<?php
$volver= ($fn)? 'crearContratoConsulta':(($tipo_documento_p==1 or $tipo_documento_p==2 ) ? 'crearContrato' : 'CrearTemporal');
$this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
    array( 'label'=>'Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/view",array("id_proveedor"=>base64_encode($model[proveedor]))), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),	
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
		); 	?>
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
		<label>Tipo Poliza <span class="required">*</span></label>
			<?php echo $form->dropDownList($model_poliza,
						 'id_tipo_poliza',
						 CHtml::listData(TipoPoliza::model()->findAll(),"id_tipo_poliza","tipo_poliza"),
						 array('class'=>'form-control'));
?>
<br>
    <?php echo $form->labelEx($model_poliza,'tiempo_preaviso',array('class'=>'span5')); ?>
  <?php echo "Años:";
    echo $form->textField($model_poliza,'tiempo_pre_anio', array('class'=>"span1"));
    echo " Meses: ";
    echo $form->textField($model_poliza,'tiempo_pre_mes',  array('class'=>"span1"));
    echo " Dias: ";
    echo $form->textField($model_poliza,'tiempo_pre_dia',  array('class'=>"span1")); ?>
		<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model_poliza->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>

		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model_poliza->isNewRecord ? 'Crear y Salir' : 'Guardar y Salir',
                        'htmlOptions'=>array('name'=>'yt3')
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
	    
    
<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModalAjax','htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>


  <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>&nbsp;</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
      Cargando...
 
  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal"),
      )); ?>
  </div>

 
<?php $this->endWidget(); ?>
   
 
<script>
 $(document).ready(function() {    
     
$("#PolizaDocumento_fecha_inicio").change(function(){
	    	$("#PolizaDocumento_fecha_fin").val("");
	    	$('#PolizaDocumento_fecha_fin').datepicker('option','minDate', $("#PolizaDocumento_fecha_inicio").val());
			$('#PolizaDocumento_fecha_fin').datepicker('option','defaultDate', $("#PolizaDocumento_fecha_inicio").val());
		});
	//Bloqueo de campos
	$('#PolizaDocumento_fecha_fin_ind').click(function() {
        if ($('#PolizaDocumento_fecha_fin_ind').is(':checked')) {
            $('#PolizaDocumento_fecha_fin').val('');
			$("#PolizaDocumento_fecha_fin").prop('disabled', true);
		}else{
			$("#PolizaDocumento_fecha_fin").prop('disabled', false);
		}
});

        $(".prevent").on("click", function(e){
            e.preventDefault();
        })
});
		verifica_bloqueo();
  function verifica_bloqueo(){
	if( $('#PolizaDocumento_fecha_fin_ind').is(':checked')) {
        $('#PolizaDocumento_fecha_fin').val('');
        $("#PolizaDocumento_fecha_fin").prop('disabled', true);
    }
  }
  
  function agregarpoliza(el){
      var url = $(el).attr("href");
      jQuery.ajax(
            {'url':url,
            'dataType':'json',
            'type':'post',
            'success': function(data){
                $("#modal-content").html(data.content);
                $("#myModalAjax").modal('show');
                var form = $("#modal-content").find("form");
                var button = form.find("input[type=submit]");
                form.submit(nuevaPoliza);
                button.click(function(e){
                    alert('hola')
//                   var serialized = form.serialize(); 
//                   doReqData(form.attr("action"), serialized, postFun);
                });
            },
            'cache':false}
        );
  }
function nuevaPoliza(div)
{
  alert('hola');
    var url = "<?php echo $this->createUrl('polizaDocumento/create', array('id_docpro'=>$model->id_docpro)); ?>";
    
    jQuery.ajax({
        'url': url ,
        'type':'post',
        'data' : $('#myModalAjax div.modal-body form').serialize(),
        'dataType':'json',
        'beforeSend':function(){
            
        },
        'success':function(data)
            {
                console.log(data);
            if (data.status == 'error')
                {
                    alert('llego');
                    $('#myModalAjax div.modal-body').html("");
                    $('#myModalAjax div.modal-body').html(data.content);
                    $('#myModalAjax div.modal-header h3').html("Agregar un proveedor");
                    $('#myModalAjax div.modal-body form').submit(nuevaPoliza);
                }
                else
                {
                    $('#orden-proveedor-grid').yiiGridView.update('orden-proveedor-grid');
                    $('#myModalAjax div.modal-body').html("");
                    $('#myModalAjax').modal('hide');
                }
 
            } ,'cache':false});
    
}
</script>