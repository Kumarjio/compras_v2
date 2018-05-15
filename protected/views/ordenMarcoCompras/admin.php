
<div class="x_title">
  <h2>Solicitudes de Compra Marco Asignadas</h2>
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
							//array('label'=>'Solicitar Productos','url'=>array('pedidoMacro'), 'icon'=>'plus-sign'),
							array('label'=>'Crear Orden Marco','url'=>array('create'), 'icon'=>'plus-sign'),
							array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
							
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


<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'orden-marco-asignadas-grid',
	'dataProvider'=>$model->search(),
	'type' => 'striped',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'filter'=>$model,
	//'rowCssClassExpression' => '($data->paso_wf == "swOrden/aprobado_por_comite" or $data->paso_wf == "swOrden/aprobado_por_presidencia" or $data->paso_wf == "swOrden/aprobado_por_atribuciones")?"aprobado":""',
	'columns'=>array(
		array(
		      'header' => 'Número de solicitud',
		      'name' => 'id',
		      'type' => 'raw',
		      //'value' => '"<a href=\"update/id/".$data->id."\">".$data->id."</a>"',
		      'value' => 'CHtml::link(($data->id >= 600000000)?"No Asignado":$data->id, Yii::app()->createUrl("ordenMarcoCompras/update", array("id"=>$data->id)))'
      	),
		'nombre_compra',
		//'resumen_breve',
		array(
			'header'=>'Usuario Solicitante',
			'name' => 'nombre_usuario_search',
			'value' => '$data->idUsuario->nombre_completo'
		),
		array(
		    'header'=>'Estado Actual',
		    'name'=>'paso_wf',
		    'filter'=>SWHelper::allStatuslistData($model),
		    'value'=>'OrdenMarcoCompras::model()->labelEstado($data->paso_wf)'
		),
        array('header' => "Fecha del Último Estado", 'value' => '$data->getLastDate()'),
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template' => '{delete} {update}',
			'buttons' => array(
			   'delete' => array(
                  	'label' => false,
					'visible' => '$data->paso_wf == "swOrdenMarcoCompras/llenarocm"'
			    ),
				'update'=>array(
                  'label' => false,
				)
		   	),
		),
	),
)); ?>
<br>
<br>

<div class="x_title">
  <h2>Solicitudes de Compra Marco Aprobadas</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<div class="row">
</div>
<br>
<br>



<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'orden-marco-aprobadas-grid',
	'dataProvider'=>$model_disponibles->search(),
	'type' => 'striped',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'filter'=>$model_disponibles,
	//'rowCssClassExpression' => '($data->paso_wf == "swOrden/aprobado_por_comite" or $data->paso_wf == "swOrden/aprobado_por_presidencia" or $data->paso_wf == "swOrden/aprobado_por_atribuciones")?"aprobado":""',
	'columns'=>array(
		array(
			'name'=>'id_marco',
			'header'=>'Solicitud'
		),
		array(
			'name'=>'producto',
			'value'=>'Producto::model()->findByPk($data->producto)->nombre'
		),
		//'nit',
		array(
			'name'=>'nit',
			'header'=>'Proveedor',
			'value'=>'Proveedor::model()->findByPk($data->nit)->razon_social'
		),
		'forma_negociacion',
		array(
			'name'=>'cant_valor',
            'htmlOptions' => array ('style' => 'text-align: right;' ),
			'header'=>'Cantidad Solicitada',
			'value'=>'($data->forma_negociacion == \'valor\') ? \'$\'. Yii::app()->format->formatNumber($data->cant_valor) : Yii::app()->format->formatNumber($data->cant_valor)'
		),
		array(
			'name'=>'disponible',
            'htmlOptions' => array ('style' => 'text-align: right;' ),
            'value'=>'($data->forma_negociacion == \'valor\') ? \'$\'. Yii::app()->format->formatNumber($data->disponible) : Yii::app()->format->formatNumber($data->disponible)'
		),
	),
)); ?>