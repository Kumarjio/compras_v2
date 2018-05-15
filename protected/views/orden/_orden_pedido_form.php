<?php
if (Yii::app()->request->isAjaxRequest) {
    $cs = Yii::app()->clientScript;
    $cs->scriptMap['jquery.js'] = false;
    $cs->scriptMap['jquery.min.js'] = false;
}
?>
<?php
$form = $this->beginWidget(
  'booster.widgets.TbActiveForm',
  array(
    'id' => 'form-pedido',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array(
      'onsubmit'=> 'return false;'
    ),
    //'type' => 'horizontal',
  )
); ?>


<?php echo $form->errorSummary($model)  ?>
<?php echo $form->hiddenField($model,'id_producto'); ?>
<?php echo $form->hiddenField($model,'id_orden'); ?>
<?php echo $form->hiddenField($model,'id_marco_detalle'); ?>
  
<div class="x_panel">

  <div class="x_content">
    <div class='col-md-12'>
      <h3>Información Producto</h3>
      <?php if($model->id_marco_detalle){ ?>
        <div class="alert alert-info">
        <strong>Atencion!</strong>
        De este producto hay <?php echo $productosMarco[0]->cant_valor; ?> cantidades para consumir 
      </div>
      <?php } ?>
    </div>

    <div class='col-md-12'>
    <?php echo $form->textFieldGroup($model->idProducto,'nombre',array('wrapperHtmlOptions' => array('class' => 'col-sm-6','readonly'=>true), 'label'=>'Nombre Producto', 'widgetOptions' => array('htmlOptions' => array('disabled' => true))));

    ?>
    </div>
    <div class='col-md-6'>
    <?php echo $form->textFieldGroup(
          $model,
          'cantidad',
          array(
            'wrapperHtmlOptions' => array(
              'class' => 'col-sm-6',
              //'maxlength'=>'50'
            ), 
            'widgetOptions' => array('htmlOptions' => array('class' => 'numeric'))
          )
        ); ?>
    </div>


    <div class='col-md-6'>
    <?php echo $form->datePickerGroup(
          $model,
          'fecha_entrega',
          array(
            'widgetOptions' => array(
              'options' => array(
                'language' => 'es',
                'format' => 'yyyy-mm-dd',
                'startDate'=>date('Y-m-d')
              ),
            ),
            'wrapperHtmlOptions' => array(
              'class' => 'col-sm-6',
            ),
            //'hint' => 'Click inside! This is a super cool date field.',
            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
          )
        ); ?>


    </div>
    <div class='col-md-12'>
    <?php echo $form->textAreaGroup(
          $model,
          'detalle',
          array(
            'wrapperHtmlOptions' => array(
              'class' => 'col-sm-6',
              //'maxlength'=>'50'
            ),
            //'hint' => 'In addition to freeform text, any HTML5 text-based input appears like so.'
          )
        ); ?>
    </div>

  </div>
  
</div>  

<div class="x_panel">

  <div class="x_content">
    <h3>Información Entrega</h3>
    <div class='col-md-6'>
      <?php echo $form->textFieldGroup($model,'responsable',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>
    </div>
    <div class='col-md-6'>
      <?php echo $form->textFieldGroup($model,'direccion_entrega',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>
    </div>
    <div class='col-md-6'>
      <?php echo $form->textFieldGroup($model,'ciudad',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>
    </div>  
    <div class='col-md-6'>
      <?php echo $form->textFieldGroup($model,'departamento',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4')))); ?>
    </div>
    <div class='col-md-6'>
      <?php echo $form->textFieldGroup($model,'telefono',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span4 numeric')))); ?>
    </div>
  </div>
  
</div>  

<div class="x_panel">

  <div class="x_content">
    <h3>Información Centro de Costos y Cuenta Contable</h3>
        <?php echo $form->hiddenField($model,'id_centro_costos',array('class'=>'span1', 'readonly' => true)); ?>
        <?php if($model->id_centro_costos != ""): ?>
              <?php $centro_costos = CentroCostos::model()->findByPk($model->id_centro_costos); ?>
              <?php echo $form->textFieldGroup(
                  $model,
                  'nombre_centro',
                  array( 
                      'append'=>CHtml::linkButton('Seleccionar centro de costos', array('class'=>'primary', 'id'=>'selectCostos', 'onClick'=>'selectCostosOP(this)')),
                      'appendOptions'=>array(
                          'isRaw'=>false
                      ),  
                      'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true', 'value'=>$centro_costos->nombre))
                  )
              ); ?>        

          <?php else: ?>

              <?php echo $form->textFieldGroup(
                  $model,
                  'nombre_centro',
                  array( 
                      'append'=>CHtml::linkButton('Seleccionar centro de costos', array('class'=>'primary', 'id'=>'selectCostos', 'onClick'=>'selectCostosOP(this)')),
                      'appendOptions'=>array(
                          'isRaw'=>false
                      ),  
                      'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true'))
                  )
              ); ?>
                      

          <?php endif ?>
 

          <?php echo $form->hiddenField($model,'id_cuenta_contable',array('class'=>'span1', 'readonly' => true)); ?>
          
        <?php if($model->id_cuenta_contable != ""): ?>
              <?php $cuenta_contable = CuentaContable::model()->findByPk($model->id_cuenta_contable); ?>
              <?php echo $form->textFieldGroup(
                  $model,
                  'nombre_cuenta',
                  array( 
                      'append'=>CHtml::linkButton('Seleccionar cuenta', array('class'=>'primary', 'id'=>'selectCuenta', 'onClick'=>'selectCuentaOP(this)')),
                      'appendOptions'=>array(
                          'isRaw'=>false
                      ),  
                      'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true', 'value'=>$cuenta_contable->nombre))
                  )
              ); ?>        

          <?php else: ?>

              <?php echo $form->textFieldGroup(
                  $model,
                  'nombre_cuenta',
                  array( 
                      'append'=>CHtml::linkButton('Seleccionar cuenta', array('class'=>'primary', 'id'=>'selectCuenta', 'onClick'=>'selectCuentaOP(this)')),
                      'appendOptions'=>array(
                          'isRaw'=>false
                      ),  
                      'widgetOptions'=>array('htmlOptions'=>array('class'=>'col-md-6', 'readonly'=>'true'))
                  )
              ); ?>
                      

          <?php endif ?>

          
  </div>
  
</div> 
  <div class='col-md-12'>
            <?php $this->widget(
                'booster.widgets.TbButton',
                array(
                    'context' => 'primary',
                    //'url' => '#',
                    //'htmlOptions' => array('data-dismiss' => 'modal'),
                    'buttonType'=>'submit',  
                    'label'=>$model->isNewRecord ? 'Guardar' : 'Actualizar', 
                )
            ); ?>
            <?php $this->widget(
                'booster.widgets.TbButton',
                array(
                    'label' => 'Cerrar',
                    'url' => '#',
                    'htmlOptions' => array('data-dismiss' => 'modal'),
                )
            ); ?>
  <div>
          
<?php  

$this->endWidget();   
?>