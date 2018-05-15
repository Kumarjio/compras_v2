<?php
$volver= ($tipo_documento_p==1 or $tipo_documento_p==2 )  ? 'crearContratoJuridico' : 'CrearTemporalJuridico';
$this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Gestionar', 'url'=>Yii::app()->createUrl("/documentoProveedor/gestionJuridico")),
		array( 'label'=>"Principal", 'url'=>Yii::app()->createUrl("documentoProveedor/".$volver,array("id_docpro"=>base64_encode($model[id_doc_pro_padre])))),
    array( 'label'=>"Propuesta Comercial", 'url'=>'#', "active"=>true),
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
echo $form->textFieldRow($model,'nombre_contrato',array('class'=>'span5')); ?>
<?php echo $form->checkBox($model,'parte_del_contrato',	array('class'=>"span1")); ?>   ¿Hace Parte del Contrato?
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
<!--
        <p>Si requiere modificar un archivo pdf por favor ingrese en el siguiente campo una o varias sucesiones de im&aacute;genes por ejemplo: 1-5,8,10-20, se guardara un archivo con las p&aacute;ginas 1 a la 5, 8, continuando con las p&aacute;ginas 10 a la 20.</p>
        <?/*php echo CHtml::textField('paginas'); ?>
    <?php $this->widget('bootstrap.widgets.BootButton', array(
    'buttonType'=>'submit',
    'type'=>'primary',
    'label'=>$model->isNewRecord ? 'Crear' : 'Guardar Datos',
  )); */?>
	<br/><br/>
            <?/*php echo $form->fileField($model,'archivo_cambio');?>
				<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Reemplazar Imagen',
			)); */?>
        <br/><br/>
    -->
</div>
<?php $this->endWidget(); ?>
</div>
<br/>
<script>
$("#DocumentoProveedor_nombre_contrato").bind('keyup', function (e) {
if (e.which >= 97 && e.which <= 122) {
    var newKey = e.which - 32;
    // I have tried setting those
    e.keyCode = newKey;
    e.charCode = newKey;
}
$("#DocumentoProveedor_nombre_contrato").val(($("#DocumentoProveedor_nombre_contrato").val()).toUpperCase());
});

$("#DocumentoProveedor_objeto").bind('keyup', function (e) {
if (e.which >= 97 && e.which <= 122) {
    var newKey = e.which - 32;
    // I have tried setting those
    e.keyCode = newKey;
    e.charCode = newKey;
}
$("#DocumentoProveedor_objeto").val(($("#DocumentoProveedor_objeto").val()).toUpperCase());
});
</script>
