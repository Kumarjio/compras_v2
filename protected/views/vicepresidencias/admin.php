
<div class="x_title">

	<div class="row">
		<div class="col-md-6">
			<h1>Vicepresidencias</h1>
			
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
			'id'=>'vicepresidencias-grid',
			'dataProvider'=>$model->search(),
			'type'=>'striped bordered condensed',
			'filter'=>$model,
			'columns'=>array(
				'id',
				'nombre',
				'atribuciones',
				array(
					'class'=>'booster.widgets.TbButtonColumn',
					'template'=>'{view}  {update}'
				),
			),
		)); ?>

		</div>
	</div>
</div>
