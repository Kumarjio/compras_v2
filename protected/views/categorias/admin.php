
<div class="x_title">
  <h2>Categorias</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<div class="row">
</div>


<div class='col-md-1'>
	<div class="form-actions"> 
		<?php

		$this->widget(
		    'booster.widgets.TbButtonGroup',
		    array(		
		        //'size' => 'large',
		        'buttons' => array(array(
		        	'label'=>'Acciones',
		        	'items'=>
				        array(
				        	array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'home'),
							array('label'=>'Crear Categoria','url'=>array('create')),
				        ),	
		        	)
		    	)
		    )
		);

		?>
	</div>
</div>



<div class="col-md-12">
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'categorias-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'nombre',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
</div>