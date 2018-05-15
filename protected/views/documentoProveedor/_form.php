<?php $form2=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'documento-proveedor-form-c',
	'enableAjaxValidation'=>false,
)); ?>
	<h3> <?php echo $model->proveedor_rel->razon_social." - ".$model->proveedor; ?>
	<?php //echo $form2->errorSummary($model); ?>
	<?php echo $form2->labelEx($model,'tipo_documento'); ?>
	<?php echo $form2->dropDownList($model,
		'tipo_documento',
		CHtml::listData(TipoDocumentos::model()->findAll(array("order"=>"tipo_documento")),"id_tipo_documento","tipo_documento"),
  array('prompt' => 'Seleccione...','class'=>'span5','data-sync'=>'true',
	'onChange' => CHtml::ajax(
		array(
		   'type' => 'post',
			'dataType' => 'json',
			'data' => array('tipo_documento' => 'js:this.value', 'proveedor'=>$model_c->proveedor),
			'url' => $this->createUrl("DocumentoProveedor/campos"),
			'success' => 'function(data){
				$("#campos_doc").html(data.res);	
				if(data.tipo_documento==3 || data.tipo_documento==2 || data.tipo_documento==1 ){
					jQuery(\'#DocumentoProveedor_fecha_inicio\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'es\'], {\'showAnim\':\'fold\',\'dateFormat\':\'yy-mm-dd\'}));
					jQuery(\'#DocumentoProveedor_fecha_fin\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'es\'], {\'showAnim\':\'fold\',\'dateFormat\':\'yy-mm-dd\'}));
					if(data.tipo_documento==3){
						jQuery(\'#DocumentoProveedor_fecha_terminacion\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'es\'], {\'showAnim\':\'fold\',\'dateFormat\':\'yy-mm-dd\'}));
					}else{
						jQuery(\'#DocumentoProveedor_fecha_firma\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'es\'], {\'showAnim\':\'fold\',\'dateFormat\':\'yy-mm-dd\'}));
					}
				}else if(data.tipo_documento==4){
					jQuery(\'#DocumentoProveedor_fecha_terminacion\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'es\'], {\'showAnim\':\'fold\',\'dateFormat\':\'yy-mm-dd\'}));
				}
				$(\'#DocumentoProveedor_tipo_documento\').val(data.tipo_documento);
			}'
	    )
	)
  )); ?>
  

  <?php $this->endWidget(); ?>
  <div id="campos_doc" >
  <? if($vista !=""){  $this->renderPartial($vista, array('model'=>$model)); } ?>
  </div>


