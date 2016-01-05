<?php
$this->breadcrumbs=array(
	'Citas'=>array('admin'),
	'Crear',
);
$this->setPageTitle('Creación de Cita');
$cs = Yii::app()->clientScript;
//$cs->scriptMap['select2.min.js'] = false;
?>

<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Información Paciente</h3>
    </div>
    <div class="panel-body">


<?php

$this->widget(
//        'bootstrap.widgets.BootDetailView',
    'booster.widgets.TbEditableDetailView',
    array(
        'data' => $paciente,
        'url'=> $this->createUrl('/paciente/paciente/updateEditable'),
        'attributes' => array(
            'nombre',
            'cedula',
            'celular',
            'telefono',
            'correo',
            'nombre_acompanante',
            'celular_acompanante',
            array(
                'name' => 'id_eps',
                'otros'=>array(
                    'type' => 'select',
                    'source' => CHtml::listData(Eps::model()->findAll(), 'id_eps', 'nombre'),
                    'value'=>$paciente->id_eps,
                    'title'=>'Seleccione Eps',
                    'htmlOptions'=>array(
                        'prompt'=>'Seleccione eps'
                    )
                )
                
            ),
//            array('name' => 'nombre'),
//            array('name' => 'lastName', 'label' => 'Last name'),
//            array('name' => 'language', 'label' => 'Language'),
        ),
        'success' => 'js: function(response, newValue) {
            obj = JSON.parse(response);
            if (!obj.success){  
                return obj.msg;
            }
          }',
        'emptytext'=>'___',
    )
);


?>


	</div>
</div>
<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Citas Programadas</h3>
    </div>
    <div class="panel-body">
        <?php 
        $this->renderPartial("grid", array('model' => new Cita('search'),'id_paciente' => $paciente->id_paciente));
        ?>
	</div>
</div>
<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Informarción del Cita</h3>
    </div>
    <div class="panel-body">

		<?php $form=$this->beginWidget('CActiveForm',array(
			'id'=>'cita-form',
			'enableAjaxValidation'=>false
		)); ?>

		<?php echo $this->renderPartial('_form', array(
                                'form' => $form, 
                                'model'=>$model,
                                'paciente'=>$paciente,
                                'disponibilidad'=>$disponibilidad
                        )); ?>
	<?php $this->endWidget(); ?>
	</div>
</div>

