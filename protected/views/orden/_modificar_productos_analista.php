<?php 

$this->widget('booster.widgets.TbGridView',array( 
                'id'=>'orden-solicitud-grid', 
                'dataProvider'=>$model->search($orden->id), 
                //'filter'=>$model_orden_solicitud_costos,
                'type'=>'striped bordered condensed',
                //'htmlOptions' => array('style' => 'width:758px;'),
                'columns'=>array( 
                  array(
                    'name' => 'nombre',
                    'type' => 'raw',
                    'value' => 'CHtml::link($data->nombre, Yii::app()->createUrl("orden/relacionarProductoSolicitud", array("id_orden_solicitud"=>$data->id)), array("class"=>"detalle_producto"))'
                  ),
                  'cantidad',
                  'detalle',
                  array(
                    'name'=>'nombre_producto',
                    'value' => '$data->getNombreProducto()'
                  ),
                  array( 
                    'htmlOptions' => array('nowrap'=>'nowrap', 'class'=>'grid-solicitud-orden'),
                    'class'=>'booster.widgets.TbButtonColumn', 
                    'template' => '{update} {eliminar}',
                    'buttons'=>array(
                      'eliminar' => array(
                        'label'=>'<i class="glyphicon glyphicon-trash"></i>',
                        'url'=>'Yii::app()->createUrl("orden/deleteSolicitud", array("id"=>$data->id))',
                        'options'=>array('class'=>'delete'),
                      ),
                    ),
                    'updateButtonUrl'=>'CController::createUrl("/orden/relacionarProductoSolicitud", array("id_orden_solicitud"=>$data->id, "actualizar_modal" => true))',
                  ), 
                ), 
                )); 
      ?>