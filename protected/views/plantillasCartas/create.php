<?php if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
	'id'=>'form-agregar-plantilla',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'onsubmit'=> 'jQuery.ajax({\'url\':\'/correspondencia/index.php/plantillasCartas/create\',\'dataType\':\'json\',\'data\':$(this).serialize(),\'type\':\'post\',\'success\':function(data){if(data.status == \'success\'){$(\'#dialogo-plantilla\').modal(\'hide\'); $(\'#plantilla-grid\').yiiGridView.update(\'plantilla-grid\');}else{$(\'#body-plantilla\').html(data.content);}},\'cache\':false});return false;'
	),
	'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>
<?php echo $form->errorSummary($model)  ?>
<?php echo $form->errorSummary($tipologias)  ?> 
<div class='col-md-6'>
	<?php echo $form->labelEx($model,'nombre'); ?>
	<div class="form-group">
   		<?php echo $form->textField($model,'nombre',array('class'=>'form-control inicial','maxlength'=>'50','onKeypress'=>'return soloLetras(event)')); ?>
  	</div>
</div>
<div class='col-md-12 oculto'>
      <div class="form-group">
        <?php echo CHtml::textArea('html_carta','',array('class'=>'form-control')); ?>
      </div>
</div>
<div class='col-md-12'>
	<?php echo $form->labelEx($tipologias,'id_tipologia'); ?>
    <div class="form-group">
	  <?php
	   $this->widget('ext.select2.ESelect2',array(
		  'model'=>$tipologias,
		  'attribute'=>'id_tipologia',
		  'data'=>Tipologias::cargaTipologias(),
		  'htmlOptions'=>array(
		    'options'=>array('selected'=>true),
		    'multiple'=>'multiple',
		    'style'=>'width:548px',
		  ),
	  ));?>
    </div>
</div>
<div class='col-md-12' id="editor">
    <div class="form-group">
	  <?php $this->widget(
	    'booster.widgets.TbCKEditor',
	    array(
	    	'model' => $model,
	    	'attribute'=>'plantilla',
	        'editorOptions' => array(
	            'plugins' => 'basicstyles,toolbar,enterkey,entities,floatingspace,wysiwygarea,indentlist,link,list,dialog,dialogui,button,indent,fakeobjects,table,image,maximize,flash,smiley'
	        ),
	    )
	);?>
    </div>
</div>
<div class="row">
</div>
<div class='col-md-1'>
	<div class="form-actions"> 
	<?php $this->widget('bootstrap.widgets.BootButton', array( 
		'buttonType'=>'submit', 
		'type'=>'info', 
		'label'=>'Guardar',
		'htmlOptions' => array('id'=>'guarda_carta'), 
	)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
function soloLetras(e) { // 1
	tecla = (document.all) ? e.keyCode : e.which; // 2
	if (tecla==8) return true; // 3
	patron =/[A-Za-z\s]/; // 4
	te = String.fromCharCode(tecla); // 5
	return patron.test(te); // 6
}
$("#guarda_carta").click(function(){
  var carta = CKEDITOR.instances.PlantillasCartas_plantilla.getData();
  $("#html_carta").val(carta);
});
</script>