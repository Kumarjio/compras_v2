<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
		'id'=>'documento-proveedor-form',
		'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); ?>
<table class="detail-view table table-striped table-condensed" ><tbody>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('nombre_contrato')); ?></th>
<td> <?php echo CHtml::encode($data->nombre_contrato); ?></td>
</tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('proveedor')); ?></th>
<td> <?php echo CHtml::encode($data->proveedor); ?></td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('fecha_inicio')); ?></th>
<td><?php echo CHtml::encode($data->fecha_inicio); ?></td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('fecha_fin')); ?></th>
		<td>
			<div id="fecha_fin_vista">
			<?php
			if($data->fecha_fin>0  ){
			 echo CHtml::encode($data->fecha_fin);
		  }
		  if($data->fecha_fin_ind  ){
			 echo 'Indefinido';
		  }
			?>
			</div>
			<div id="fecha_fin_campo" class="hidden">
			<?php if($model->fecha_fin == ''){ ?>
		<?php	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
               'model'=>$model,
               'attribute'=>'fecha_fin',
               'language' => 'es',
               'options'=>array(
                       'showAnim'=>'fold',
                       'dateFormat' => 'yy-mm-dd',
                       'changeMonth'=> true,
					   'changeYear'=> true,

                       ),'htmlOptions'=>array(
                               'style'=>'height:20px;',
                               'class' => 'span2'
                               )
               )
       ); 
			} ?>
			<?php echo $form->checkBox($model,'fecha_fin_ind',array('class'=>'span1','onclick'=>'bloquear_fecha_fin()')); ?>Indefinido
			</div>
		</td>
		<td>
			<?php if($model->fecha_fin != ''): ?>
			<?php 	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
               'model'=>$model, 
               'attribute'=>'fecha_fin',
               'language' => 'es',
               'options'=>array(
                       'showAnim'=>'fold',
                       'dateFormat' => 'yy-mm-dd',
                       'changeMonth'=> true,
           'changeYear'=> true,

                       ),'htmlOptions'=>array(
                               'style'=>'height:20px;',
                               'class' => 'span2'
                               )
               )
       );   ?>
	   <?php 

	   echo $form->checkBox($model,'fecha_fin_ind',array('class'=>'span1','onclick'=>'bloquear_fecha_fin2(this.checked);'));   ?>Indefinido
	  
			<?php else: ?>
				<?php echo CHtml::checkBox('ck_fecha_fin',false,array('class'=>'span2')); ?>
			<?php endif; ?>
		</td>
</tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('objeto')); ?></th>
<td style="text-align:justify"><?php echo CHtml::encode($data->objeto); ?></td></tr>
<tr><th><?php echo CHtml::encode($data->getAttributeLabel('fecha_firma')); ?></th>
<td><?php echo CHtml::encode($data->fecha_firma); ?></td></tr>
<tr>
	<th>
		<?php echo CHtml::encode($data->getAttributeLabel('valor')); ?>
	</th>
	<td>
		<div id="valor_vista">
		<?php
		if($data->valor>0  ){
		 echo CHtml::encode( ($data->valor/intval($data->valor))==1 ? number_format($data->valor) : round($data->valor*100)/100 )." ( ".$data->moneda." )";
	  }
		?>
		</div>
		<div id="valor_campo" class="hidden">
			<?php echo $form->textField($model,'valor',array('class'=>'span2 maskValor')); ?>
		</div>
	</td>
	<td>
		<?php if($model->valor != ''): ?>
			<?php echo $form->textField($model,'valor',array('class'=>'span2 maskValor')); ?>
		<?php else: ?>

			<?php echo CHtml::checkBox('ck_valor',false,array('class'=>'span2')); ?>
		<?php endif; ?>
            <div class="span2">
                <?php echo $form->dropDownListRow($model, 'moneda', CHtml::listData(Cotizacion::model()->getMonedas(), "id", "nombre"), array('class'=>'span2','prompt'=>'seleccione')); ?>
            </div>
                
                        
	</td>
</tr>
<tr>
	<th>
		<?php echo CHtml::encode($data->getAttributeLabel('cuerpo_contrato')); ?>
	</th>
	<td>
		<?php echo CHtml::encode($data->cuerpo_contrato); ?>
	</td>
	<td>
	</td>
</tr>
<tr >
	<th>
		<?php echo CHtml::encode($data->getAttributeLabel('proroga_automatica')); ?>
	</th>
	<td>
		<div id="proroga_vista">
			<?php echo DocumentoProrroga::getNombreProrroga($data->proroga_automatica); ?>
		</div>
		<div id="proroga_campo" class="hidden">
		<?php if($model->proroga_automatica == ''){ ?>
			<?php echo $form->dropDownList($model,
			'proroga_automatica',
			DocumentoProrroga::model()->GetListaProrroga(),
	  		array('prompt' => 'Seleccione...','class'=>'span2','onclick'=>'bloquear();'));
		}
	?>
		</div>
	</td>
	<td>
		<?php  if($model->proroga_automatica != ''): 
		
		echo $form->dropDownList($model,
			'proroga_automatica',
			DocumentoProrroga::model()->GetListaProrroga(),
	  		array('prompt' => 'Seleccione...','class'=>'span2','onclick'=>'bloquear();')); ?>
		<?php else: ?>
			<?php echo CHtml::checkBox('ck_proroga',false,array('class'=>'span2')); ?>
		<?php endif; ?>
	</td>
</tr>
<tr>
	<th>
		<?php echo CHtml::encode($data->getAttributeLabel('tiempo_proroga')); ?>
	</th>
	<td>
		<div id="tiempo_pro_vista">
			<?php echo CHtml::encode($data->tiempo_proroga); ?>
		</div>
		<div id="tiempo_pro_campo" class="hidden">
			<?php echo "Años:";
				echo $form->textField($model,'tiempo_pro_anio',	array('class'=>"span1"));
				echo "<br> Meses: ";
				echo $form->textField($model,'tiempo_pro_mes',	array('class'=>"span1"));
				echo "<br> Dias: ";
				echo $form->textField($model,'tiempo_pro_dia',	array('class'=>"span1"));
			?>
		</div>
	</td>
	<td>
		<?php if($model->tiempo_proroga != ''): ?>
			<?php echo "Años:";
				echo $form->textField($model,'tiempo_pro_anio',	array('class'=>"span1"));
				echo "<br> Meses: ";
				echo $form->textField($model,'tiempo_pro_mes',	array('class'=>"span1"));
				echo "<br> Dias: ";
				echo $form->textField($model,'tiempo_pro_dia',	array('class'=>"span1"));
			?>
		<?php else: ?>
			<?php echo CHtml::checkBox('ck_tiempo_pro',false,array('class'=>'span2')); ?>
		<?php endif; ?>
	</td>
</tr>
<tr>
	<th><?php echo CHtml::encode($data->getAttributeLabel('tiempo_preaviso')); ?></th>
	<td>
		<div id="tiempo_pre_vista">
			<?php echo CHtml::encode($data->tiempo_preaviso); ?>
		</div>
		<div id="tiempo_pre_campo" class="hidden">
			<?php echo "Años:";
				echo $form->textField($model,'tiempo_pre_anio',	array('class'=>"span1"));
				echo "<br> Meses: ";
				echo $form->textField($model,'tiempo_pre_mes',	array('class'=>"span1"));
				echo "<br> Dias: ";
				echo $form->textField($model,'tiempo_pre_dia',	array('class'=>"span1"));
						?>
		</div>
	</td>
	<td>
		<?php if($model->tiempo_preaviso != ''): ?>
			<?php echo "Años:";
				echo $form->textField($model,'tiempo_pre_anio',	array('class'=>"span1"));
				echo "<br> Meses: ";
				echo $form->textField($model,'tiempo_pre_mes',	array('class'=>"span1"));
				echo "<br> Dias: ";
				echo $form->textField($model,'tiempo_pre_dia',	array('class'=>"span1"));
						?>
		<?php else: ?>

			<?php echo CHtml::checkBox('ck_tiempo_pre',false,array('class'=>'span2')); ?>
		<?php endif; ?>
	</td>
</tr>
<tr ><th><?php echo CHtml::encode($data->getAttributeLabel('responsable_proveedor')); ?></th>
<td><?php echo CHtml::encode($data->responsable_proveedor); ?></td><td><?php //echo $form->checkBox($model,'responsable_proveedor',array('class'=>'span2')); ?></td></tr>
<tr ><th><?php echo CHtml::encode($data->getAttributeLabel('polizas')); ?></th>
<td><?php echo CHtml::encode($data->polizas); ?></td><td><?php //echo $form->checkBox($model,'polizas',array('class'=>'span2')); ?></td></tr>
<tr ><th><?php echo CHtml::encode($data->getAttributeLabel('anexos')); ?></th>
<td><?php echo CHtml::encode($data->anexos); ?></td><td><?php //echo $form->checkBox($model,'anexos',array('class'=>'span2')); ?></td></tr>

</tbody></table>
<?php echo $form->errorSummary($model);
/*
echo $form->labelEx($model,'fecha_inicio_otrosi');
			 $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'attribute'=>'fecha_inicio_otrosi',
							'language' => 'es',
							'options'=>array(
											'showAnim'=>'fold',
											'dateFormat' => 'yy-mm-dd',
											'changeMonth'=> true,
					'changeYear'=> true,
					'minDate'=>$data->fecha_inicio,
					'defaultDate'=>$data->fecha_inicio,
											),'htmlOptions'=>array(
															'style'=>'height:20px;',
															'data-sync' => 'true',
															'class' => 'span5'
															)
							)
			);
 echo $form->labelEx($model,'fecha_fin_otrosi');
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
               'model'=>$model,
               'attribute'=>'fecha_fin_otrosi',
               'language' => 'es',
               'options'=>array(
                       'showAnim'=>'fold',
                       'dateFormat' => 'yy-mm-dd',
                       'changeMonth'=> true,
           'changeYear'=> true,

                       ),'htmlOptions'=>array(
                               'style'=>'height:20px;',
                               'data-sync' => 'true',
                               'class' => 'span5'
                               )
               )
       );*/
	 echo $form->labelEx($model,'fecha_firma');
		 $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'fecha_firma',
			'language' => 'es',
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat' => 'yy-mm-dd',
				'changeMonth'=> true,
                    'changeYear'=> true,
				),'htmlOptions'=>array(
					'style'=>'height:20px;',
					'data-sync' => 'true',
					'class' => 'span5'
				)
			)
		);
		?>
	<?php echo $form->textAreaRow($model,'observacion_otrosi',array('class'=>'span5')); ?>

<? if($edita){ ?>
    <div class="well">
        <br/>
        <?php $this->widget('bootstrap.widgets.BootButton', array(
                                            'label'=>'Relacionar Otro Proveedor',
                                            'url'=>'#newProv',
                                            'type'=>'primary',
                                            'htmlOptions'=>array('data-toggle'=>'modal', 'style' => 'margin:-9px 0px 0px 35px; '),
                                        )); ?>
         
        <?php 
        $this->widget('bootstrap.widgets.BootGridView',array(
          	'id'=>'proveedores-grid-otrosi',
          	'dataProvider'=> DocumentoProveedorAdicional::model()->search($model->id_docpro),
          	'type'=>'striped bordered condensed',
            'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
          	'columns'=>array(
            'proveedor',
            array(
                'header'=>'Razón Social',
                'value'=>'$data->idProveedor->razon_social'
            ),
            array(
            	'header'=>'Eliminar',
              	'class'=>'bootstrap.widgets.BootButtonColumn',
              	'template' => '{delete}',
              	'buttons'=>array(
			        'delete' => array(
			        	'label'=>false,
			            'url'=>'$data->id_docproadi',
			            'click'=>'function(){deleteProveedor($(this).parent().find("a").attr("href"));return false;}',
			            'options'=>array('class'=>'icon-trash'),
			        ),
			    ),
            ),
          ),
        )); ?>
        </div>
<? } ?> 

<? if($edita){ ?>
	<br/>
            <p>Si requiere modificar un archivo pdf por favor ingrese en el siguiente campo una o varias sucesiones de im&aacute;genes por ejemplo: 1-5,8,10-20, se guardara un archivo con las p&aacute;ginas 1 a la 5, 8, continuando con las p&aacute;ginas 10 a la 20.</p>
            <?php echo CHtml::textField('paginas'); ?>
	<br/>
<? } ?>
	<?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Guardar ',
			)); ?>
<? if($edita){ ?>
        <br/><br/>    
            <?php echo $form->fileField($model,'archivo_cambio');?>
            <?php $this->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Reemplazar Imagen',
			)); ?>
<? } ?>  

	<?php $this->endWidget(); ?>


<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'newProv', 'htmlOptions' => array('class' => 'hide', 'data-backdrop' => 'static'))); ?>
<div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar cuenta contable</h3>
  </div>
   
  <div id="modal-content" class="modal-body">
  	<div align="right">
	  	<?
	  		$this->widget( 'bootstrap.widgets.BootButton',array(
	            	'buttonType'=>'button', 
	                'type'=>'primary', 
	                'icon'=>'plus-sign white',
	                'label'=>'Crear Proovedor',
	                'htmlOptions'=>array(
						'id'=>'btnCrea'
					),
	            )						
			); ?>
	</div>
	<br>      
  <?php 
  $this->widget('bootstrap.widgets.BootGridView',array(
    'id'=>'proveedores-seleccion-grid',
    'dataProvider'=>  $proveedores->searchAgregar($model->id_docpro),
    'type'=>'striped bordered condensed',
    'filter'=>  $proveedores,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
    'columns'=>array(
      'nit',
      'razon_social',
      array(
        'class'=>'bootstrap.widgets.BootButtonColumn',
        'template' => '{select}',
        'buttons'=>array(
                    'select' => array(
                          'label' => "<i class='icon-ok'></i>", 
                          'url' => 'Yii::app()->createUrl("documentoProveedor/addProveedor", array("id_docpro"=>'.$model->id_docpro.', "nit" => $data->nit))',
                          'options'=>array(
                             'title' => 'Seleccionar',  
                              'class'=> 'adiccionar-proveedor',
                             "onClick"  => '(function(e, obj){ 
                                $("#newProv").modal("hide");
                              })(event, this)',                            
                          ),
                        ),
                  ),
      ),
    ),
  )); ?>

  </div>
  <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array(
          'label'=>'Cerrar',
          'url'=>'#',
          'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("proveedores-grid-otrosi");'),
      )); ?>
  </div>
<?php $this->endWidget(); ?>

	<script type="text/javascript">

	$('#ck_valor').live("click", function(e){
		var box = this;
        if(box.checked){
        	$('#valor_campo').removeClass('hidden');
        	$('#valor_vista').addClass('hidden');
        	var texto = $('#DocumentoProveedor_valor').val();
        	if(texto == ''){
				$('#DocumentoProveedor_valor').val('<?php echo $data->valor ?>');
        	}

        }
        else {
        	$('#valor_vista').removeClass('hidden');
        	$('#valor_campo').addClass('hidden');
        	$('#DocumentoProveedor_valor').val('<?php echo $model->valor ?>');
        }
	});

	$('#ck_fecha_fin').live("click", function(e){
		var box = this;
        if(box.checked){
        	$('#fecha_fin_campo').removeClass('hidden');
        	$('#fecha_fin_vista').addClass('hidden');
        	var texto = $('#DocumentoProveedor_fecha_fin').val();
        	if(texto == ''){
							$('#DocumentoProveedor_fecha_fin').val('<?php echo $data->fecha_fin ?>');
        	}
        }
        else {
        	$('#fecha_fin_vista').removeClass('hidden');
        	$('#fecha_fin_campo').addClass('hidden');
        	$('#DocumentoProveedor_fecha_fin').val('<?php echo $model->fecha_fin ?>');
        }
	});

	$('#ck_proroga').live("click", function(e){
		var box = this;
        if(box.checked){
        	$('#proroga_campo').removeClass('hidden');
        	$('#proroga_vista').addClass('hidden');
        	var texto = $('#DocumentoProveedor_proroga_automatica').val();
        	if(texto == ''){
				$('#DocumentoProveedor_proroga_automatica').val('<?php echo $data->proroga_automatica ?>');
        	}

        }
        else {
        	$('#proroga_vista').removeClass('hidden');
        	$('#proroga_campo').addClass('hidden');
        	$('#DocumentoProveedor_proroga_automatica').val('<?php echo $model->proroga_automatica ?>');
        }
	});

	$('#ck_tiempo_pro').live("click", function(e){
		var box = this;
        if(box.checked){
        	$('#tiempo_pro_campo').removeClass('hidden');
        	$('#tiempo_pro_vista').addClass('hidden');
        	var anio = $('#DocumentoProveedor_tiempo_pro_anio').val();
        	if(anio == ''){
				$('#DocumentoProveedor_tiempo_pro_anio').val('<?php echo $data->tiempo_pro_anio ?>');
        	}
        	var mes = $('#DocumentoProveedor_tiempo_pro_mes').val();
        	if(mes == ''){
				$('#DocumentoProveedor_tiempo_pro_mes').val('<?php echo $data->tiempo_pro_mes ?>');
        	}
        	var dia = $('#DocumentoProveedor_tiempo_pro_anio').val();
        	if(dia == ''){
				$('#DocumentoProveedor_tiempo_pro_dia').val('<?php echo $data->tiempo_pro_dia ?>');
        	}

        }
        else {
        	$('#tiempo_pro_vista').removeClass('hidden');
        	$('#tiempo_pro_campo').addClass('hidden');
				  $('#DocumentoProveedor_tiempo_pro_anio').val('<?php echo $model->tiempo_pro_anio ?>');
				  $('#DocumentoProveedor_tiempo_pro_mes').val('<?php echo $model->tiempo_pro_mes ?>');
				  $('#DocumentoProveedor_tiempo_pro_dia').val('<?php echo $model->tiempo_pro_dia ?>');
        }
	});

	$('#ck_tiempo_pre').live("click", function(e){
		var box = this;
        if(box.checked){
        	$('#tiempo_pre_campo').removeClass('hidden');
        	$('#tiempo_pre_vista').addClass('hidden');
        	var anio = $('#DocumentoProveedor_tiempo_pre_anio').val();
        	if(anio == ''){
				$('#DocumentoProveedor_tiempo_pre_anio').val('<?php echo $data->tiempo_pre_anio ?>');
        	}
        	var mes = $('#DocumentoProveedor_tiempo_pro_mes').val();
        	if(mes == ''){
				$('#DocumentoProveedor_tiempo_pre_mes').val('<?php echo $data->tiempo_pre_mes ?>');
        	}
        	var dia = $('#DocumentoProveedor_tiempo_pre_anio').val();
        	if(dia == ''){
				$('#DocumentoProveedor_tiempo_pre_dia').val('<?php echo $data->tiempo_pre_dia ?>');
        	}

        }
        else {
        	$('#tiempo_pre_vista').removeClass('hidden');
        	$('#tiempo_pre_campo').addClass('hidden');
					$('#DocumentoProveedor_tiempo_pre_anio').val('<?php echo $model->tiempo_pre_anio ?>');
					$('#DocumentoProveedor_tiempo_pre_mes').val('<?php echo $model->tiempo_pre_mes ?>');
					$('#DocumentoProveedor_tiempo_pre_dia').val('<?php echo $model->tiempo_pre_dia ?>');
        }
	});

// formato de campos y restricciones en fecha_fin_otrosi

$("#DocumentoProveedor_observacion_otrosi").bind('keyup', function (e) {
    if (e.which >= 97 && e.which <= 122) {
        var newKey = e.which - 32;
        // I have tried setting those
        e.keyCode = newKey;
        e.charCode = newKey;
    }
    $("#DocumentoProveedor_observacion_otrosi").val(($("#DocumentoProveedor_observacion_otrosi").val()).toUpperCase());
});
 $(document).ready(function() {
	$("#DocumentoProveedor_fecha_inicio_otrosi").change(function(){
			$("#DocumentoProveedor_fecha_fin_otrosi").val("");
			$('#DocumentoProveedor_fecha_fin_otrosi').datepicker('option','minDate', $("#DocumentoProveedor_fecha_inicio_otrosi").val());
		  $('#DocumentoProveedor_fecha_fin_otrosi').datepicker('option','defaultDate', $("#DocumentoProveedor_fecha_inicio_otrosi").val());
			$('#DocumentoProveedor_fecha_fin_otrosi').datepicker('option','defaultDate', $("#DocumentoProveedor_fecha_inicio_otrosi").val());
			$('#DocumentoProveedor_fecha_firma').datepicker('option','defaultDate', $("#DocumentoProveedor_fecha_inicio_otrosi").val());
	});
        $('.maskValor').maskMoney({decimal:'.',precision:2, allowZero:true});
	 $('#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_dia').maskMoney();
	$('#DocumentoProveedor_tiempo_pre_anio,#DocumentoProveedor_tiempo_pre_mes,#DocumentoProveedor_tiempo_pre_dia').maskMoney();
	
verifica_bloqueo();
  function verifica_bloqueo(){
	  var p_a_mod='<?=$model->proroga_automatica ?>';
	  var p_a_dat='<?=$data->proroga_automatica ?>';
	  
    if(  (p_a_mod==2) || (p_a_mod=='' && p_a_dat==2)){
        $('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').val(0);
        $('#DocumentoProveedor_tiempo_pre_anio,#DocumentoProveedor_tiempo_pre_mes,#DocumentoProveedor_tiempo_pre_dia').val(0);
        $('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').prop('disabled', true);
        $('#DocumentoProveedor_tiempo_pre_anio,#DocumentoProveedor_tiempo_pre_mes,#DocumentoProveedor_tiempo_pre_dia').prop('disabled', true);
    }
	
	
    if( $('#DocumentoProveedor_valor_indefinido').is(':checked')) {
        $('#DocumentoProveedor_valor').val(0);
        $("#DocumentoProveedor_valor").prop('disabled', true);
    }
  }

  $(".adiccionar-proveedor").live("click", function(e){
        e.preventDefault();
        addProveedor($(this).attr("href"));
    });
	
});
	function bloquear() {
		if($('#DocumentoProveedor_proroga_automatica').val()=='2'){
		   $('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').val(0);
		   $('#DocumentoProveedor_tiempo_pre_anio,#DocumentoProveedor_tiempo_pre_mes,#DocumentoProveedor_tiempo_pre_dia').val(0);
		   $('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').prop('disabled', true);
		   $('#DocumentoProveedor_tiempo_pre_anio,#DocumentoProveedor_tiempo_pre_mes,#DocumentoProveedor_tiempo_pre_dia').prop('disabled', true);
		}else{
			$('#DocumentoProveedor_tiempo_pro_anio,#DocumentoProveedor_tiempo_pro_mes,#DocumentoProveedor_tiempo_pro_dia').prop('disabled', false);
			$('#DocumentoProveedor_tiempo_pre_anio,#DocumentoProveedor_tiempo_pre_mes,#DocumentoProveedor_tiempo_pre_dia').prop('disabled', false);
		}

	}
	
	function bloquear_fecha_fin(){
		if( $('#DocumentoProveedor_fecha_fin_ind').is(':checked')) {
			$('#DocumentoProveedor_fecha_fin').val('');
			$("#DocumentoProveedor_fecha_fin").prop('disabled', true);
		}else{
			$("#DocumentoProveedor_fecha_fin").prop('disabled', false);
			}
    }	 	
	
	function bloquear_fecha_fin2(valor){
		if( valor==1) {
			$('#DocumentoProveedor_fecha_fin').val('');
			$("#DocumentoProveedor_fecha_fin").prop('disabled', true);
		}else{
			$("#DocumentoProveedor_fecha_fin").prop('disabled', false);
			}
    }	
    

    function addProveedor(url){
	    jQuery.ajax({'url': url ,'type':'post','dataType':'json','success':function(data)
	        {
	            if(data.status == 'success'){
	                $('#newProv').modal('hide');
	                resetGridView("proveedores-grid-otrosi");
	                resetGridView("proveedores-seleccion-grid");
	            }

	        } ,'cache':false});
	    
	    return false;  
    }

    function deleteProveedor(id){
    	if(confirm("¿Esta seguro de eliminar el proveedor?")) {
	    	<?	echo CHtml::ajax(array(
	            'url'=>array('documentoProveedor/deleteProvAdicional'), 
	            'data'=>array('id'=>'js:id'), 
	            'dataType'=>'json',
	            'success'=> "function(data){	  
            		resetGridView('proveedores-grid-otrosi'); 
	            }"
	        ))
			?>;
		}
    }
	</script>
