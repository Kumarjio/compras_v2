
<h2>Solicitudes de Compra Asignadas</h2>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'orden-asignadas-grid',
	'dataProvider'=>$model_asignadas->search_asignadas(),
	'type' => 'striped',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'filter'=>$model_asignadas,
	'rowCssClassExpression' => '($data->paso_wf == "swOrden/aprobado_por_comite" or $data->paso_wf == "swOrden/aprobado_por_presidencia" or $data->paso_wf == "swOrden/aprobado_por_atribuciones")?"aprobado":""',
	'columns'=>array(
		array(
		      'header' => 'Número de solicitud',
		      'name' => 'id',
		      'type' => 'raw',
		      //'value' => '"<a href=\"update/id/".$data->id."\">".$data->id."</a>"',
		      'value' => 'CHtml::link(($data->id >= 500000000)?"No Asignado":$data->id, Yii::app()->createUrl("orden/update", array("id"=>$data->id)))'
		      ),
		array(
			'header'=>'Tipo Compra',
			'name' => 'tipo_compra',
			'type' => 'raw',
			'filter' => CHtml::listData(TipoCompra::model()->findAll(), "id", "nombre"),
			'value' => '($data->tipo_compra != "")? $data->tipoCompra->nombre.Orden::model()->tipoNegociacionSpan($data->negociacion_directa) :""'
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
		    'filter'=>SWHelper::allStatuslistData($model_asignadas),
		    'value'=>'Orden::model()->labalEstado($data->paso_wf)'
		),
        array('header' => "Fecha del Último Estado", 'value' => '$data->getLastDate()'),
		
		/*
		'id_jefatura',
		'fecha_solicitud',
		'id_gerente',
		'id_jefe',
		'id_usuario',
		'centro_costos',
		'cuenta_contable',
		'estado',
		'valor_presupuestado',
		'mes_presupuestado',
		'detalle',
		'fecha_entrega',
		'direccion_entrega',
		'responsable',
		'requiere_acuerdo_servicios',
		'requiere_polizas_cumplimiento',
		'validacion_usuario',
		'validacion_jefe',
		'validacion_gerente',
		'paso_wf',
		*/
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template' => '{delete}',
			'buttons' => array(
					   'delete' => array(
							     'visible' => '$data->paso_wf == "swOrden/llenaroc"'
							     )
					   )
		),
	),
)); ?>


<h2>Solicitudes de Compra Solicitadas</h2>

<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'orden-solicitadas-grid',
	'dataProvider'=>$model_solicitadas->search_solicitadas(),
	'type'=>'striped bordered condensed',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'filter'=>$model_solicitadas,
	'columns'=>array(
			 array(
			       'header' => 'Número de solicitud',
			       'name' => 'id',
			       'type' => 'raw',
			       //'value' => '"<a href=\"update/id/".$data->id."\">".$data->id."</a>"',
			       'value' => 'CHtml::link($data->id, Yii::app()->createUrl("orden/readonly", array("orden"=>$data->id)))'
			       ),


		array(
			'header'=>'Tipo Compra',
			'name' => 'tipo_compra',
			'type' => 'raw',
			'filter' => CHtml::listData(TipoCompra::model()->findAll(), "id", "nombre"),
			'value' => '($data->tipo_compra != "")? $data->tipoCompra->nombre.Orden::model()->tipoNegociacionSpan($data->negociacion_directa) :""'
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
			'header'=>'Usuario Actual',
			'name' => 'nombre_usuario_search',
			'value' => '$data->id_usuario_actual->nombre_completo'
		),
		array(
		    'header'=>'Estado Actual',
		    'name'=>'paso_wf',
		    'filter'=>SWHelper::allStatuslistData($model_asignadas),
		    'value'=>'Orden::model()->labalEstado($data->paso_wf)'
		),
		/*
		'id_jefatura',
		'fecha_solicitud',
		'id_gerente',
		'id_jefe',
		'id_usuario',
		'centro_costos',
		'cuenta_contable',
		'estado',
		'valor_presupuestado',
		'mes_presupuestado',
		'detalle',
		'fecha_entrega',
		'direccion_entrega',
		'responsable',
		'requiere_acuerdo_servicios',
		'requiere_polizas_cumplimiento',
		'validacion_usuario',
		'validacion_jefe',
		'validacion_gerente',
		'paso_wf',
		*/
		/*
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
		*/
	),
)); ?>

