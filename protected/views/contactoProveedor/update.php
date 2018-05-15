

<div class="x_title">

    <div class="row">
      	<div class="col-md-6">
        	<h1>NIT: <?php echo $model->nit; ?></h1>
        
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
	                              	array('label'=>'Crear','url'=>array('create', 'id_proveedor' => $model->nit), 'icon'=>'fa fa-plus'),
	        				  		array('label'=>'Eliminar','url'=>'#','icon'=>'fa fa-trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
	                  				array('label'=>'Home','url'=>array('/Orden/admin'), 'icon'=>'fa fa-bank'),
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
       
        	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
      	</div>
    </div>
</div>






