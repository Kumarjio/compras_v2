<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
		array( 'label'=>'Crear Contrato', 'url'=>Yii::app()->createUrl("Proveedor/carga")),
		array( 'label'=>'Principal', 'url'=>Yii::app()->createUrl("documentoProveedor/view",array("id_proveedor"=>base64_encode($model[proveedor])))),
		array( 'label'=>"Adjuntar Contrato", 'url'=>'#', "active"=>true),
    ); ?>
	<div class="row"><div class='span5'><h4><?=DocumentoProveedor::traerNombreProveedor($model[proveedor])?></h4></div></div>
	<div class="span12">
<?php

 $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'documento-proveedor-form',
	'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
));

            echo $form->errorSummary($model); 
            echo $form->labelEx($model,'path_archivo'); 
            echo $form->fileField($model,'path_archivo'); 
            echo CHtml::hiddenField('jur', $jur);
        ?>
<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Crear Documento',
		)); ?>
	</div>
<?php $this->endWidget(); ?>
</div>