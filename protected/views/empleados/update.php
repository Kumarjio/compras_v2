<?php
$this->breadcrumbs=array(
	'Empleados'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);


$this->widget(
        'booster.widgets.TbButtonGroup',
        array(    
            'size' => 'large',
            'buttons' => array(array(
              'label'=>'Acciones',
              'items'=>
                array(
          					array('label'=>'Crear','url'=>array('create'), 'icon'=>'fa fa-plus'),
        				  	array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'fa fa-edit'),
        				  	array('label'=>'Eliminar','url'=>'#','icon'=>'fa fa-trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
                  	array('label'=>'Listar Empleados','url'=>array('admin'), 'icon'=>'fa fa-folder-open'),
                ),  
              )
          )
        )
    );


?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>