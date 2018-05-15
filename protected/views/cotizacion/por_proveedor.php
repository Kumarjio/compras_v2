<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'cotizacion-todas-grid',
	'dataProvider'=>$model->search_proveedor($prodord, $nit, $excluir),
	'type'=>'striped bordered condensed',
	'selectableRows' => 0,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'filter'=>$model,
	'columns'=>array(
		'nit',
		'cantidad',
		array(
			'name' => 'valor_unitario',
			'value' => '"$".number_format($data->valor_unitario)'
		),
		array(
			'name' => 'total_compra',
			'value' => '"$".number_format($data->total_compra)'
		),
		'descripcion',
		/*
		'descripcion',
		'elegido_compras',
		'elegido_usuario',
		*/
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{usuario}{upload}{actualizar}{borrar}',
			'htmlOptions' => array(
							'style'=>'width:70px'
						),
			'buttons' => array(
				
				'upload' => array(
					'url' => 'Cotizacion::model()->urlGrid("subir",$data->id)',
					'icon' => 'file',
					'options' => array(
						'class' => 'upload-cot' 
					)
				),
				'usuario' => array(
					'url' => 'Cotizacion::model()->urlEnviarUsuario($data->producto_orden,$data->id)',
					'icon' => 'ok',
					'options' => array(
						'class' => 'enviar-usuario-cot' 
					)
				),
				'actualizar' => array(
					'url' => 'Cotizacion::model()->urlGrid("update",$data->id)',
					'icon' => 'pencil',
					'options' => array(
						'class' => 'update-cot' 
					)
				),
				'borrar' => array(
					'url' => 'Cotizacion::model()->urlGrid("delete",$data->id)',
					'icon' => 'trash',
					'options' => array(
						'class' => 'delete-cot' 
					)
				)
			)
		),
	),
)); ?>

<script type="text/javascript">
$(".delete-cot").click(function(e, obj){
	e.preventDefault();
	var conf = confirm("Está seguro de eliminar este registro?");
	if(conf){
		jQuery.ajax({
        url :$(this).attr("href"),
        type :'post',
        success : function(){
          $('#cotizacion-todas-grid').yiiGridView.update('cotizacion-todas-grid'); 
        },
        error : function(){
          alerrt("No se pudo eliminar el registro");
        }
      });
	}

});

$(".enviar-usuario-cot").click(function(e, obj){
	e.preventDefault();
	
	jQuery.ajax({
	    url :$(this).attr("href"),
	    type :'post',
	    dataType : 'json',
	    success : function(res){
	      if(res.status = "ok"){
	      	$('#'+res.grid).yiiGridView.update(res.grid); 
	      	$("#genericModal").modal('hide');
	      }else{
	      	alert("No se pudo completar la operación");
	      }
	      
	    },
	   
	});
	

});


</script>