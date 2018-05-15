<?php
$this->breadcrumbs=array(
	'Orden'
);
$administrativo = false;
$administrativo_no = 0;
$a = AdministracionUsuario::model()->findByAttributes(array('id_usuario' => Yii::app()->user->id_empleado, 'tipo_usuario' => 'Administrativo'));
if($a != null){
	$administrativo_no = count(VinculacionProveedorAdministrativo::model()->findAllByAttributes(array('usuario_actual' => Yii::app()->user->id_empleado)));
	$administrativo = true;
}
$juridico = false;
$juridico_no = 0;
$b = AdministracionUsuario::model()->findByAttributes(array('id_usuario' => Yii::app()->user->id_empleado, 'tipo_usuario' => 'Juridico'));
if($b != null){
	$juridico_no = count(VinculacionProveedorJuridico::model()->findAllByAttributes(array('usuario_actual' => Yii::app()->user->id_empleado)));
	$juridico = true;
}

$willies = false;
$willies_no = 0;
$c = AdministracionUsuario::model()->findByAttributes(array('id_usuario' => Yii::app()->user->id_empleado, 'tipo_usuario' => 'Willies'));
if($c != null){
	$willies_no = count(Willies::model()->findAllByAttributes(array('usuario_actual' => Yii::app()->user->id_empleado)));
	$willies = true;
}
?>

<div class="x_title">
  <h2>Solicitudes de Compra</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<div class="row">
</div>
<br>

<div class='col-md-1'>
	<div class="form-actions"> 
		<?php

		$this->widget(
		    'booster.widgets.TbButtonGroup',
		    array(		
		        'size' => 'large',
		        'buttons' => array(array(
		        	'label'=>'Acciones',
		        	'items'=>
				        array(
							array('label'=>'Solicitar Productos','url'=>array('pedidoMacro'), 'icon'=>'plus-sign'),
							array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
							array('label'=>'Home','url'=>array('admin'), 'icon'=>'home'),
							array('label'=>'Administrativo ('.$administrativo_no.')','url'=>array('/VinculacionProveedorAdministrativo/admin'), 'visible' => $administrativo),
							array('label'=>'Juridico ('.$juridico_no.')','url'=>array('/VinculacionProveedorJuridico/admin'), 'visible' => $juridico),
							array('label'=>'Willis ('.$willies_no.')','url'=>array('/Willies/admin'), 'visible' => $willies),
							array('label'=>'Anteriores y Finalizadas','url'=>array('anteriores')),
						    array('label'=>'Aprobadas','url'=>array('aprobadas'), 'visible' => in_array('CYC307',(Yii::app()->user->permisos))),
						    array('label'=>'Comité','url'=>array('Comite'), 'visible' => in_array('CYC995',(Yii::app()->user->permisos))),
						    //array('label'=>'Todas','url'=>array('todas')),
							array('label'=>'Todas','url'=>array('todas'), 'visible'=>array_intersect( array('CYC992','CYC993','CYC994', 'CYC995','CYC996','CYC312'), Yii::app()->user->permisos )),
							array('label'=>'Todas Área','url'=>array('todasArea'), 'visible'=>array_intersect( array('CYC503'), Yii::app()->user->permisos ))
				        ),	
		        	)
		    	)
		    )
		);

		?>
	</div>
</div>
<br>
<br>

<br>

<br>



<?php echo $this->renderPartial($partial, array('model_asignadas' => $model_asignadas, 'model_solicitadas' => $model_solicitadas)); ?>

