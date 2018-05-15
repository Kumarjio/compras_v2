<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'parametros-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>

	<?php echo $form->errorSummary($model); ?>

        <?php echo $form->labelEx($model,'id_empl_listas'); ?>
        <?php echo $form->hiddenField($model,'id_empl_listas'); ?>
            <?php 
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'nombre_empl_listas',
                'name'=>'nombre_empl_listas',
                'source'=>array_map(function($key, $value) {
                    $algo = explode(' - ', $value);
                   return array('label' => $value, 'value' => $algo[1], 'key'=>  $key);
                }, 
                array_keys(Facturas::model()->getAnalista()), 
                Facturas::model()->getAnalista()),
                'htmlOptions'=>array(
                    'class'=>'span5',
                ),
                'options'=> array(
                    'select'=>"js:function(event, ui) { 
                        $('#Parametros_id_empl_listas').val(ui.item.key); 
                    }",
                    'response'=>"js:function(event, ui) { 
                        console.log('HL close');
                    }"
                ),
            ));
         ?>

        <?php echo $form->labelEx($model,'id_empl_clientes'); ?>
        <?php echo $form->hiddenField($model,'id_empl_clientes'); ?>
            <?php 
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'nombre_empl_clientes',
                'name'=>'nombre_empl_clientes',
                'source'=>array_map(function($key, $value) {
                    $algo = explode(' - ', $value);
                   return array('label' => $value, 'value' => $algo[1], 'key'=>  $key);
                }, 
                array_keys(Facturas::model()->getAnalista()), 
                Facturas::model()->getAnalista()),
                'htmlOptions'=>array(
                    'class'=>'span5',
                ),
                'options'=> array(
                    'select'=>"js:function(event, ui) { 
                        $('#Parametros_id_empl_clientes').val(ui.item.key); 
                    }",
                    'response'=>"js:function(event, ui) { 
                        console.log('HL close');
                    }"
                ),
            ));
         ?>

        <?php echo $form->labelEx($model,'id_empl_operaciones'); ?>
        <?php echo $form->hiddenField($model,'id_empl_operaciones'); ?>
            <?php 
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'nombre_empl_operaciones',
                'name'=>'nombre_empl_operaciones',
                'source'=>array_map(function($key, $value) {
                    $algo = explode(' - ', $value);
                   return array('label' => $value, 'value' => $algo[1], 'key'=>  $key);
                }, 
                array_keys(Facturas::model()->getAnalista()), 
                Facturas::model()->getAnalista()),
                'htmlOptions'=>array(
                    'class'=>'span5',
                ),
                'options'=> array(
                    'select'=>"js:function(event, ui) { 
                        $('#Parametros_id_empl_operaciones').val(ui.item.key); 
                    }",
                    'response'=>"js:function(event, ui) { 
                        console.log('HL close');
                    }"
                ),
            ));
         ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
