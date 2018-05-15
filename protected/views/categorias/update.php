
<div class="x_title">
  <h2>Actualizar Categoria <?php echo $model->nombre; ?></h1>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<div class="row">
</div>
<br>
<div class='col-md-1'>
	<div class="form-actions"> 
		<?php

		$this->widget(
		    'booster.widgets.TbButtonGroup',
		    array(		
		        'size' => 'large',
		        'buttons' => array(array(
		        	'label'=>'Acciones',
		        	'items'=>
				        array(
							array('label'=>'Listar Categorias','url'=>array('admin')),
							array('label'=>'Crear Categorias','url'=>array('create')),
				        ),	
		        	)
		    	)
		    )
		);

		?>
	</div>
</div>
<br>
<br>
<br>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>