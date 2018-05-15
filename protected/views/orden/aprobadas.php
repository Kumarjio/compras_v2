<?php
$this->breadcrumbs=array(
	'Solicitudes Aprobadas'
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

$this->menu=array(
	array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
	array('label'=>'Home','url'=>array('admin'), 'icon'=>'home'),
	array('label'=>'Administrativo ('.$administrativo_no.')','url'=>array('/VinculacionProveedorAdministrativo/admin'), 'visible' => $administrativo),
	array('label'=>'Juridico ('.$juridico_no.')','url'=>array('/VinculacionProveedorJuridico/admin'), 'visible' => $juridico),
	array('label'=>'Willies ('.$willies_no.')','url'=>array('/Willies/admin'), 'visible' => $willies),
	
);


?>

<h2>Solicitudes de Compra Aprobadas</h2>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'orden-asignadas-grid',
	'dataProvider'=>$model->search_aprobadas(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'rowCssClassExpression' => '($data->paso_wf == "swOrden/aprobado_por_comite" or $data->paso_wf == "swOrden/aprobado_por_presidencia")?"aprobado":""',
	'columns'=>array(
		array(
		      'header' => 'Número de solicitud',
		      'name' => 'id',
		      'type' => 'raw',
		      //'value' => '"<a href=\"update/id/".$data->id."\">".$data->id."</a>"',
		      'value' => 'CHtml::link(($data->id >= 500000000)?"No Asignado":$data->id, Yii::app()->createUrl("orden/print", array("orden"=>$data->id)))'
		      ),
		array(
			'header'=>'Tipo Compra',
			'name' => 'tipo_compra',
			'filter' => CHtml::listData(TipoCompra::model()->findAll(), "id", "nombre"),
			'value' => '($data->tipo_compra != "")? $data->tipoCompra->nombre :""'
		),
		'nombre_compra',
		//'resumen_breve',
		array(
			'header'=>'Jefatura',
			'name' => 'id_jefatura',
			'filter' => CHtml::listData(Jefaturas::model()->findAll(), "id", "nombre"),
			'value' => '($data->id_jefatura != "")? $data->idJefatura->nombre :""'
		),
		array(
			'header'=>'Usuario Solicitante',
			'name' => 'nombre_usuario_search',
			'value' => '$data->idUsuario->nombre_completo'
		),
		array(
		    'header'=>'Estado Actual',
		    'name'=>'paso_wf',
		    'filter'=>SWHelper::allStatuslistData($model),
		    'value'=>'Orden::model()->labalEstado($data->paso_wf)'
		),
        array('header' => "Fecha del Último Estado", 'value' => '$data->getLastDate()'),
	),
)); ?>


