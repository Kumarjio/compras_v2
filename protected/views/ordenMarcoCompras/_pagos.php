
<?php 
$this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Agregar pago',
        'context' => 'primary',
        'htmlOptions' => array(
            'class' => 'agregar-pago',
            'url' => Yii::app()->createUrl("ordenMarcoCompras/agregarPago", array("id_cot" => $_GET['id_cot']))
        ),
    )
);



if($cotizacion->enviar_cotizacion_a_usuario == 1){ 
	if($cotizacion->elegido_compras != 1) { 
		$this->widget(
		    'booster.widgets.TbButton',
		    array(
		        'label' => 'Deseleccionar',
		        'context' => 'danger',
		        'htmlOptions' => array(
		        	'class' => 'deseleccionar-pago',
		            'url' => Yii::app()->createUrl("ordenMarcoCompras/deseleccionar", array("id" => $cotizacion->id)),
		            'cotizacion'=>$cotizacion->id
		        ),
		    )
		);
			
	} 
}
else{ 
	$this->widget(
	    'booster.widgets.TbButton',
	    array(
	        'label' => 'Seleccionar para envío',
	        'context' => 'success',
	        'htmlOptions' => array(
	        	'class' => 'seleccionar-pago',
	            'url' => Yii::app()->createUrl("ordenMarcoCompras/seleccionarParaEnvio", array("id" => $cotizacion->id)),
	            'cotizacion'=>$cotizacion->id
	        ),
	    )
	);
	
} 


$this->widget('booster.widgets.TbExtendedGridView', array(
	'id'=>'pagos-grid',
    'dataProvider' => $model->search(),
    'filter'=>$model,
    'type'=>'striped bordered',
    'afterAjaxUpdate' => "function(id,data){console.log(id); console.log(data); $('#modalPagos .modal-body').html(data.content);}",
    'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'template' => "{items}",
    'columns' => array(
		array('name' => 'tipo', 'htmlOptions' => array('width' => '83px')),
		array('name' => 'porcentaje', 'htmlOptions' => array('width' => '83px')),
		'observacion',
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template' => '{update}  {delete}',
			'buttons'=>array(
				'update' => array(
					'url'=>'Yii::app()->createUrl("ordenMarcoCompras/actualizarPago", array("id" => $data->id))',
					'options' => array(
						'class' => 'agregar-pago'
					)
				),
				'delete' => array(
					'url'=>'Yii::app()->createUrl("ordenMarcoCompras/deletePago", array("id"=>$data->id, "id_cot"=>$data->id_om_cotizacion))',
					'options'=>array('class'=>'delete-pago')
				),
			),
		),
	),
));