<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'empleados-form',
	'enableAjaxValidation'=>false,
)); ?>
	</br>
	<div class="panel panel-primary">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?= $model->isNewRecord ? 'Crear' : 'Actualizar' ?> Empleados</h3>
	  </div>
	  <div class="panel-body">
		<div class="alert alert-block alert-warning fade in">
			<a class="close" data-dismiss="alert">×</a>
			<strong>Recuerde!</strong> 
			Los campos marcados con <span class="required">*</span> son obligatorios.
		</div>
		<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldGroup($model,'numero_identificacion', array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255 )))); ?>

		<?php echo $form->textFieldGroup($model,'nombre_completo',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255 )))); ?>

		<?php echo $form->textFieldGroup($model,'email',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5' )))); ?>

	    <?php echo $form->dropDownListGroup($model,'cargo',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'prompt' => 'Seleccione', 'value' => $cargo), 'data'=>CHtml::listData(Cargos::model()->findAll(array('order' => 'nombre asc')), "id", "nombre")))); ?>

		<div class="form-actions">

		    <?php $this->widget('booster.widgets.TbButton', array(
	            'buttonType'=>'submit',
	            'context'=>'primary',
	            'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
	        )); ?>
		</div>
	    
	  </div>
	</div>

<?php $this->endWidget(); ?>
