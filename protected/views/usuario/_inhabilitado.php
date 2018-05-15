<?php 
if(Yii::app()->request->isAjaxRequest){
	$cs = Yii::app()->clientScript;
	$cs->scriptMap['jquery.js'] = false;
	$cs->scriptMap['jquery.min.js'] = false;
}
$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'form-inhabilitar-usuario',
	'type' => 'horizontal',
	'htmlOptions' => array(
		'onSubmit' => 'jQuery.ajax({
			"url":"'.$this->createUrl("inhabilitar").'",
			"dataType":"json",
			"data":$(this).serialize(),
			"type":"post",
			"success":function(res){
				if(res.status == "exitoso"){
	        		$("#usuario-grid").yiiGridView.update("usuario-grid");
	        		$("#dialogo-inhabilitar").modal("hide");
	        		$("#modal_exitoso #body_exitoso").html(res.content);
	        		$("#modal_exitoso").modal("show");	        		
	        	}else{
	        		$("#dialogo-inhabilitar").modal("show");
      				$("#dialogo-inhabilitar #body-inhabilitar").html(res.content);
      			}
			},
			"cache":false
		});
		return false;'
	),
));?>
	<?php echo $form->errorSummary($modelInhabilidad)  ?> 
	<?php echo CHtml::hiddenField('id', $model->id) ?>
	<div class="row">
		<div class='col-sm-1'></div>
		<div class='col-sm-3'>
	    	<?php echo $form->labelEx($modelInhabilidad,'id_tipo_inhabilidad', array('class'=>'control-label')); ?>
	    </div>
	    <div class='col-sm-7'>
	      	<?php
		      	echo $form->dropDownList($modelInhabilidad, 'id_tipo_inhabilidad',
			      	CHtml::listData(TipoInhabilidad::model()->findAll('estado = :estado', array(':estado'=>true)), 'id_tipo_inhabilidad', 'nombre_inhabilidad'),
			      	array('class'=>'form-control','prompt'=>'Seleccione...')
		      	); 
	     	?>
	    	<?php echo $form->error($modelInhabilidad,'id_tipo_inhabilidad'); ?>
	    </div>
	</div>
	<br>
	<div id="inicio" class='row oculto'>
		<div class='col-sm-1'></div>
		<div class='col-sm-3'>
			<?php //echo $form->labelEx($modelInhabilidad,'fecha_inicio', array('class' => 'control-label')); ?>
			<?php echo CHtml::label( 'Fecha Inicio *', 'lbfecha_inicio', array('class'=>'control-label')) ?>
		</div>
		<div class='col-sm-7'>
			<?php
				$this->widget('booster.widgets.TbDatePicker',   
					array(
						'model'=>$modelInhabilidad,
						'attribute'=>'fecha_inicio',
						'options' => array(
							'language' => "es",
							'autoclose'=>true,
							'format' => "yyyy-mm-dd",
						    'startDate' => date("Y-m-01"),
						    'endDate' => date("Y-m-d", strtotime('+5 year', strtotime(date("Y-m-d")))),
						    //'orientation' => "bottom auto",
						),
						'htmlOptions' => array(
				        	'class'=>'form-control',
				    	),
					)
				);
			?>
			<?php echo $form->error($modelInhabilidad,'fecha_inicio'); ?>
		</div>
	</div>
	<br>
	<div id="fin" class='row oculto'>
		<div class='col-sm-1'></div>
		<div class='col-sm-3'>
			<?php echo CHtml::label( 'Fecha Fin *', 'lbfecha_fin', array('class'=>'control-label')) ?>
			<?php //echo $form->labelEx($modelInhabilidad,'fecha_fin', array('class' => 'control-label')); ?>
		</div>
		<div class='col-sm-7'>
			<?php
				$this->widget('booster.widgets.TbDatePicker',   
					array(
						'model'=>$modelInhabilidad,
						'attribute'=>'fecha_fin',
						'options' => array(
							'language' => "es",
							'autoclose'=>true,
							'format' => "yyyy-mm-dd",
						    'startDate' => date("Y-m-01"),
						    'endDate' => date("Y-m-d", strtotime('+5 year', strtotime(date("Y-m-d")))),
						    //'orientation' => "bottom auto",
						),
						'htmlOptions' => array(
				        	'class'=>'form-control',
				    	),
					)
				);
			?>
			<?php echo $form->error($modelInhabilidad,'fecha_fin'); ?>
		</div>
	</div>
	<br>
	<div id="alerta" class='row oculto' align="center">
		<div class='col-sm-1'></div>
		<div class='col-sm-10'>
			<div class="alert alert-info" role="alert">
				<p id="casosActivos"></p>
			</div>
		</div>
	</div>
	<div id="reemplazo" class='row oculto'>
		<div class='col-sm-1'></div>
		<div class='col-sm-3'>
			<?php echo CHtml::label( 'Reemplazo *', 'lbreemplazo', array('class'=>'control-label')) ?>
		  	<?php //echo $form->labelEx($modelInhabilidad,'reemplazo')." *"; ?>
		</div>
		<div class="col-sm-7">
      		<?php $this->widget('ext.select2.ESelect2',array(
      			'model'=>$modelInhabilidad,
      			'attribute'=>'reemplazo',
      			'data'=>Usuario::model()->cargarUsuariosReemplazantes($model->usuario),
      			'htmlOptions'=>array(
        			'options'=>array('selected'=>true),
        			//'multiple'=>'multiple',
        			'style'=>'width:100%',
        			//'class'=>'col-sm-10',
      			),
    		));
    		?>
		</div>
	</div>
	<br>
<?php $this->endWidget(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		var tipo = $("#Inhabilidad_id_tipo_inhabilidad").val();
		validaHabilitacion(tipo);

		$("#Inhabilidad_id_tipo_inhabilidad").change(function(){
			var value = this.value;
			validaHabilitacion(value);
		});

		$("#Inhabilidad_fecha_inicio").change(function(){
	    	$("#Inhabilidad_fecha_fin").val("");

	    	$('#Inhabilidad_fecha_fin').datepicker('setStartDate', $("#Inhabilidad_fecha_inicio").val());
	    });

	});
	function confirma(){
		$("#dialogo-inhabilitar").modal("hide");
		bootbox.confirm({
		    message: "<h5>¿Esta seguro de inhabilitar a este empleado?</h5>",
		    buttons: {
		        confirm: {
		            label: 'SI',
		            className: 'btn-success'
		        },
		        cancel: {
		            label: 'NO',
		            className: 'btn-default'
		        }
		    },
		    callback: function (confirm) {
		    	if(confirm){
			    	$("#form-inhabilitar-usuario").submit();
		    	}
		    }
	    });	    
	}
	function validaHabilitacion(id_tipo_inhabilidad){
		if(id_tipo_inhabilidad == ""){
			$("#inicio").hide();
			$("#inicio").val("");
			$("#fin").hide();
			$("#fin").val("");
			$("#reemplazo").hide();
			$("#reemplazo").val("");
			$("#alerta").hide();
			$("#casosActivos").html("");
		}
		<?php echo CHtml::ajax(
		    array(
		      'type' => 'POST',
		      'data' => array('id' => 'js:id_tipo_inhabilidad', 'usuario'=>$model->usuario),
		      'url' => $this->createUrl("validaHabilitacion"),
		      'dataType'=>'json',
		      'success' => 'function(data){
		      		if(data.resultado){
			      		if(data.msj){
			      			$("#alerta").show();
			      			$("#casosActivos").html(data.msj);
			      		}
		      			if(data.inicio){
		      				$("#inicio").show();
		      			}else{
		      				$("#inicio").hide();
		      				$("#inicio").val("");
		      			}
		      			if(data.fin){
		      				$("#fin").show();
		      			}else{
		      				$("#fin").hide();
		      				$("#fin").val("");
		      			}
		      			if(data.reemplazo){
		      				$("#alerta").show();
							$("#casosActivos").html(data.msj);
		      				$("#reemplazo").show();		      				
		      			}else{
		      				$("#reemplazo").hide();
		      				$("#reemplazo").val("");
		      			}
		        	}
		      }'
		    )
		);?>
	}
//$("#alerta").hide();
//$("#casosActivos").html("");
</script>