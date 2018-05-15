<?php
	

$this->widget(
        'booster.widgets.TbButtonGroup',
        array(    
            'size' => 'large',
            'buttons' => array(array(
              'label'=>'Acciones',
              'items'=>
                array(
                  	array('label'=>'Listar Empleados','url'=>array('admin'), 'icon'=>'fa fa-folder-open'),
  					array('label'=>'Crear','url'=>array('create'), 'icon'=>'fa fa-book'),
                ),  
              )
          )
        )
    );
?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>