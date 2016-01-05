<?php
$this->breadcrumbs=array(
	'Pacientes'=>array('admin'),
	'Crear',
);
$this->setPageTitle('Creación de Pacientes');

?>

<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Ingrese la cédula para consultar el paciente</h3>
    </div>
    <div class="panel-body">

		<?php $form=$this->beginWidget('CActiveForm',array(
			'id'=>'pacientes-form',
			'enableAjaxValidation'=>false
		)); ?>
                
            <div class="form-group">
                <?php echo $form->labelEx($model,'cedula', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model,'cedula',array('class'=>'form-control','maxlength'=>15)); ?>
                <?php echo $form->error($model,'cedula'); ?>
            </div>
        
            <div class="form-group">
		<?php echo CHtml::submitButton('Consultar', array('class' => 'btn-u btn-u-blue')); ?>
            </div>

	<?php $this->endWidget(); ?>
	</div>
</div>
