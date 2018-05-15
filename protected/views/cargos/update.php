


<div class="x_title">

    <div class="row">
      	<div class="col-md-6">
        	<h1>Productos</h1>
        
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
	                              	array('label'=>'Crear','url'=>array('create'), 'icon'=>'fa fa-plus'),
	                  				array('label'=>'Listar','url'=>array('admin'), 'icon'=>'fa fa-folder-open'),
	                          ),  
	                        )
	                    )
	                  )
	              );
	         	?>
        	</div>
      	</div>
    </div>
	<div class="clearfix"></div>
</div>
<div class="x_content">
    <div class="row">
      	<div class="col-md-12">
		       
		<?php echo $this->renderPartial('_form',
			array(
				'model'=>$model,
				'gerencias'=>$gerencias,
				'jefaturas'=>$jefaturas
			)); ?>
      	</div>
    </div>
</div>






