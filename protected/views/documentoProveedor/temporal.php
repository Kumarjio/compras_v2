<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor"), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/view",array("id_proveedor"=>base64_encode($model[proveedor]))), 'visible'=>array_intersect( array('CYC989','CYC994'), Yii::app()->user->permisos )),
		array( 'label'=>'Editar Contratos', 'url'=>Yii::app()->createUrl("documentoProveedor/consulta"), 'visible'=>array_intersect( array('CYC986'), Yii::app()->user->permisos )),
		array( 'label'=>"Documento Temporal", 'url'=>'#', "active"=>true),
		array( 'label'=>"Trazabilidad", 'itemOptions'=>array('id'=>'trazabilidad','data-toggle'=>'modal',
        'data-target'=>'#myModal')),
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
	echo $form->textAreaRow($model,'objeto',array('class'=>'span5')); ?>
	
		 <?php echo $form->labelEx($model,'id_orden'); 
	 $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model'=>$model,
                       	    'attribute'=>'id_orden',
                            'name'=>'id_orden',
                       	    'source'=>array_map(function($key, $value) {
        return array('label' => $value, 'value' => $key);
    }, array_keys(DocumentoProveedor::model()->getOrdenesCompra($model->proveedor)), DocumentoProveedor::model()->getOrdenesCompra($model->proveedor)),
     	));
     ?>

	<label>Gerencia <span class="required">*</span></label>
			<?php echo $form->dropDownList($model,
					 'id_gerencia',
					 CHtml::listData(Gerencias::model()->findAll(),"id","nombre"),
					 array('prompt' => 'Seleccione...',
						'class'=>'span5',
						'data-sync'=>'true',
						'onChange' => CHtml::ajax(array(
						'type' => 'post',
						'dataType' => 'json',
						'data' => array('gerencia' => 'js:this.value','model'=>'DocumentoProveedor'),
						'url' => $this->createUrl("gerencias/jefaturasDoc"),
						'success' => 'function(data){
							if(data.status == "ok"){
								$("#DocumentoProveedor_id_jefatura").replaceWith(data.combo);
								$("#DocumentoProveedor_id_gerente").val(data.gerente.id);	
								 $("#DocumentoProveedor_responsable_proveedor").val("");
							}else{
								alert(data.mensaje);
								$("#DocumentoProveedor_id_gerente").val("");	
								
													$("#DocumentoProveedor_responsable_proveedor").val("");

							}
								
						}')))); ?>
		  
		  <?php if($model->id_gerencia != ""): ?>
							<label >Jefatura  <span class="required">*</span></label>
				<?php echo $form->dropDownList($model,
						 'id_jefatura',
						 CHtml::listData(
				 Jefaturas::model()->findAllByAttributes(array('id_gerencia' => $model->id_gerencia)),
				 "id",
				 "nombre"
				 ),
						 array('prompt' => 'Seleccione...',
							   'class' => 'span5',
			   'data-sync'=>'true',
			   'id' => 'DocumentoProveedor_id_jefatura',
			   'onChange' => CHtml::ajax(array(
				   'type' => 'post',
					'dataType' => 'json',
					'data' => array('jefatura' => 'js:this.value'),
					'url' => $this->createUrl("jefaturas/nombrejefe"),
					'success' => 'function(data){
						if(data.status == "ok"){
							
							$("#DocumentoProveedor_responsable_proveedor").val(data.jefe.nombre);
							
						}else{
							alert(data.mensaje);
							$("#DocumentoProveedor_id_jefatura").val("");	
							$("#DocumentoProveedor_responsable_proveedor").val("");
						}	                                       				
					}'
						  )
												)
											)); ?>
		  <?php else: ?>
				<?php echo $form->dropDownListRow($model,
												 'id_jefatura',
												 array(),
	  array('prompt' => 'Seleccione una gerencia...','class'=>'span5','data-sync'=>'true')); ?>
			<?php endif ?>
	<?php echo $form->textFieldRow($model,'responsable_proveedor',array('class'=>'span5','readonly'=>'readonly')); ?>
	<?php echo $form->labelEx($model,'responsable_compras'); ?>
		<?php echo $form->dropDownList($model,
			'responsable_compras',
			DocumentoResponsableCompras::model()->GetListaResponsableCompras(),
	  array('prompt' => 'Seleccione...','class'=>'span5','data-sync'=>'true')); ?>
		<br>	
	
	<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Guardar Datos' : 'Guardar Datos',
			)); ?>
	<?php	
		 $this->widget( 'bootstrap.widgets.BootButton',array(
			'buttonType'=>'submit', 
            'type'=>'primary', 
            'icon'=>'arrow-up white',
            'label'=>'Guardar y Cargar Documentos'
		) ); 
	?>
        <br><br>
        <?php if($model[id_docpro]): ?>
            <?php $this->widget( 'bootstrap.widgets.BootButton',array(
                    'buttonType'=>'submit', 
                        'type'=>'primary', 
                        'icon'=>'arrow-up white',
                        'label'=>'Crear Contrato',
                        'htmlOptions'=>array('submit'=>Yii::app()->createUrl("documentoProveedor/adjunto", array("proveedor" => base64_encode($model[proveedor]),"tipo_documento"=>1,"id" => base64_encode($model[id_docpro]))))
                    )
            ); ?>
        <?php endif; ?>
		</div>

<?php $this->endWidget(); ?>
	</div>
</div>
<?php 
if($model->id_docpro>0){
	$this->renderPartial('documento_detalle',array('model_detalle'=>$model_detalle,'model'=>$model));
}
	$this->renderPartial('_trazabilidad',array('model_traza'=>$model_traza,'model'=>$model));

	?>
	
	 <script>
 $(document).ready(function() {
$("#DocumentoProveedor_objeto").bind('keyup', function (e) {
    if (e.which >= 97 && e.which <= 122) {
        var newKey = e.which - 32;
        // I have tried setting those
        e.keyCode = newKey;
        e.charCode = newKey;
    }
    $("#DocumentoProveedor_objeto").val(($("#DocumentoProveedor_objeto").val()).toUpperCase());
});

  $('#id_orden').blur(function(){
    var urlr='<?=Yii::app()->createUrl('documentoProveedor/datosOrden'); ?>';
    var url2='<?=Yii::app()->createUrl('gerencias/jefaturasDoc'); ?>';
     $.ajax({
       url: urlr,
       type: 'post',
       data: { id_orden:$('#id_orden').val() },
       success: function(data){
         var datos=jQuery.parseJSON(data );
         $('#DocumentoProveedor_id_gerencia').val(datos.id_gerencia);
         $.ajax({
          type: 'post',
          dataType : 'json',
          url : url2,
          data : { gerencia : datos.id_gerencia, model : 'DocumentoProveedor' },
          success : function(data){
          //  console.log(data);
            if(data.status == "ok"){
              $("#DocumentoProveedor_id_jefatura").html();
              $("#DocumentoProveedor_id_jefatura").replaceWith(data.combo);
              $("#DocumentoProveedor_id_gerente").val(data.gerente.id);
               $("#DocumentoProveedor_responsable_proveedor").val("");
              $('#DocumentoProveedor_id_jefatura').val(datos.id_jefatura);
               $('#DocumentoProveedor_id_jefatura').change();
            }else{
              alert(data.mensaje);
              $("#DocumentoProveedor_id_gerente").val("");
              $("#DocumentoProveedor_responsable_proveedor").val("");
            }
          }

        });

       }
     });
  });
});
 </script>