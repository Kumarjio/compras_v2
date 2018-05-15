

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
  'id'=>'orden-form',
  'enableAjaxValidation'=>false,
  )); ?>



  <div id="general"></div>
  <div id="errors">
    <?php echo $form->errorSummary($model); ?>
    
  </div>
<!-- page content -->
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <?php if ($paso_actual != "swOrden/en_negociacion" && $paso_actual != "swOrden/analista_compras"): ?> 

                 <?php if($model->id < 500000000): ?>
                  <h3>Solicitud de Compra No. <b><?php echo $model->id; ?></b></h3> 
                 <?php else: ?>
                  <h3>Formato de Solicitud de Compra</h3> 
                 <?php endif ?>
              <?php endif ?>
              </div>

            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Solicitud de Compra </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <!-- Smart Wizard -->
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps">
                        <li>
                          <a href="#step-1">
                            <span class="step_no">1</span>
                            <span class="step_descr">
                                Paso 1<br />
                                <small>Datos Generales de la Orden</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr">
                                Paso 2<br />
                                <small>Solicitud de productos</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr">
                                              Paso 3<br />
                                              <small>Avanzar Solicitud</small>
                                          </span>
                          </a>
                        </li>
                      </ul>
                      <div id="step-1">
                        <?if ($paso_actual == "swOrden/en_negociacion" or $paso_actual == "swOrden/analista_compras"):
                          echo $this->renderPartial('orden_ro', array('model' => $model), true);?>
                           
                          
                       <?php endif ?>
                      </div>
                      <div id="step-2">
                        <div class='col-md-13'>
                            <?php
                            $this->widget('booster.widgets.TbExtendedGridView', array(
                                  'id'=>'seleccionar-productos-om',
                                    'filter'=>$orden_producto,
                                    'type'=>'striped bordered',
                                    'dataProvider' => $orden_producto->search($model->id),
                                    //'afterAjaxUpdate' => "function(id,data){console.log(id); console.log(data);}",
                                    'template' => "{items}",
                                    'columns' => array_merge(
                                      array(
                                        array(
                                            'class'=>'booster.widgets.TbRelationalColumn',
                                            'name' => 'id',
                                            'url' => $this->createUrl('orden/traerCotizaciones'),
                                            'value'=> '$data->idProducto->nombre',
                                            'afterAjaxUpdate' => 'js:function(tr,rowid,data){
                                                //bootbox.alert("mensaje "+rowid);
                                            }'
                                        )),
                                      array(
                                        'fecha_entrega',
                                        'cantidad' ,
                                        'detalle',
                                        array(
                                          'header'=>'Orden Marco',
                                          'value' =>'$data->idMarcoDetalle->id_orden_marco'
                                        ),
                                      )
                                    ),
                                ));
                            ?>
                          </div> 
                      </div>
                      <div id="step-3">
                        <h2 class="StepTitle">III. Compras reemplazadas</h2><br />

                      <p>Relacione, en caso de ser necesario, las ordenes que se estan reemplazanado con la solicitud actual.
                        Esto permitirá cancelar ordenes que ya fueron aprobadas y que nunca serán utilizadas.</p>

                        <div class="well">

                                <div style="overflow:scroll;">
                            <?php $this->widget('booster.widgets.TbGridView',array(
                              'id'=>'orden-reemplazos-grid',
                              'dataProvider'=>$reemplazos->search($model->id),
                              'type'=>'striped bordered condensed',
                              'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
                              'filter'=>$reemplazos,
                              'columns'=>array(
                                array(
                                    'header' => 'Orden Vieja',
                                    'name' => 'id',
                                    'type' => 'raw',
                                    'value' => 'CHtml::link($data->orden_vieja, Yii::app()->createUrl("orden/print", array("orden"=>$data->orden_vieja)), array("target" => "_blank"))'
                                  ),
                                array(
                                  'name' => 'nombre_compra',
                                  'value' => '$data->orden->nombre_compra',
                                  'filter' => false
                                ),
                                array(
                                    'htmlOptions' => array('nowrap'=>'nowrap', 'class'=>'grid-orden-reem'),
                                    'class'=>'booster.widgets.TbButtonColumn', 
                                    'template' => '{eliminar}',
                                    'buttons'=>array(
                                          'eliminar' => array(
                                            'label'=>'<i class="glyphicon glyphicon-trash"></i>',
                                            'url'=>'Yii::app()->createUrl("orden/deleteReemplazo", array("id"=>$data->id))',
                                            'options'=>array('class'=>'delete'),
                                          ),
                                      )   
                                )
                              ),
                            ))?>
                          </div>
                        </div>
                        <h2 class="StepTitle">Observaciones</h2>

                          <?php $this->widget('booster.widgets.TbGridView',array(
                            'id'=>'observaciones-wfs-grid',
                            'dataProvider'=>$observaciones->search("Orden", $model->id),
                            'type'=>'striped bordered condensed',
                            'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
                            'filter'=>$observaciones,
                            'columns'=>array(
                              array(
                                'header'=>'Usuario',
                                'name' => 'usuario',
                                'value' => '$data->idUsuario->nombre_completo'
                                ),
                                array(
                                  'header'=>'Est. anterior',
                                  'name'=>'estado_anterior',
                                  'filter'=>SWHelper::allStatuslistData($model),
                                  'value'=>'Orden::model()->labalEstado($data->estado_anterior)'
                                  ),
                                  array(
                                    'header'=>'Est. nuevo',
                                    'name'=>'estado_nuevo',
                                    'filter'=>SWHelper::allStatuslistData($model),
                                    'value'=>'Orden::model()->labalEstado($data->estado_nuevo)'
                                    ),

                                    'observacion',
                                    'fecha',
                                  ),
                                  )); ?>


                                <?php echo $form->textAreaGroup(
                                      $model,
                                      'observacion',
                                      array(
                                        'wrapperHtmlOptions' => array(
                                          //'class' => 'col-sm-5',
                                        ),
                                        'widgetOptions' => array(
                                          'htmlOptions' => array('rows'=>6, 'cols'=>50, 'class'=>'span8'),
                                        )
                                      ) 
                                ); ?>

        


          <?php if($paso_actual == "swOrden/llenaroc" || $paso_actual == "swOrden/suspendida" || $paso_actual == "swOrden/devolucion"): ?>
            
          <?php $model->validacion_usuario = null; 
            echo $form->checkboxGroup(
                        $model,
                        'validacion_usuario'
            ); 
            //echo $form->checkBoxRow($model,'negociacion_directa');
          ?>  
            
          <?php endif ?>

          <?php if($paso_actual == "swOrden/jefe"): ?>
            
          <?php $model->validacion_jefe = null; 
            echo $form->checkboxGroup(
                      $model,
                      'validacion_jefe'
            );
            //echo $form->checkBoxRow($model,'negociacion_directa');
            ?>
            
          <?php endif ?>

          <?php if($paso_actual == "swOrden/gerente"): ?>
            
          <?php $model->validacion_gerente = null; 
            echo $form->checkboxGroup(
                      $model,
                      'validacion_gerente'
            );
            //echo $form->checkBoxRow($model,'negociacion_directa');
            ?>
            
          <?php endif ?>

        
        


          <div class="row">
            <div class="col-md-6">
              <?php echo $form->dropDownListGroup(
                    $model,
                    'paso_wf',
                    array(
                      //linkTag($relation=null,$type=null,$href=null,$media=null,$options=array())
                      'append'=>'<a class="badge badge-info" rel="popover" data-content="El paso marcado con \'*\' es el actual. Puede dejar este paso si quiere continuar mas adelante con el diligenciamiento de este formulario" data-original-title="Ayuda">?</a>',
                      //'append'=>CHtml::linkButton('?', array('class'=>'badge badge-info', 'rel'=>"popover", 'data-content'=>"El paso marcado con '*' es el actual. Puede dejar este paso si quiere continuar mas adelante con el diligenciamiento de este formulario", 'data-original-title'=>"Ayuda",'id'=>'ayuda_wf' )),
                      'appendOptions'=>array(
                          'isRaw'=>false
                      ), 
                      'label'=>'Estado Siguiente',
                      'wrapperHtmlOptions' => array(
                        //'class' => 'col-sm-5',
                      ),
                        'widgetOptions' => array(
                          'data' => SWHelper::nextStatuslistData($model),
                          'htmlOptions' => array('class'=>'span5'),
                      )
                    )
              ); ?>
            </div>
          </div>
              



                <div class="form-actions">
                 
                  </div>


                  <?php $this->endWidget(); ?>
                      </div>

                    </div>
                    <!-- End SmartWizard Content -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- /page content -->

<script type="text/javascript">
  $(document).ready(function(){
    var id_gerencia = '<?php echo $model->id_gerencia?>';
    if(id_gerencia == '')
      $("#Orden_id_gerencia").attr("disabled","disabled");
  });
</script>
<script type="text/javascript">
  /*function solicitud_productos(id){
    var id_trazabilidad = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('id_trazabilidad' => 'js:id_trazabilidad'),
        'url' => $this->createUrl("orden/solicitarProductoMarco", array('id_orden'=>$model->id)),
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
  }*/

</script>