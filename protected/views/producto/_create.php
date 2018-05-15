<?php
if (Yii::app()->request->isAjaxRequest) {
    $cs = Yii::app()->clientScript;
    $cs->scriptMap['jquery.js'] = false;
    $cs->scriptMap['jquery.min.js'] = false;
}

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>'orden-solicitud-costos-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('onSubmit' => 'return false')
));
$familias = array();
$prompt = "Seleccione Categoria...";
if($model->id_categoria){
	$familias = CHtml::listData(FamiliaProducto::model()->findAllByAttributes(array('id_categoria'=>$model->id_categoria)),'id','nombre');
	$prompt = "Seleccione...";
}


?>

<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->dropDownListGroup(
		$model,
		'id_categoria',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5',
					'ajax'=>array(
			            'type'=>'POST',
			            'url'=>$this->createUrl('categorias/traerFamilias'),
			            'update'=>'#Producto_id_familia'
			        ),
			        'prompt'=>'Seleccione...'
				), 
				'data'=>CHtml::listData(Categorias::model()->findAll(), 'id', 'nombre')
		))); ?>
	<?php echo $form->dropDownListGroup($model,'id_familia',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'prompt'=>$prompt), 'data'=>$familias))); ?>
	<?php echo $form->textFieldGroup($model,'nombre',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

				<div style="display: none;">
				<?php
		            $this->widget('booster.widgets.TbGridView',array(
		                              'id'=>'orden-solicitud-grid',
		                              'dataProvider'=>Producto::model()->search(),
		                              //'template' => "{items}",
		                              //'filter' => $productos,
		                              'type' => 'striped bordered condensed',
		                              'responsiveTable' => true,
		                              'columns'=>array(
		                                  'nombre',  
		                              ),
		                            ));
		            $this->widget('booster.widgets.TbGridView',array(
		                              'id'=>'productos-om-grid',
		                              'dataProvider'=>Gerencias::model()->search(),
		                              //'template' => "{items}",
		                              //'filter' => $productos,
		                              'type' => 'striped bordered condensed',
		                              'responsiveTable' => true,
		                              'columns'=>array(
		                                  'nombre',  
		                              ),
		                            ));
		          ?>
		      </div>