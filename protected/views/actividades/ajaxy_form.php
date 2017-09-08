
<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Informarción del Actividades</h3>
    </div>
    <div class="panel-body">

		<?php $form=$this->beginWidget('CActiveForm',array(
			'id'=>'actividades-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('onSubmit' => 'return false')
		)); ?>

		<p class="note">Campos marcados con <span class="required">*</span> son requeridos.</p>

		<?php echo $this->renderPartial('_form', array('form' => $form,'model' => $model)); ?>

		<?php $this->endWidget(); ?>

	</div>
</div>

