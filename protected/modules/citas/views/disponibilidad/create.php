<?php
$this->breadcrumbs=array(
	'Disponibilidads'=>array('admin'),
	'Crear',
);
$this->setPageTitle('Creación de Disponibilidad');

?>

<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Generación de Disponibilidad</h3>
    </div>
    <div class="panel-body">

		<?php
			$form = $this->beginWidget('CActiveForm', array(
				'id' => 'disponibilidad-form',
				'enableAjaxValidation' => false,
				//'enableClientValidation' => true,
				//'clientOptions' => array(
									    
				//)
			));
		?>

		<div>
	        <?php echo $form->labelEx($model,'id_tipo_consulta', array('class'=>'control-label')); ?>
	      	<?php
		      	echo $form->dropDownList($model, 'id_tipo_consulta',
		      		CHtml::listData(TipoPrestacion::model()->findAll(), 'id_tipo_prestacion', 'descripcion'),
                	array('empty'=>'Seleccione Tipo Consulta',
                		/*'ajax'=>array(
	                        'type'=>'POST',
	                        'url'=>array('disponibilidad/cargaProcedimiento'),
	                        'update'=>'#'.CHtml::activeId($model,'id_procedimiento')
	                    ),*/
                    	'class'=>'form-control',
                    )
                )
	     	?>
			<?php echo $form->error($model,'id_tipo_consulta'); ?>
		</div>

		<? if ($model->id_procedimiento != ""){ ?>
    		<div id="row_procedimiento">
    	<? }else{ ?>
			<div id="row_procedimiento" style="display:none">
    	<? } ?>
			<br>
	        <?php echo $form->labelEx($model,'id_procedimiento', array('class'=>'control-label')); ?>
	      	<?php
		      	echo $form->dropDownList($model, 'id_procedimiento',
		      		CHtml::listData(Especialidad::model()->findAll(), 'id_especialidad', 'nombre_especialidad'),
                	array(/*
	                    'ajax'=>array(
	                        'type'=>'POST',
	                        'url'=>array('disponibilidad/cargaRecurso'),
	                        'update'=>'#'.CHtml::activeId($model,'id_recurso')
	                    ),*/
                    	'class'=>'form-control',
                	)
                )
	     	?>
			<?php echo $form->error($model,'id_procedimiento'); ?>
			<input type="hidden" id="tipoPro" value="0">
		</div>

    	<div id="row_recurso" style="display:none">
			<br>
		    <?php echo $form->labelEx($model,'id_recurso', array('class'=>'control-label')); ?>
	      	<?php
		      	echo $form->dropDownList($model, 'id_recurso',
			      	array(),
			      	array('class'=>'form-control')
		      	); 
	     	?>
		    <?php echo $form->error($model,'id_recurso'); ?>
		</div>
		
		<div id="row_maquina" style="display:none">
			<br>
		    <?php echo $form->labelEx($model,'id_maquina', array('class'=>'control-label')); ?>
	      	<?php
		      	echo $form->dropDownList($model, 'id_maquina',
			      	array(),
			      	array('class'=>'form-control')
		      	); 
	     	?>
		    <?php echo $form->error($model,'id_maquina'); ?>
		</div>
	
		<div>
			<br>
			<?php echo $form->labelEx($model,'fecha_inicio', array('class' => 'control-label')); ?>
			<?php
				$this->widget('booster.widgets.TbDatePicker',   
					array(
						'model'=>$model,
						'attribute'=>'fecha_inicio',
						'options' => array(
							'language' => "es",
							'autoclose'=>true,
							'format' => "yyyy-mm-dd",
						    'startDate' => date("Y-m-d"),
						    'endDate' => date("Y-m-d", strtotime('+1 year', strtotime(date("Y-m-d")))),
						    'beforeShowDay' => 'js:function(date){
						    	var available_Dates = '.$dias.';
				                var formattedDate = $.fn.datepicker.DPGlobal.formatDate(date, "yyyy-mm-dd", "es");
				                if($.inArray(formattedDate.toString(), available_Dates) == -1){
				                    return {
				                        enabled : true
				                    };
				                }else{
				                	return {
				                        enabled : false
				                    };
				                }
				                return;
				            }',
						    'orientation' => "bottom auto",
						),
						'htmlOptions' => array(
				        	'class'=>'form-control',
				    	),
					)
				);
			?>
			<?php echo $form->error($model,'fecha_inicio'); ?>
		</div><br>
			<div>
				<?php echo $form->labelEx($model,'fecha_fin', array('class' => 'control-label')); ?>
				<?php
					$this->widget('booster.widgets.TbDatePicker',   
						array(
							'model'=>$model,
							'attribute'=>'fecha_fin',
							'options' => array(
								'language' => "es",
								'autoclose'=>true,
								'format' => "yyyy-mm-dd",
							    'startDate' => date("Y-m-d"),
							    'endDate' => date("Y-m-d", strtotime('+1 year', strtotime(date("Y-m-d")))),
							    'beforeShowDay' => 'js:function(date){
							    	var available_Dates = '.$dias.';
					                var formattedDate = $.fn.datepicker.DPGlobal.formatDate(date, "yyyy-mm-dd", "es");
					                if($.inArray(formattedDate.toString(), available_Dates) == -1){
					                    return {
					                        enabled : true
					                    };
					                }else{
					                	return {
					                        enabled : false
					                    };
					                }
					                return;
					            }',
							    'orientation' => "bottom auto",
							),
							'htmlOptions' => array(
						        'class'=>'form-control',
						    ),
						)
					);
				?>
				<?php echo $form->error($model,'fecha_fin'); ?>
			</div><br>
			<div>
				<?php echo $form->labelEx($model,'hora_inicio', array('class' => 'control-label')); ?>
				<?php $this->widget(
				    'booster.widgets.TbTimePicker',
				    array(
				    	'model'=>$model,
						'attribute'=>'hora_inicio',
						'options' => array(
				            'showMeridian' => false,
				            //'maxHours' => 19,
				            'minuteStep' => 20,
				            'defaultTime' => '07:00',
				            //'timeFormat' => 'HH:mm:ss',
					        'minTime' => '07:00', // 11:45:00 AM,
					        //'maxMinutes' => 30,
					        //'startTime' => 'js:new Date(0,0,0,07,0,0)', // 3:00:00 PM - noon
					        //'interval' => 15, // 15 minutes
				        ),
                        'htmlOptions' => array(
                        	'class'=>'form-control'
                        ), 
				    )
				); ?>
				<?php echo $form->error($model,'hora_inicio'); ?>
			</div><br>
			<div>
				<?php echo $form->labelEx($model,'hora_fin', array('class' => 'control-label')); ?>
				<?php $this->widget('booster.widgets.TbTimePicker',
				    	array(
					        'model'=>$model,
							'attribute'=>'hora_fin',
							'options' => array(
					            'showMeridian' => false,
					            'minuteStep' => 20
					        ),
					        'htmlOptions' => array(
					        	'class'=>'form-control',
					        ),
					    )
					); 
				?>
				<?php echo $form->error($model,'hora_fin'); ?>
			</div>
		<br>
		<?php if(Yii::app()->user->hasFlash('error')): ?>
				<div class="alert alert-danger" id="msjError">
					<button type="button" class="close" id="cierraError" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p align='justify'>
		        		<big>
		        			<center><big><i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp;<?php echo Yii::app()->user->getFlash('error'); ?>
		           		</big>
		        	</p>
		        </div>
		    <?php endif; ?>
		<?php if(Yii::app()->user->hasFlash('exito')): ?>
				<div class="alert alert-success" id="alert-ok">
					<button type="button" class="close" id="cierraAlert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p align='justify'>
		        		<big>
		        			<center><big><i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp;<?php echo Yii::app()->user->getFlash('exito'); ?>
		           		</big>
		        	</p>
		        </div>
		    <?php endif; ?>
		<br>
		<div class="form-group">
			<?php echo CHtml::submitButton('Generar Disponibilidad', array('class' => 'btn-u btn-u-blue')); ?>
		</div>
		<center>
			<h4 id="labelDsip" style="display:none"><i class="glyphicon glyphicon-calendar"></i> Disponibilidad Actual</h4>
		</center>
		<div class="tag-box tag-box-v4" id="calendarioDisp" style="display:none">
		<!--<div class="form-group" id="calendarioDisp">-->

		<?php $this->endWidget(); ?>
	</div>
</div>

<script type="text/javascript">
	$(function($){
		var procedimiento = '<?= $model->id_procedimiento?>';
		if(procedimiento != "")
			traeTipo(procedimiento);	

		if($("#Disponibilidad_id_tipo_consulta").val() != "")
			traeProcedimiento();	

		$("#cierraError").click(function(){
			$("#msjError").hide();
		});

		$("#cierraAlert").click(function(){
			$("#alert-ok").hide();
		});
		//id_tipo_consulta
		$("#Disponibilidad_id_tipo_consulta").change(function(){
			$("#labelDsip").hide();
	    	$("#calendarioDisp").hide();
	    	if($("#Disponibilidad_id_tipo_consulta").val() == ""){
	    		$("#row_procedimiento").hide();
	    		$("#Disponibilidad_id_procedimiento").val('');
	    		$("#row_recurso").hide();
	    		$("#Disponibilidad_id_recurso").val('');
	    		$("#row_maquina").hide();
	    		$("#Disponibilidad_id_maquina").val('');
	    	}

			if($("#Disponibilidad_id_tipo_consulta").val() == "1"){
				traeProcedimiento();
				$("#row_procedimiento").show();
	    		$("#row_maquina").hide();
	    		$("#Disponibilidad_id_maquina").val('');
	    		$("#row_recurso").hide();
	    		$("#Disponibilidad_id_recurso").val('');
	    	}

	    	if($("#Disponibilidad_id_tipo_consulta").val() == "2"){
	    		traeProcedimiento();
	    		$("#row_procedimiento").show();
	    		$("#row_maquina").hide();
	    		$("#Disponibilidad_id_maquina").val('');
	    		$("#row_recurso").hide();
	    		$("#Disponibilidad_id_recurso").val('');
	    	}	
			
	    });  

	    $("#Disponibilidad_id_procedimiento").change(function(){
	    	$("#labelDsip").hide();
	    	$("#calendarioDisp").hide();
	    	$("#Disponibilidad_id_recurso").val('');
			$("#Disponibilidad_id_maquina").val('');
	    	if($("#Disponibilidad_id_procedimiento").val() != ""){
	    		traeTipo($("#Disponibilidad_id_procedimiento").val());
	    	}else{
	    		$("#row_recurso").hide();
	    		$("#row_maquina").hide();	    		
	    	}

	    });	

	    $("#Disponibilidad_id_recurso").change(function(){
	    	$("#labelDsip").hide();
	    	$("#calendarioDisp").hide();
	    	if($("#Disponibilidad_id_tipo_consulta").val() == "1"){
		    	if( ($("#Disponibilidad_id_procedimiento").val() != '') && ($("#Disponibilidad_id_recurso").val() != '') )
	          		traerDisponibilidad();
	        }
	        if($("#Disponibilidad_id_tipo_consulta").val() == "2"){
	          	if( ($("#Disponibilidad_id_procedimiento").val() != '') && ($("#Disponibilidad_id_recurso").val() != '') && ($("#Disponibilidad_id_maquina").val() != ''))
	          		traerDisponibilidad();
	        }
	    }); 

	    $("#Disponibilidad_id_maquina").change(function(){
	    	$("#labelDsip").hide();
	    	$("#calendarioDisp").hide();
	    	if( ($("#Disponibilidad_id_procedimiento").val() != '') && ($("#Disponibilidad_id_recurso").val() != '') && ($("#Disponibilidad_id_maquina").val() != ''))
	          		traerDisponibilidad();	    
	    }); 

	    $("#Disponibilidad_fecha_inicio").change(function(){
	    	//if($("#Disponibilidad_fecha_fin").val() != "" && $("#Disponibilidad_fecha_inicio").val() < $("#Disponibilidad_fecha_fin").val())
	    		$("#Disponibilidad_fecha_fin").val("");

	    	$('#Disponibilidad_fecha_fin').datepicker('setStartDate', $("#Disponibilidad_fecha_inicio").val());
	    }); 
	});
	function traerDisponibilidad(){
        <?php echo CHtml::ajax(array(
        	'url'=>array('disponibilidad/traerDisponibilidad'),
            //'url'=>$this->createUrl('/citas/disponibilidad/traerDisponibilidad'),
            'type'=>'post',
            'data'=>array(
            	'procedimiento'=>'js:$("#Disponibilidad_id_procedimiento").val()',
                'id_recurso'=>'js:$("#Disponibilidad_id_recurso").val()',
                'id_maquina'=>'js:$("#Disponibilidad_id_maquina").val()'            
            ), 
            'dataType'=>'json',
            'success'=> "function(data){
                if(data.status == \"success\"){
                     $('#calendarioDisp').html(data.content);
                }
            }"
        ))
        ?>;
        $("#labelDsip").show();
	    $("#calendarioDisp").show();

        return true;
	}
	function traeProcedimiento(){
		
		<?php echo CHtml::ajax(array(
        	'type'=>'POST',
            'url'=>array('disponibilidad/cargaProcedimiento'),
            'update'=>'#'.CHtml::activeId($model,'id_procedimiento'),
            'data'=>array(
                'id_tipo_consulta'=>'js:$("#Disponibilidad_id_tipo_consulta").val()',
                'proc'=>$model->id_procedimiento
            )
        ))
        ?>;
	}
	function traeTipo(id_pro){

		$("#row_recurso").show();
		<?php echo CHtml::ajax(array(
        	'type'=>'POST',
            'url'=>array('disponibilidad/cargaRecurso'),
            'update'=>'#'.CHtml::activeId($model,'id_recurso'),
            'data'=>array(
                'id_procedimiento'=>'js:id_pro',
                'recur'=>$model->id_recurso
            )
        ))
        ?>;

        <?php echo CHtml::ajax(array(
        	'type'=>'POST',
            'url'=>array('disponibilidad/tipoProcedimiento'),
            'data'=>array(
                'id_procedimiento'=>'js:id_pro'
            ),
            'dataType'=>'json',
            'success'=> "function(data){
                validaTipo(data.id_tipo_prestacion, data.identificador);
            }"
        ))
        ?>;
        return true;
	} 
	function validaTipo(tipo, id){
		if(tipo == "2"){
	    	<?php echo CHtml::ajax(array(
	        	'type'=>'POST',
	            'url'=>array('disponibilidad/cargaMaquina'),
	            'update'=>'#'.CHtml::activeId($model,'id_maquina'),
	            'data'=>array(
	                'examen'=>'js:id',
	                'maquina'=>$model->id_maquina
	            )
	        ))
	        ?>;
	    	$("#row_maquina").show();
		}else{
			$("#row_maquina").hide();
		}
	}
</script>