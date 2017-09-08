<?php
$this->breadcrumbs=array(
	'Medicos'=>array('admin'),
	'Actualizar Registro',
);
$this->setPageTitle('Actualización de Medicos');

?>

<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Informarción del Medicos</h3>
    </div>
    <div class="panel-body">

		<?php $form=$this->beginWidget('CActiveForm',array(
			'id'=>'medicos-form',
			'enableAjaxValidation'=>false
		)); ?>

		<?php echo $this->renderPartial('_form',array('form' => $form,'model'=>$model)); ?>
		<?php $this->endWidget(); ?>
	</div>
</div>
