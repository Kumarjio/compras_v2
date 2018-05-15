<?php if(Yii::app()->request->isAjaxRequest){
  $cs = Yii::app()->clientScript;
  $cs->scriptMap['jquery.js'] = false;
  $cs->scriptMap['jquery.min.js'] = false;
}?>

<?php
$form = $this->beginWidget(
  'booster.widgets.TbActiveForm',
  array(
    'id' => 'form-pedido',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array(
      'onsubmit'=> 'validarFormPresup(this); return false;'
    ),
    //'type' => 'horizontal',
  )
); ?>


<?php echo $form->errorSummary($model)  ?>
<?php echo $form->hiddenField($model,'id_producto'); ?>
<?php echo $form->hiddenField($model,'id_vice'); ?>
<div class='col-md-6'>
<?php 
$reado = false;
if($model->id_vice != ''){
  $gerencias = CHtml::listData(Gerencias::model()->findAllByAttributes(array('id_vice'=>$model->id_vice)), 'id', 'nombre');
  if(count($gerencias) == 0)
    $reado = true ;
}else{
  $gerencias = CHtml::listData(Gerencias::model()->findAll('id_vice is null'), 'id', 'nombre');
}
echo $form->dropDownListGroup(
      $model,
      'id_direccion',
      array(
        'wrapperHtmlOptions' => array(
          'class' => 'col-sm-6',
        ),
        'widgetOptions' => array(
          'data' => $gerencias,
          'htmlOptions' => array(
              'prompt'=>'Seleccione...',
              'disabled'=>$reado
          ),
        )
      )
    ); ?>
</div>
<div class='col-md-6'>
<?php echo $form->textFieldGroup(
      $model,
      'valor',
      array(
        'wrapperHtmlOptions' => array(
          'class' => 'col-sm-6',
        ),
      )
    ); ?>
</div>
<div class='col-md-8'>
  <?php echo $form->hiddenField($model,'id_centro_costo'); ?>
  <?php echo $form->textFieldGroup(
        $model,
        'nombre_centro',
        array(
          'wrapperHtmlOptions' => array(
            'class' => 'col-sm-6',
          ),
          'widgetOptions' => array(
            'htmlOptions' => array('readonly' => true)
          )
      )
    ); ?>
</div>  
<div class='col-md-4'>
</br>
  <div class="form-group">
  <?php $this->widget(
        'booster.widgets.TbButton',
        array(
          'buttonType' => 'reset', 
          'label' => 'Buscar Centro Costo',
          'url'=>'#',
          'htmlOptions'=>array(
            'data-toggle' => 'modal',
            //'data-target' => '#modalCentro',
            'onClick' => "$('#presupuesto_form').modal('hide'); $('#modalCentro').modal();"
          )
        )
      ); ?>

  </div>
</div>
<div class='col-md-8'>
<?php echo $form->hiddenField($model,'id_cuenta'); ?>
<?php echo $form->textFieldGroup(
        $model,
        'nombre_cuenta',
        array(
          'wrapperHtmlOptions' => array(
            'class' => 'col-sm-6',
          ),
          'widgetOptions' => array(
            'htmlOptions' => array('readonly' => true)
          )
      )
    ); ?>
</div>
<div class='col-md-4'>
</br>

  <div class="form-group">
      <?php  $this->widget(
        'booster.widgets.TbButton',
        array(
          'buttonType' => 'reset', 
          'label' => 'Buscar Cuenta Contable',
          'url'=>'#',
          'htmlOptions'=>array(
            'data-toggle' => 'modal',
            //'data-target' => '#modalCentro',
            'onClick' => "$('#presupuesto_form').modal('hide'); $('#modalCuenta').modal();"
          )
        )
      );?>
    
  </div>
</div>

<div class='col-md-6'>
<?php echo $form->textFieldGroup(
        $model,
        'anio',
        array(
          'wrapperHtmlOptions' => array(
            'class' => 'col-sm-6',
          ),
          'widgetOptions' => array(
            'htmlOptions' => array('readonly' => true)
          )
      )
    ); ?>
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
<script type="text/javascript">
$(document).ready(function(){
  $("#Presupuesto_anio").val($('#anio').val());
})
</script>