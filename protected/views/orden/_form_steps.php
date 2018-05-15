<?php

Yii::app()->clientScript->registerScript('register_static_css_js', "                                                                               
$(function() {                                                                                                                                         
  script_files = $('script[src]').map(function() { return $(this).attr('src'); }).get();                                                                                                                                          
  css_files = $('link[href]').map(function() { return $(this).attr('href'); }).get();                                                                                                                                          
});");

?>

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
                                              <small>Agregar Nuevos Productos</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-4">
                            <span class="step_no">4</span>
                            <span class="step_descr">
                                              Paso 4<br />
                                              <small>Avanzar Solicitud</small>
                                          </span>
                          </a>
                        </li>
                      </ul>
                      <div id="step-1">
                        <?if ($paso_actual == "swOrden/en_negociacion" or $paso_actual == "swOrden/analista_compras"):
                          echo $this->renderPartial('orden_ro', array('model' => $model), true);
                        else: ?>
                           
                          <div class="row">
                            <div class="col-md-6">    
                              <b>Usuario Solicitante: </b><?php echo $model->idUsuario->nombre_completo; ?>
                            </div>
                          </div>
                          <input type="hidden" id="form_saved" value="<?php echo $model->nombre_compra; ?>" />
                          <div class="row">
                            <div class="col-md-6">    
                            <?php echo $form->dropDownListGroup(
                                        $model,
                                        'tipo_compra',
                                        array(
                                          'wrapperHtmlOptions' => array(
                                            //'class' => 'col-sm-5',
                                          ),
                                            'widgetOptions' => array(
                                              'data' => CHtml::listData(TipoCompra::model()->findAll(),"id","nombre"),
                                              'htmlOptions' => array('prompt' => 'Seleccione...','class'=>'span5','data-sync'=>'true'),
                                          )
                                        )
                            ); ?>
                              
                            </div>
                            <div class="col-md-6">    
                            <?php echo $form->dropDownListGroup(
                                  $model,
                                  'negociacion_directa',
                                  array(
                                    'wrapperHtmlOptions' => array(
                                      //'class' => 'col-sm-5',
                                    ),
                                      'widgetOptions' => array(
                                        'data' => CHtml::listData(Orden::model()->tiposNegociacion(),"id","nombre"),
                                        'htmlOptions' => array('prompt' => 'Seleccione...','class'=>'span5','data-sync'=>'true'),
                                    )
                                  )
                            ); ?>
                              
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">    
                            <?php echo $form->textFieldGroup(
                                    $model,
                                    'nombre_compra',
                                    array(
                                      'wrapperHtmlOptions' => array(
                                        //'class'=>'span5','maxlength'=>255, 'data-sync'=>'true'
                                      ),
                                      'widgetOptions' => array(
                                        'htmlOptions' => array('class'=>'span5','maxlength'=>255, 'data-sync'=>'true'),
                                      )
                                    )
                            ); ?>
                            </div>
                          </div>

                          <?php echo $form->textAreaGroup(
                                  $model,
                                  'resumen_breve',
                                  array(
                                    'wrapperHtmlOptions' => array(
                                      //'class'=>'span5','maxlength'=>255, 'data-sync'=>'true'
                                    ),
                                    'widgetOptions' => array(
                                      'htmlOptions' => array('rows'=>6, 'cols'=>50, 'class'=>'span8','data-sync'=>'true'),
                                    )
                                  )
                                  
                          ); ?>
                          <div class="row">
                            <div class="col-md-6">  
                          <?php echo $form->dropDownListGroup(
                                      $model,
                                      'id_vicepresidencia',
                                      array(
                                          'wrapperHtmlOptions' => array(
                                            //'class' => 'col-sm-5',
                                          ),
                                          'widgetOptions' => array(
                                            'data' => CHtml::listData(Vicepresidencias::model()->findAll(),"id","nombre"),
                                            'htmlOptions' => array('prompt' => 'Seleccione...',
                                                'class'=>'span5',
                                                'data-sync'=>'true',
                                                'onChange' => CHtml::ajax(array(
                                                  'type' => 'post',
                                                  'dataType' => 'json',
                                                  'data' => array('vice' => 'js:this.value'),
                                                  'url' => $this->createUrl("Vicepresidencias/gerenciasJefaturas"),
                                                  'success'=>'function(data){
                                                    if(data.status == "ok"){
                                                      $("#Orden_"+data.id).html(data.options);
                                                      $("#Orden_"+data.id_vacio).html(data.vacio);
                                                      if(data.id_vacio == "id_gerencia"){
                                                        $("#Orden_"+data.id_vacio).attr("readonly","readonly");
                                                      }
                                                      else
                                                        $("#Orden_id_gerencia").removeAttr("readonly");
                                                                  $("#Orden_id_vicepresidente").val(data.id_vicepre); 
                                                                  $("#nombre_vicepresidente").val(data.nombre_vice);
                                                                  $("#Orden_id_gerente").val(""); 
                                                                  $("#nombre_gerente").val("");
                                                                            $("#nombre_jefe").val("");
                                                                }
                                                                else{
                                                                  alert(data.mensaje);
                                                                  $("#Orden_id_vicepresidencia").val(""); 
                                                                  $("#nombre_vicepresidente").val("");
                                                      $("#Orden_id_gerencia").html(data.options_gerencia);
                                                                  $("#Orden_id_gerente").val(""); 
                                                                  $("#nombre_gerente").val("");
                                                                            $("#nombre_jefe").val("");
                                                                }
                                                  }',
                                                  )))
                                        )
                                      )


                                     
                                     ); ?>

                          </div>
                            <div class="col-md-6">  
                            <?php echo $form->textField(
                                          $model,
                                          'id_vicepresidente',
                                          array('class'=>'span1', 'readonly' => true, 'style'=>'display:none','data-sync'=>'false')
                                          
                            ); ?>
                            <?php if($model->id_vicepresidente != ""): ?>
                            <?php $vice = Empleados::model()->findByPk($model->id_vicepresidente); ?>
                            <div class="form-group">
                              <label class="control-label" for="Orden_id_vicepresidente">Nombre Vicepresidente</label>
                              <input class="form-control" name="nombre" readonly="true" id="nombre_vicepresidente" value="<?php echo $vice->nombre_completo; ?>" type="text">
                            </div>
                            <?php else: ?>
                              <div class="form-group">
                                <label class="control-label" for="Orden_id_vicepresidente">Nombre Vicepresidente</label>
                                <input class="form-control" name="nombre" readonly="true" id="nombre_vicepresidente" type="text">
                              </div>
                            <?php endif ?>
                            </div>
                          </div>

                          
                          <div class="row">
                            <div class="col-md-6"> 
                          <?php echo $form->dropDownListGroup(
                                        $model,
                                       'id_gerencia',
                                        array(
                                          'wrapperHtmlOptions' => array(
                                            //'class' => 'col-sm-5',
                                          ),
                                          'widgetOptions' => array(
                                            'data' => ($model->id_vicepresidencia != "")? CHtml::listData(Gerencias::model()->findAll("id_vice = ".$model->id_vicepresidencia),"id","nombre") : CHtml::listData(Gerencias::model()->findAll("id_vice is null and activo = true"),"id","nombre"),
                                            'htmlOptions' => array('prompt' => 'Seleccione...',
                                                                'class'=>'span5',
                                                                'data-sync'=>'true',
                                                                'onChange' => CHtml::ajax(array(
                                                                  'type' => 'post',
                                                                  'dataType' => 'json',
                                                                  'data' => array('gerencia' => 'js:this.value'),
                                                                  'url' => $this->createUrl("gerencias/jefaturas"),
                                                                  'success' => 'function(data){
                                                                    if(data.status == "ok"){
                                                                      $("#Orden_id_jefatura").replaceWith(data.combo);
                                                                      $("#Orden_id_gerente").val(data.gerente.id);  
                                                                      $("#nombre_gerente").val(data.gerente.nombre);
                                                                                                    $("#nombre_jefe").val("");
                                                                    }else{
                                                                      alert(data.mensaje);
                                                                      $("#Orden_id_gerente").val(""); 
                                                                      $("#Orden_id_jefe").val(""); 
                                                                      $("#nombre_gerente").val("");
                                                                      $("#nombre_jefe").val("");
                                                                      $("#Orden_id_jefatura").html(data.jefatura_vacio);
                                                                    }
                                                                      
                                                                  }'
                                                                ))
                                                             )
                                        )
                                      )
                                                           
                          ); ?>
                                
                            

                            </div>
                            <div class="col-md-6">
                              <?php echo $form->textField(
                                        $model,
                                        'id_gerente',
                                        array('class'=>'span1', 'readonly' => true, 'style'=>'display:none','data-sync'=>'false')
                                        
                              ); ?>
                            <?php if($model->id_gerente != ""): ?>
                              <?php $gerente = Empleados::model()->findByPk($model->id_gerente); ?>
                                <div class="form-group">
                                  <label class="control-label" for="Orden_id_vicepresidente">Nombre Director</label>
                                  <input class="form-control" name="nombre" readonly="true" id="nombre_gerente" value="<?php echo $gerente->nombre_completo; ?>" type="text">
                                </div>
                              
                            <?php else: ?>
                                <div class="form-group">
                                  <label class="control-label" for="Orden_id_vicepresidente">Nombre Director</label>
                                  <input class="form-control" name="nombre" readonly="true" id="nombre_gerente" type="text">
                                </div>
                            <?php endif ?>


                          </div> 
                        </div>
                            <?php 
                              if($model->id_gerencia != "") {
                                $jefaturas = CHtml::listData( Jefaturas::model()->findAllByAttributes(array('id_gerencia' => $model->id_gerencia)), "id", "nombre");
                                if(!$model->idGerencia->activo && $model->id_vicepresidencia != ""){
                                  $jefaturas = CHtml::listData( Jefaturas::model()->findAllByAttributes(array('id_vice' => $model->id_vicepresidencia)), "id", "nombre");
                                }
                              }
                              elseif($model->id_vicepresidencia != ""){
                                $jefaturas = CHtml::listData( Jefaturas::model()->findAllByAttributes(array('id_vice' => $model->id_vicepresidencia)), "id", "nombre");
                              }
                              else{
                                $jefaturas = array();
                              }
                            
                            ?>
                            <div class="row">
                            <div class="col-md-6">
                            <?php echo $form->dropDownListGroup(
                                            $model,
                                            'id_jefatura',
                                            array(
                                              'widgetOptions' => array(
                                                'data' => $jefaturas,
                                                'htmlOptions' => array(
                                                    'prompt' => 'Seleccione...',
                                                    'class' => 'span5',
                                                    'data-sync'=>'true',
                                                    'id' => 'Orden_id_jefatura',
                                                    'onChange' => CHtml::ajax(array(
                                                          'type' => 'post',
                                                          'dataType' => 'json',
                                                          'data' => array('jefatura' => 'js:this.value'),
                                                          'url' => $this->createUrl("jefaturas/nombrejefe"),
                                                          'success' => 'function(data){
                                                            if(data.status == "ok"){
                                                              $("#Orden_id_jefe").val(data.jefe.id);  
                                                              $("#nombre_jefe").val(data.jefe.nombre);
                                                              //$("#Orden_centro_costos").val(data.costos.id);  
                                                              //$("#centro_costos").val(data.costos.nombre);      
                                                            }else{
                                                              alert(data.mensaje);
                                                              $("#Orden_id_jefe").val("");  
                                                              $("#nombre_jefe").val("");
                                                              //$("#Orden_centro_costos").val("");  
                                                              //$("#centro_costos").val("");
                                                            }                                               
                                                          }'
                                                      ))
                                                )
                                              )
                                            )
                            ); ?>

                          
                          </div>
                          <div class="col-md-6">
                            <div id="presupuesto"></div>
                            
                            <?php echo $form->textField(
                                          $model,
                                          'id_jefe',
                                          array('class'=>'span1', 'readonly' => true, 'style'=>'display:none','data-sync'=>'false')
                                          
                            ); ?>
                            <?php if($model->id_jefe != ""): ?>
                            <?php $jefe = Empleados::model()->findByPk($model->id_jefe); ?>
                              <div class="form-group">
                                <label class="control-label" for="Orden_id_vicepresidente">Nombre Jefe</label>
                                <input class="form-control" name="nombre" readonly="true" id="nombre_jefe" value="<?php echo $jefe->nombre_completo; ?>" type="text">
                              </div>
                            <?php else: ?>
                              <div class="form-group">
                                <label class="control-label" for="Orden_id_vicepresidente">Nombre Jefe</label>
                                <input class="form-control" name="nombre" readonly="true" id="nombre_jefe" type="text">
                              </div>
                            <?php endif ?>
                          </div>
                        </div>
                          
                       <?php endif ?>
                      </div>
                      <div id="step-2">
                        <div class='col-md-13'>
                            <?php
                            $criteria = new CDbCriteria;
                            if($productos->id_categoria != "")
                              $criteria->compare('id_categoria',$productos->id_categoria);
                            $criteria->order = 'nombre';
                            
                            //$criteria->compare('activo','Si');
                            //$lista = CHtml::listData(FamiliaProducto::model()->findAll($criteria), 'id', 'nombre');

                            $this->widget('booster.widgets.TbGridView',array(
                              'id'=>'productos-creados-grid',
                              'dataProvider'=>$productos->search_solicitud($model->id),
                              //'dataProvider'=>$productos->search(),
                              //'template' => "{items}",
                              'filter' => $productos,
                              'type' => 'striped bordered condensed',
                              'responsiveTable' => true,
                              'columns'=>array(
                                  //'id_categoria',
                                  //'categoria',
                                  array(
                                    'name'=>'id_categoria',
                                    'filter'=>CHtml::activeDropDownList($productos, 'id_categoria', CHtml::listData(Categorias::model()->findAll(), 'id', 'nombre'), array('class'=>'form-control', 'prompt'=>''
                                    )),
                                    'value'=>'$data->familia->idCategoria->nombre'
                                  ),
                                  array(
                                    'name'=>'id_familia',
                                    'filter'=>CHtml::activeDropDownList($productos, 'id_familia', CHtml::listData(FamiliaProducto::model()->findAll($criteria), 'id', 'nombre'), array('class'=>'form-control', 'prompt'=>'')),
                                    'value'=>'$data->familia->nombre'
                                  ),
                                  'nombre',
                                  array(
                                    'header'=>'Disponible Marco',
                                    'type'=>'html',
                                    'value'=>'$data->buscarProductosMarco()'
                                  ),
                                  array(
                                    'header'=>'Presupuesto',
                                    'type'=>'html',
                                    'value'=>'$data->buscarProductoPresupuesto('.$model->id.')'
                                  ),
                                  array(
                                  'header'=>'Solicitar',
                                  'class'=>'booster.widgets.TbButtonColumn',
                                  'template'=>'{seleccionar} ',
                                  'buttons' => array(
                                    'seleccionar' => array(
                                        'label'=>'Seleccionar',
                                        //'url'=>'CJSON::encode($data)',
                                        //'icon'=>'glyphicon glyphicon-ok',
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok.png',
                                        'url'=>'Yii::app()->createUrl("orden/solicitarProductoMarco", array("id_orden"=>'.$model->id.',"id_producto"=>$data->id, "id_detalle_marco"=>$data->buscarProductosMarcoIdDetalle()))',
                                        //'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario',
                                        //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
                                        //'click'=> 'js:function(){return solicitud_productos(this);}',
                                        'options'=>array('class'=>'select_producto'),
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
                                  'ajaxType'=>'GET',
                                  'dataProvider' => $Mgrid->search($model->id),
                                  'template' => "{items}",
                                  'columns' => array(
                                      array(
                                        'name'=>'id_producto',
                                        'value'=>'$data->idProducto->nombre'
                                      ),
                                      'fecha_entrega',
                                      'cantidad' ,
                                      'detalle',
                                      array(
                                        'header'=>'Orden Marco',
                                        'value' =>'$data->idMarcoDetalle->id_orden_marco'
                                      ),
                                      array(
                                        'htmlOptions' => array('nowrap'=>'nowrap', 'class'=>'grid-pedido'),
                                        'class'=>'booster.widgets.TbButtonColumn',
                                        'template'=>'{eliminar}',
                                        'buttons'=>array(
                                          /*'subir' => array(
                                            'url' => '"/index.php/orden/subir/orden_solicitud_proveedor/".$data->id',
                                            'icon' => 'file',
                                            'label' => 'Ver/Adjuntar Archivos',
                                            'options' => array(
                                              'class' => 'subir-archivos'
                                            ) 
                                          ),*/
                                          'eliminar' => array(
                                            'label'=>'<i class="glyphicon glyphicon-trash"></i>',
                                            'url'=>'Yii::app()->createUrl("orden/deleteDetPed", array("id"=>$data->id))',
                                            'options'=>array('class'=>'delete'),
                                          ),
                                        ),
                                        'deleteButtonUrl'=>"Yii::app()->createUrl('orden/deleteDetPed', array('id'=>".'$data->id'."))",
                                        'updateButtonUrl'=>'CController::createUrl("/orden/updateProveedor", array("id_orden_solicitud"=>$data->id_orden_solicitud, "id" => $data->id))'
                                      )
                                  ),
                              )
                          );

                            ?>
                          </div> 
                      </div>
                      <div id="step-3">
                        
                      <h2 class="StepTitle">II. Productos</h2><br />
                      <?php echo $this->renderPartial('_crear_productos', array('paso_actual'=>$paso_actual, 'orden'=>$model, 'model'=>$orden_solicitud))   ?>
    
                      </div>
                      <div id="step-4">
                        <h2 class="StepTitle">III. Compras reemplazadas</h2><br />

                      <p>Relacione, en caso de ser necesario, las ordenes que se estan reemplazanado con la solicitud actual.
                        Esto permitirá cancelar ordenes que ya fueron aprobadas y que nunca serán utilizadas.</p>

                        <div class="well">
                          <div style="width:100%; overflow:hidden;">
                            <?php
                            $this->widget(
                                'booster.widgets.TbButton',
                                array(
                                    'label' => 'Agregar orden a reemplazar',
                                    'context' => 'warning',
                                    'url'=>$this->createUrl('orden/crearReemplazo', array('id_orden'=>$model->id)),
                                    'htmlOptions' => array(
                                        'href'=>$this->createUrl('orden/crearReemplazo', array('id_orden'=>$model->id)),
                                        'id'=>'btn_agregar_orden'
                                    ),
                                )
                            );
                            ?>
                            </div>

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
                  <?php $this->widget('bootstrap.widgets.BootButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>$model->isNewRecord ? 'Crear' : 'Enviar',
                    //'htmlOptions' => array('onClick' => "if($('#solicitudes-container').find('div.no-guardado-aun').size() != 0){return confirm('Tiene un producto sin guardar, desea proceder?');  }"
                    'htmlOptions' => array('onClick' => "$(\".guardarSolicitud\").click();if($(\"#solicitudes-container .alert-error\").length != 0 ){ showProductsWithErrors(); setTimeout(function(){alert('Error en los productos. Verifique para continuar.'); updateProductNumber();}, 500); return false; }else{ me_puedo_ir = true }"
                    )
                    )); ?>
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
      $("#Orden_id_gerencia").attr("readonly","readonly");
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