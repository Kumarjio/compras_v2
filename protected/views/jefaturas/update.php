<?php
$this->breadcrumbs=array(
	'Jefaturas'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);


$this->menu=array(
  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
  array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'edit'),
  //array('label'=>'Eliminar','url'=>'#','icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
  array('label'=>'Listar','url'=>array('admin'),'icon'=>'home'),
);

?>





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
	                  				array('label'=>'Listar Productos','url'=>array('admin'), 'icon'=>'fa fa-folder-open'),
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
       
			<?php echo $this->renderPartial('_form',array('model'=>$model,'gerencias'=>$gerencias)); ?>
      	</div>
    </div>
</div>






