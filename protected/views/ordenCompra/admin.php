<?php
$this->breadcrumbs=array(
	'Ordenes de Compra'
);

$this->menu=array(
	array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
);

?>

	<div class="panel panel-default">
		 <div class="panel-heading" align="center"><big><strong class="gris">Ordenes de compra de la solicitud: <?php echo $id_orden; ?></strong></big></div>
		 <div class="panel-body">

			<?php $this->widget('booster.widgets.TbGridView',array(
				'id'=>'orden-compra-grid',
				'dataProvider'=>$model->search($id_orden),
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
						'class'=>'booster.widgets.TbButtonColumn',
						'template' => '{vista}   {imprimir}',
						'buttons'=>array
						    (
								'vista' => array
						        (
						        	'label' => false,
						        	'icon' => 'eye-open',
									'url' => 'Yii::app()->createUrl("DetalleOrdenCompraOp/detalleOrden", array("id_orden_compra"=>$data->id))' 
						        ),
			                    'imprimir' => array('url' => '"/index.php/OrdenCompra/print?id=".$data->id', 'icon' => 'print'),
						    ),
					),
				),
			)); ?>
	</div>
</div>