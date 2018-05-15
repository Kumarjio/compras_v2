<a href='/index.php/cotizacionPago/create/id_cot/<?php echo $cotizacion->id ?>' class="btn btn-primary agregar-pago">Agregar Pago</a>
<?php if($cotizacion->enviar_cotizacion_a_usuario == 1){ if($cotizacion->elegido_compras != 1) { ?><a href='/index.php/cotizacion/deseleccionar/id/<?php echo $cotizacion->id ?>' class="btn btn-danger" onClick='jQuery.ajax({"url":"/index.php/cotizacion/deseleccionar/id/<?php echo $cotizacion->id; ?>","type":"post","dataType":"json","success":function(data){
        if (data.status == "success"){
			$("#genericModal").modal("hide");
			$("#cotizacion-grid_<?php echo $cotizacion->producto_orden; ?>").yiiGridView.update("cotizacion-grid_<?php echo $cotizacion->producto_orden; ?>");
        }else{
            $("#genericModal .mensaje-agregar-usuario").remove();
			var content = "<div class=\"alert alert-error fade in mensaje-agregar-usuario\" style=\"display:none\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>"+data.status+"</div>";
			$("#genericModal #modal-content").prepend(content);
			$("#genericModal #modal-content .mensaje-agregar-usuario").slideDown();
	        $("#genericModal").modal("show");
        }

    } ,"cache":false
}); 
	return false;
	
	'>Deseleccionar cotización</a><?php } }else{ ?><a href='/index.php/cotizacion/seleccionarParaEnvio/id/<?php echo $cotizacion->id ?>' class="btn btn-success" onClick='jQuery.ajax({"url":"/index.php/cotizacion/SeleccionarParaEnvio/id/<?php echo $cotizacion->id; ?>","type":"post","dataType":"json","success":function(data){
	        if (data.status == "success"){
				$("#genericModal").modal("hide");
				$("#cotizacion-grid_<?php echo $cotizacion->producto_orden; ?>").yiiGridView.update("cotizacion-grid_<?php echo $cotizacion->producto_orden; ?>");
	        }else{
	            $("#genericModal .mensaje-agregar-usuario").remove();
				var content = "<div class=\"alert alert-error fade in mensaje-agregar-usuario\" style=\"display:none\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>"+data.status+"</div>";
				$("#genericModal #modal-content").prepend(content);
				$("#genericModal #modal-content .mensaje-agregar-usuario").slideDown();
		        $("#genericModal").modal("show");
	        }

	    } ,"cache":false
	}); 
		return false;

		'>Seleccionar para envío</a><?php } ?>
<div class="well" style="margin-top:15px;">
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'cotizacion-pago-grid',
	'dataProvider'=>$model->search($cotizacion->id),
	'type'=>'striped bordered condensed',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'filter'=>$model,
	'columns'=>array(
		array('name' => 'tipo', 'htmlOptions' => array('width' => '83px')),
		array('name' => 'porcentaje', 'htmlOptions' => array('width' => '83px')),
		'observacion',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{update}{delete}',
			'buttons'=>array(
				'update' => array(
					'url'=>'Yii::app()->createUrl("cotizacionPago/update", array("id" => $data->id))',
					'options' => array(
						'class' => 'agregar-pago'
					)
				),
				'delete' => array(
					'url'=>'Yii::app()->createUrl("cotizacionPago/delete", array("id"=>$data->id))',
					'options'=>array('class'=>'delete')
				),
			),
		),
	),
)); ?>
</div>
