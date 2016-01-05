<?php
$this->breadcrumbs=array(
	'Pacientes'=>array('admin'),
	'Cita',
);
$this->setPageTitle('Solicite su cita');

?>
<?php if ($mens!=""){ ?>
	<div class="alert alert-success fade in">
	<strong>Muy Bien! </strong>
	<?php echo $mens;  ?>
	</div>
	
<?php }
?>
<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Información del Paciente</h3>
    </div>
    <div class="panel-body">

		<?php $form=$this->beginWidget('CActiveForm',array(
			'id'=>'paciente-form',
			'enableAjaxValidation'=>false
		)); ?>
		
		<?php echo $this->renderPartial('_form', array('form' => $form, 'model'=>$model)); ?>
	<?php $this->endWidget(); ?>
	</div>
</div>


