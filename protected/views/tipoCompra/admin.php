
<div class="x_title">

	<div class="row">
		<div class="col-md-6">
			<h1>Tipos de Compras</h1>
			
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
								array('label'=>'Crear Tipo de Compra', 'url'=>array('agregar'), 'icon'=>'fa fa-plus'),
								array('label'=>'Agregar Nuevo Negociador','url'=>array('create'), 'icon'=>'fa fa-user'),
								array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'fa fa-bank'),

				            ),  
				          )
				      )
				    )
				);
				?>
			</div>
		</div>
	</div>


      <h2></h2>
    
    <div class="clearfix"></div>
</div>
<div class="x_content">
	<div class="row">
		<div class="col-md-12">
			
			<?php $this->widget('booster.widgets.TbGridView', array(
				'id'=>'tipo-compra-grid',
				'dataProvider'=>$model->search_2(),
				'type'=>'striped bordered condensed',
				'filter'=>$model,
				'columns'=>array(
					'nombre',
					array('name'=>'responsable','value'=>'ucwords(strtolower($data->responsable0->nombre_completo))'),
					array(
						//'header'=>'Opción',
						'class'=>'booster.widgets.TbButtonColumn',
						'template'=>'{update}',
					),
				),
			)); ?>
		</div>
	</div>
</div>
