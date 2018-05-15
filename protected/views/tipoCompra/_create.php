
  <div class="x_title">

    <div class="row">
      <div class="col-md-6">
        <h1>Nuevo Tipo Compra</h1>
        
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
                      			array('label'=>'Crear Nuevo Negociador','url'=>array('create'), 'icon'=>'fa fa-plus'),
                          		array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'fa fa-bank'),
                              	array('label'=>'Regresar','url'=>array('admin'), 'icon'=>'fa fa-folder-open'),
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
       
        <?php echo $this->renderPartial('_form2', array('model'=>$model)); ?>
      </div>
    </div>
  </div>


