

<div class="x_title">

	<div class="row">
		<div class="col-md-6">
			<h1>Jefaturas</h1>
			
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
			'id'=>'jefaturas-grid',
			'dataProvider'=>$model->search(),
			'type'=>'striped bordered condensed',
			'filter'=>$model,
			'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
			'columns'=>array(
				'nombre',
				array('name'=>'gerencia_search', 'value'=> '$data->gerencia->nombre'),
				array(
					'name'=>'id_vice',
					'value'=>'$data->idVice->nombre'
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
