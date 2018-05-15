<?php
$volver=($fn)? 'crearContratoConsulta':(($tipo_documento_p==1 or $tipo_documento_p==2 ) ? 'crearContrato' : 'CrearTemporal');
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
		array( 'label'=>"Aumento de Precios", 'url'=>'#', "active"=>true),
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
echo $form->labelEx($model,'fecha_recibido'); 
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'fecha_recibido',
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
		
echo $form->labelEx($model,'fecha_alza'); 
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'fecha_alza',
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
	?><a href="#" rel="tooltip" title="Digite números de 0 a 100, en caso de requerir un decimal ingrese el caracter punto (.) "><i class="icon-question-sign"></i></a>
 <?php echo $form->textFieldRow($model,'porc_incremento',array('class'=>'span5')); 
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
$('#DocumentoProveedor_porc_incremento').maskMoney();
var valor = $('#DocumentoProveedor_porc_incremento').val();
if (valor == ''){
    $('#DocumentoProveedor_porc_incremento').val(0);
}
</script>
