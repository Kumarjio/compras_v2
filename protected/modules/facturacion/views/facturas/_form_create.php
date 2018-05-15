<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'facturas-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>
        
        <?php echo $form->dropDownListRow($model,'tipo_identificacion',  CHtml::listData(TipoDocumento::model()->findAll(), 'id_tipo_documento', 'nombre'),array('class'=>'span5', 'prompt'=>'Seleccione...')); ?>
        <?php echo $form->labelEx($model,'nit_proveedor'); ?>
        <?php 
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute'=>'nit_proveedor',
                    'name'=>'nit_proveedor',
                    'source'=>array_map(function($key, $value) {
                       return array('label' => $value, 'value' => $key);
                    }, 
                    array_keys(Facturas::model()->getProveedor()), 
                    Facturas::model()->getProveedor()),
                    'htmlOptions'=>array(
                        'class'=>'span5',
                    ),
                    
                ));
             ?>

	<?php echo $form->fileFieldRow($model,'path_imagen',array('class'=>'span5')); ?>
        
        <?php //echo $form->labelEx($model,'id_orden'); ?>
    
        <?php 
                /*$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute'=>'id_orden',
                    'name'=>'id_orden',
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('facturas/getOrden').'",
                            dataType: "json",
                            data: {
                                term: request.term,
                                nit: $("#nit_proveedor").val()
                            },
                            success: function (data) {
                                    response(data);
                            }
                        })
                     }',
                ));*/
             ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
$(document).ready(function() {
    
});
</script>