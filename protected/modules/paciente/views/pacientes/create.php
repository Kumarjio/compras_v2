<?php
$this->breadcrumbs=array(
	'Pacientes'=>array('admin'),
	'Crear',
);
$this->setPageTitle('Creación de Pacientes');

?>

<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Informarción del Pacientes</h3>
    </div>
    <div class="panel-body">

		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
			'id'=>'pacientes-form',
//                        'type' => 'inline',
                        'htmlOptions' => array('class' => 'well'),
			'enableAjaxValidation'=>false
		)); ?>

		<?php echo $this->renderPartial('_form', array('form' => $form, 'model'=>$model)); ?>
	<?php $this->endWidget(); ?>
	</div>
</div>


