<div id="content">

<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'orden-compra-grid',
	'dataProvider'=>$dataProvider,
	'type'=>'striped bordered condensed',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'columns'=>array(
		//'id',
		array('header' => 'Solicitud', 'value' => '$data->id_orden'),
		array('header' => 'NIT', 'value' => '$data->getNit()'),
		array('header' => 'Razon Social', 'value' => '$data->getRazonSocial()'),
		array('header' => 'Usuario', 'value' => '$data->usuario->nombre_completo'),
		array('header' => 'Fecha', 'value' => '$data->creacion'),
		//'id_usuario',
		//'creacion',
		//'id_orden',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{view}{imprimir}',
			'buttons'=>array
			    (
					'view' => array
			        (
						'url' => '"/index.php/DetalleOrdenCompra/detalleOrden/id_orden_compra/".$data->id'
			        ),
                    'imprimir' => array('url' => '"/index.php/OrdenCompra/print?id=".$data->id', 'icon' => 'print'),
			    ),
		),
	),
)); ?>

</div>