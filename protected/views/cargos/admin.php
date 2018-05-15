<div class="x_title">

	<div class="row">
		<div class="col-md-6">
			<h1>Proveedores</h1>
			
		</div>
		<div class="col-md-6">
			
			<div align="right">
				
				<?php

				$this->widget(
				    'booster.widgets.TbButtonGroup',
				    array(    
				        'size' => 'large',
				        'buttons' => array(array(
				          'label'=>'Acciones',
				          'items'=>
				            array(
								array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'fa fa-bank'),
								array('label'=>'Crear','url'=>array('create'), 'icon'=>'fa fa-plus'),
				            ),  
				          )
				      )
				    )
				);
				?>
			</div>
		</div>
	</div>
</div>
<div class="x_content">
	<div class="row">
		<div class="col-md-12">
			
			<?php $this->widget('booster.widgets.TbGridView',array(
				'id'=>'cargos-grid',
				'dataProvider'=>$model->search(),
				'type'=>'striped bordered condensed',
				'filter'=>$model,
				'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
				'columns'=>array(
					'nombre',
					array(
						'name'=>'id_jefatura',
						'value'=>'$data->idJefatura->nombre'
					),
					array(
						'name'=>'id_gerencia',
						'value'=>'$data->idGerencia->nombre'
					),
					array(
						'name'=>'id_vice',
						'value'=>'$data->idVice->nombre'
					),
					array(
						'name'=>'es_jefe',
						'type'=>'raw',
						'value'=>'($data->es_jefe == "Si")?CHtml::tag("a",array("class"=>"icon-ok")): ""',
						'filter'=>array("1"=>"No", "Si"=>"Si"),
						'htmlOptions'=>array(
							'style' =>'	text-align: center;
										vertical-align: middle;
									    width: 8%;',
						)
					),
					array(
						'name'=>'es_gerente',
						'type'=>'raw',
						'value'=>'($data->es_gerente == "Si")?CHtml::tag("a",array("class"=>"icon-ok")): ""',
						'filter'=>array("1"=>"No", "Si"=>"Si"),
						'htmlOptions'=>array(
							'style' =>'	text-align: center;
										vertical-align: middle;
									    width: 8%;',
						)
					),
					array(
						'name'=>'es_vice',
						'type'=>'raw',
						'value'=>'($data->es_vice == "Si")?CHtml::tag("a",array("class"=>"icon-ok")): ""',
						'filter'=>array("1"=>"No", "Si"=>"Si"),
						'htmlOptions'=>array(
							'style' =>'	text-align: center;
										vertical-align: middle;
									    width: 8%;',
						)
					),
					array(
						'class'=>'booster.widgets.TbButtonColumn',
						'template'=>'{view} {update}'
					),
				),
			)); ?>
		</div>
	</div>
</div>
