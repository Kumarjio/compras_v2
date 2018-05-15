<div class='col-md-13'>
  <?php
  $criteria = new CDbCriteria;
  if($model->id_categoria != "")
    $criteria->compare('id_categoria',$model->id_categoria);
  $criteria->order = 'nombre';
  
  //$criteria->compare('activo','Si');
  //$lista = CHtml::listData(FamiliaProducto::model()->findAll($criteria), 'id', 'nombre');

  $this->widget('booster.widgets.TbGridView',array(
    'id'=>'trazabilidad-grid',
    'dataProvider'=>$model->search(),
    //'template' => "{items}",
    'filter' => $model,
    'type' => 'striped bordered condensed',
    'responsiveTable' => true,
    'columns'=>array(
        //'id_categoria',
        //'categoria',
        array(
          'name'=>'categoria',
          'filter'=>CHtml::activeDropDownList($model, 'id_categoria', CHtml::listData(Categorias::model()->findAll(), 'id', 'nombre'), array('class'=>'form-control', 'prompt'=>''
         ))
        ),
        array(
          'name'=>'subcategoria',
          'filter'=>CHtml::activeDropDownList($model, 'id_subcategoria', CHtml::listData(FamiliaProducto::model()->findAll($criteria), 'id', 'nombre'), array('class'=>'form-control', 'prompt'=>'')),
        ),
        'producto',
        'cant_disponible',
        array(
        'header'=>'Gestionar',
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{gestion} ',
        'buttons' => array(
          'gestion' => array(
              'label'=>'Seleccionar',
              'url'=>'CJSON::encode($data)',
              //'icon'=>'glyphicon glyphicon-ok',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok.png',
              //'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario',
              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
              'click'=> 'js:function(){return gestion(this);}',
          ),
        )
      ),    
    ),
  )); 


$this->widget(
    'booster.widgets.TbGridView',
    array(
        'type' => 'striped',
        'id'=>'solpe_grid',
        'dataProvider' => $Mgrid->search(),
        'template' => "{items}",
        'columns' => array(
            array(
              'name'=>'id_producto',
              'value'=>'$data->idProducto->nombre'
            ),
            array(
              'name'=>'id_proveedor',
              'value'=>'$data->idProveedor->razon_social'
            ),
            'cantidad' ,
            'observacion',
            array(
              'htmlOptions' => array('nowrap'=>'nowrap'),
              'class'=>'booster.widgets.TbButtonColumn',
              'template'=>'{delete}',
              'deleteButtonUrl'=>"Yii::app()->createUrl('orden/deleteDetPed', array('id'=>".'$data->id'."))",
            )
        ),
    )
);


  ?>
</div> 
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'orden_pedido')
); ?>
 
    <div class="modal-header" id="op-modal-header">
        <!--a class="close" data-dismiss="modal">&times;</a-->
        <h4>Modal header</h4>
    </div>
 
    <div class="modal-body" id="body_orden_pedido">
        <p>One fine body...</p>
      
    </div>
 
 
<?php $this->endWidget(); ?>

<script type="text/javascript">
  function gestion(id){
    var id_trazabilidad = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id_trazabilidad' => 'js:id_trazabilidad'),
        'url' => $this->createUrl("orden/solicitarProductoMarco"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#op-modal-header").html(data.header);
              $("#body_orden_pedido").html(data.content);
              $("#orden_pedido").modal("show");
              
            }
        }'
      )
    );?>
    return false;
  }

  function validarFormPedido(selector){
    jQuery.ajax({
      'url':'<?php echo Yii::app()->createUrl('orden/solicitarProductoMarco')?>',
      'dataType':'json',
      'data':$(selector).serialize(),
      'type':'post',
      'success':function(data){
        if(data.status == 'success'){
          $('#solpe_grid').yiiGridView.update('solpe_grid');
          $('#orden_pedido').modal('hide'); 
        }
        else{
          $('#body_orden_pedido').html(data.content);
        }
      },
      'cache':false}
    );
  }

</script>