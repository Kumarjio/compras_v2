<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
  'id'=>'orden-marco-compras-form',
  'enableAjaxValidation'=>false,
)); ?>
<div id="errors"></div>
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
            <small>Seleccionar Productos</small>
        </span>
      </a>
    </li>
    <li>
      <a href="#step-3">
        <span class="step_no">3</span>
        <span class="step_descr">
            Paso 3<br />
            <small>Seleccionar Siguiente Estado</small>
        </span>
      </a>
    </li>
  </ul>
  <div id="step-1">
  <?php $readon = ($model->paso_actual == 'swOrdenMarcoCompras/llenarocm' || $model->paso_actual == 'swOrdenMarcoCompras/devolucion')? '' : 'readonly';?>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'nombre_compra',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255, 'readonly'=>$readon)))); ?>

	<?php echo $form->textAreaGroup($model,'resumen_breve', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8', 'readonly'=>$readon)))); ?>

  </div>
  <div id="step-2">
		<?php echo $this->renderPartial('_seleccionar_productos', array('productos'=>$productos, 'detalle'=>$detalle, 'om'=>$model->id)) 	 ?>
		<br />
  </div>
  <div id="step-3">
  <?php echo $form->dropDownListGroup(
          $model,
          'paso_wf',
          array(
              'widgetOptions'=>array(
                  'htmlOptions'=>array('class'=>'span5'), 
                  'data'=> SWHelper::nextStatuslistData($model)

              ),
          )); ?>
	<?php //echo $form->textFieldGroup($model,'paso_wf',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->textAreaGroup($model,'observacion',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	

	<?php $this->endWidget(); ?>
  </div>


</div>