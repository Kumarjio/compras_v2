<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'infome-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">×</a>
		<strong>Recuerde!</strong> 
		Los campos marcados con <span class="required">*</span> son obligatorios.
	</div>
	<div class="accordion" id="accordion2">
	  <div class="accordion-group">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#formulario">
	        Opciones de Busqueda
	      </a>
	    </div>
	    <div id="formulario" class="accordion-body collapse in">
	      <div class="accordion-inner">
	        	<div class="orden-solicitud-accordion-inner">
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'tipo_informe', $model->tiposInforme(), array('class'=>'span5','maxlength'=>100, 'prompt'=>'Seleccione...')); ?>
	<?php echo $form->checkBoxListInlineRow($model,'tipo_negociacion', Chtml::listData(Orden::model()->tiposNegociacion(), 'id', 'nombre')); ?>

	<?php
	echo $form->label($model, 'fecha_inicio');
	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
		'model'=>$model,
		'attribute'=>'fecha_inicio',
		'language' => 'es',
		// additional javascript options for the date picker plugin
		'options'=>array(
			'showAnim'=>'fold', 
			'dateFormat' => 'yy-mm-dd', 
			'onClose' => 'js:function(dateT, obj){
                $("#InformeGlobalForm_fecha_fin").datepicker("option", "minDate", dateT);         
				
			}',
			//'minDate' => '+1d'    
		),
		'htmlOptions'=>array(
		'style'=>'height:20px;',
		'data-sync' => 'true',
		'class' => 'span5',
		),
	));

		echo $form->label($model, 'fecha_fin');
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'fecha_fin',
			'language' => 'es',
			// additional javascript options for the date picker plugin
			'options'=>array(
				'showAnim'=>'fold', 
				'dateFormat' => 'yy-mm-dd',
			),
			'htmlOptions'=>array(
				'style'=>'height:20px;',
				'data-sync' => 'true',
				'class' => 'span5',
				'onClick' => 'if($("#InformeGlobalForm_fecha_inicio").val() == ""){alert("Primero debe seleccionar la fecha inicio."); return false;}',
			),
		));
		?>
		<div id="gerencias_div" style="display: none">
			<div class="row">
			<?php
			echo $form->label($model, 'id_gerencia', array('class'=>'form-control span5'));
			?>
			</div>
			
			<div class="row">
			<?php
			$this->widget('ext.select2.ESelect2',array(
			  'model'=>$model,
			  'attribute'=>'id_gerencia',
			  'data'=>CHtml::listData(Gerencias::model()->findAll(), 'id','nombre'),
			  'htmlOptions'=>array(
			    'multiple'=>'multiple',
			    'class'=>'span5',
	            'ajax'=>array(
	                'type'=>'POST', 
	                'url'=>CController::createUrl('actualizarJefaturas'),
	                'dataType'=>'json',
	                'success'=>"function(data){
	                	jQuery('#InformeGlobalForm_id_jefatura').select2({
							'tags':data.tags
						});
	                }",                                   
	            ),
			  ),
			));
			?>

			</div>

			<div class="row">
			<?php
			echo $form->label($model, 'id_jefatura', array('class'=>'form-control span5'));
			?>
			</div>
				
			<div class="row">
			<?php

			echo $form->textField($model,'id_jefatura',array('class'=>'span5','maxlength'=>30)); 
			$this->widget('ext.select2.ESelect2',array(
			  'selector'=>'#InformeGlobalForm_id_jefatura',
			  'options'=>array(
			    'tags'=>Yii::app()->db->createCommand("select id, nombre as text from jefaturas")->queryAll(),
			  ),
			));

			?>
				
			</div>
		</div>	

		<div id="negociador_div" style="display: none">
			
			<?php echo $form->dropDownListRow($model,'negociador', CHtml::listData(Empleados::model()->findAll("es_negociador = 'Si'"), 'id', 'nombre_completo'),array('class'=>'span5','maxlength'=>30)); ?>

			<?php //echo $form->textFieldRow($model,'fecha_fin',array('class'=>'span5')); ?>


		</div>
		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Buscar',
			)); ?>
		</div>


<?php $this->endWidget(); ?>
			</div>	
	      </div>
	    </div>
	  </div>
  </div>

	<div>
		<?php echo $vista_inform;?>
	</div>
<ul class="js-event-log"></ul>

<script type="text/javascript">
$(document).ready(function(){
	var mostrar = '<?php echo ($vista_inform) ? 1 : 0 ?>';
	if(mostrar == '1')
		$("#formulario").collapse('hide');

	mostrarOpciones('<?php echo $model->tipo_informe?>');

	$('#InformeGlobalForm_id_jefatura').on('change', function (event) {
		if(event.added !== undefined){
			console.log(event.added);
	    }
	    if(event.removed !== undefined){
	  		console.log(event.removed);
	    }

	});

	$("#InformeGlobalForm_tipo_informe").on('change',function(e){
		var tipo = this.value;
		mostrarOpciones(tipo);
	});
});
function mostrarOpciones(tipo){
	if(tipo == 'N'){
		$("#gerencias_div").hide();
		$("#negociador_div").show();
	}
	else if(tipo == 'G'){
		$("#gerencias_div").show();
		$("#negociador_div").hide();
	}
	else{
		$("#gerencias_div").hide();
		$("#negociador_div").hide();
	}
}

</script>