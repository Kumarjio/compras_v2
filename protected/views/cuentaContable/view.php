
  <div class="x_title">

    <div class="row">
      <div class="col-md-6">
        <h1>Cuentas Contables</h1>
        
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
							  	array('label'=>'Editar','url'=>array('update','id'=>$model->id),'icon'=>'fa fa-edit'),
							  	array('label'=>'Eliminar','url'=>'#','icon'=>'fa fa-trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Está seguro que desea eliminar este registro?')),
							  	array('label'=>'Home','url'=>array('admin'),'icon'=>'fa fa-folder-open'),

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
		<?php $this->widget('bootstrap.widgets.BootDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				'codigo',
				'nombre',
			),
		)); ?>
      </div>
    </div>
  </div>






