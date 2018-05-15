<a href='/index.php/cotizacionRegalos/create/id_cot/<?php echo $cotizacion->id ?>' class="btn btn-primary agregar-regalo">Agregar Regalo</a>

<div class="well" style="margin-top:15px;">
<?php 

$this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'cotizacion-regalos-grid',
	'dataProvider'=>$model->search($cotizacion->id),
	'type'=>'striped bordered condensed',
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'filter'=>$model,
	'columns'=>array(
                     'descripcion',
                     array(
	    				'header' => 'Valor Unitario',
						'value' => 'str_replace(".000","","$".number_format($data->valor, 3))'
                     ),        

		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{update}{delete}',
			'buttons'=>array(
				'update' => array(
					'url'=>'Yii::app()->createUrl("cotizacionRegalos/update", array("id" => $data->id))',
					'options' => array(
						'class' => 'agregar-pago'
					)
				),
				'delete' => array(
					'url'=>'Yii::app()->createUrl("cotizacionRegalos/delete", array("id"=>$data->id))',
					'options'=>array('class'=>'delete')
				),
			),
              )
	),
)); 
   ?>
</div>
