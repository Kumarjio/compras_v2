<div class="well" id="proveedor-<?php echo $model->nit; ?>">

	<div id="proveedor-vinculado-<?php echo $model->nit; ?>" >
		  <div class="well">
			<h4>Archivos Adjuntos</h4><br/>
		  	<?php 
			$this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'adjuntos-willies-grid-'.$model->nit,
			'dataProvider'=>$archivos_w->search($w->id),
			'type'=>'striped bordered condensed',
			'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
			'columns'=>array(
		        'nombre',
				'tipi',
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
		            'template' => '{download}{delete}',
		            'deleteButtonUrl'=>'Yii::app()->createUrl("/adjuntosWillies/delete", array("id" =>  $data["id"], "ajax" => 1))',
		            'buttons' => array(
		                'download' => array(
		                  'icon'=>'arrow-down',
		                  'url'=>'Yii::app()->createUrl("/adjuntosWillies/download", array("id" =>  $data["id"]))',
		                  'options' => array(
		                      'target' => '_blank'
		                   )
		                ),
		                'delete' => array(
				                  'visible' => "false",
		                 )
		            )
				),
			),
			)); ?>
		  </div>
		</div>
	<div id="informacion-polizas-<?php echo $model->nit; ?>">
		<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array( 
		    'id'=>'documentos-vpj-form', 
		    'enableAjaxValidation'=>false,
		)); ?>
		<div class="well">
		<h4>Información de las pólizas</h4><br/>
		<p><?php $d = $dvpj->polizas(); echo ($d == null or $d == '')?"No se seleccionó ninguna póliza.":""; ?> </p>
		    <?php echo $form->errorSummary($w); ?>
			<?php echo $form->errorSummary($dvpj); ?>

			<?php
				if($dvpj->requiere_polizas_cumplimiento == 1){
					echo "<div class='well'>";
					echo '<label for="DocumentosVpj_fe_polizas_cumplimiento" class="required">'.$dvpj->getAttributeLabel('fe_polizas_cumplimiento').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fe_polizas_cumplimiento',
				    	'name'=>'fe_polizas_cumplimiento',
				    	'language' => 'es',
						'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo '<label for="DocumentosVpj_fv_polizas_cumplimiento" class="required">'.$dvpj->getAttributeLabel('fv_polizas_cumplimiento').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fv_polizas_cumplimiento',
				    	'name'=>'fv_polizas_cumplimiento',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo $form->checkBoxRow($dvpj,'renovacion_polizas_cumplimiento',array('onClick' => 'if(this.checked){$("#polizas_cumplimiento_renovacion").removeAttr("disabled"); $("#polizas_cumplimiento_renovacion").slideDown();}else{$("#polizas_cumplimiento_renovacion").attr("disabled","disabled"); $("#polizas_cumplimiento_renovacion").slideUp();}'));
					echo ($dvpj->renovacion_polizas_cumplimiento == 1)?"<div id='polizas_cumplimiento_renovacion'>":"<div id='polizas_cumplimiento_renovacion' style='display:none'>";
					echo '<label for="DocumentosVpj_fr_polizas_cumplimiento" class="required">'.$dvpj->getAttributeLabel('fr_polizas_cumplimiento').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fr_polizas_cumplimiento',
				    	'name'=>'fr_polizas_cumplimiento',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo "</div>";
					echo "</div>";
				}
			
				if($dvpj->requiere_seriedad_oferta == 1){
					echo "<div class='well'>";
					echo '<label for="DocumentosVpj_fe_seriedad_oferta" class="required">'.$dvpj->getAttributeLabel('fe_seriedad_oferta').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fe_seriedad_oferta',
				    	'name'=>'fe_seriedad_oferta',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo '<label for="DocumentosVpj_fv_seriedad_oferta" class="required">'.$dvpj->getAttributeLabel('fv_seriedad_oferta').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fv_seriedad_oferta',
				    	'name'=>'fv_seriedad_oferta',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo $form->checkBoxRow($dvpj,'renovacion_seriedad_oferta',array('onClick' => 'if(this.checked){$("#seriedad_oferta_renovacion").removeAttr("disabled"); $("#seriedad_oferta_renovacion").slideDown();}else{$("#seriedad_oferta_renovacion").attr("disabled","disabled"); $("#seriedad_oferta_renovacion").slideUp();}'));
					echo ($dvpj->renovacion_seriedad_oferta == 1)?"<div id='seriedad_oferta_renovacion'>":"<div id='seriedad_oferta_renovacion' style='display:none'>";
					echo '<label for="DocumentosVpj_fr_seriedad_oferta" class="required">'.$dvpj->getAttributeLabel('fr_seriedad_oferta').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fr_seriedad_oferta',
				    	'name'=>'fr_seriedad_oferta',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo "</div>";
					echo "</div>";
				}
				
				if($dvpj->requiere_buen_manejo_anticipo == 1){
					echo "<div class='well'>";
					echo '<label for="DocumentosVpj_fe_buen_manejo_anticipo" class="required">'.$dvpj->getAttributeLabel('fe_buen_manejo_anticipo').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fe_buen_manejo_anticipo',
				    	'name'=>'fe_buen_manejo_anticipo',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo '<label for="DocumentosVpj_fv_buen_manejo_anticipo" class="required">'.$dvpj->getAttributeLabel('fv_buen_manejo_anticipo').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fv_buen_manejo_anticipo',
				    	'name'=>'fv_buen_manejo_anticipo',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo $form->checkBoxRow($dvpj,'renovacion_buen_manejo_anticipo',array('onClick' => 'if(this.checked){$("#buen_manejo_anticipo_renovacion").removeAttr("disabled"); $("#buen_manejo_anticipo_renovacion").slideDown();}else{$("#buen_manejo_anticipo_renovacion").attr("disabled","disabled"); $("#buen_manejo_anticipo_renovacion").slideUp();}'));
					echo ($dvpj->renovacion_buen_manejo_anticipo == 1)?"<div id='buen_manejo_anticipo_renovacion'>":"<div id='buen_manejo_anticipo_renovacion' style='display:none'>";
					echo '<label for="DocumentosVpj_fr_buen_manejo_anticipo" class="required">'.$dvpj->getAttributeLabel('fr_buen_manejo_anticipo').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fr_buen_manejo_anticipo',
				    	'name'=>'fr_buen_manejo_anticipo',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo "</div>";
					echo "</div>";
				}
				
				if($dvpj->requiere_calidad_suministro == 1){
					echo "<div class='well'>";
					echo '<label for="DocumentosVpj_fe_calidad_suministro" class="required">'.$dvpj->getAttributeLabel('fe_calidad_suministro').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fe_calidad_suministro',
				    	'name'=>'fe_calidad_suministro',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo '<label for="DocumentosVpj_fv_calidad_suministro" class="required">'.$dvpj->getAttributeLabel('fv_calidad_suministro').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fv_calidad_suministro',
				    	'name'=>'fv_calidad_suministro',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo $form->checkBoxRow($dvpj,'renovacion_calidad_suministro',array('onClick' => 'if(this.checked){$("#calidad_suministro_renovacion").removeAttr("disabled"); $("#calidad_suministro_renovacion").slideDown();}else{$("#calidad_suministro_renovacion").attr("disabled","disabled"); $("#calidad_suministro_renovacion").slideUp();}'));
					echo ($dvpj->renovacion_calidad_suministro == 1)?"<div id='calidad_suministro_renovacion'>":"<div id='calidad_suministro_renovacion' style='display:none'>";
					echo '<label for="DocumentosVpj_fr_calidad_suministro" class="required">'.$dvpj->getAttributeLabel('fr_calidad_suministro').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fr_calidad_suministro',
				    	'name'=>'fr_calidad_suministro',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo "</div>";
					echo "</div>";
				}
				
				if($dvpj->requiere_calidad_correcto_funcionamiento == 1){
					echo "<div class='well'>";
					echo '<label for="DocumentosVpj_fe_calidad_correcto_funcionamiento" class="required">'.$dvpj->getAttributeLabel('fe_calidad_correcto_funcionamiento').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fe_calidad_correcto_funcionamiento',
				    	'name'=>'fe_calidad_correcto_funcionamiento',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo '<label for="DocumentosVpj_fv_calidad_correcto_funcionamiento" class="required">'.$dvpj->getAttributeLabel('fv_calidad_correcto_funcionamiento').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fv_calidad_correcto_funcionamiento',
				    	'name'=>'fv_calidad_correcto_funcionamiento',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo $form->checkBoxRow($dvpj,'renovacion_calidad_correcto_funcionamiento',array('onClick' => 'if(this.checked){$("#calidad_correcto_funcionamiento_renovacion").removeAttr("disabled"); $("#calidad_correcto_funcionamiento_renovacion").slideDown();}else{$("#calidad_correcto_funcionamiento_renovacion").attr("disabled","disabled"); $("#calidad_correcto_funcionamiento_renovacion").slideUp();}'));
					echo ($dvpj->renovacion_calidad_correcto_funcionamiento == 1)?"<div id='calidad_correcto_funcionamiento_renovacion'>":"<div id='calidad_correcto_funcionamiento_renovacion' style='display:none'>";
					echo '<label for="DocumentosVpj_fr_calidad_correcto_funcionamiento" class="required">'.$dvpj->getAttributeLabel('fr_calidad_correcto_funcionamiento').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fr_calidad_correcto_funcionamiento',
				    	'name'=>'fr_calidad_correcto_funcionamiento',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo "</div>";
					echo "</div>";
				}
				
				if($dvpj->requiere_pago_salario_prestaciones == 1){
					echo "<div class='well'>";
					echo '<label for="DocumentosVpj_fe_pago_salario_prestaciones" class="required">'.$dvpj->getAttributeLabel('fe_pago_salario_prestaciones').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fe_pago_salario_prestaciones',
				    	'name'=>'fe_pago_salario_prestaciones',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo '<label for="DocumentosVpj_fv_pago_salario_prestaciones" class="required">'.$dvpj->getAttributeLabel('fv_pago_salario_prestaciones').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fv_pago_salario_prestaciones',
				    	'name'=>'fv_pago_salario_prestaciones',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo $form->checkBoxRow($dvpj,'renovacion_pago_salario_prestaciones',array('onClick' => 'if(this.checked){$("#pago_salario_prestaciones_renovacion").removeAttr("disabled"); $("#pago_salario_prestaciones_renovacion").slideDown();}else{$("#pago_salario_prestaciones_renovacion").attr("disabled","disabled"); $("#pago_salario_prestaciones_renovacion").slideUp();}'));
					echo ($dvpj->renovacion_pago_salario_prestaciones == 1)?"<div id='pago_salario_prestaciones_renovacion'>":"<div id='pago_salario_prestaciones_renovacion' style='display:none'>";
					echo '<label for="DocumentosVpj_fr_pago_salario_prestaciones" class="required">'.$dvpj->getAttributeLabel('fr_pago_salario_prestaciones').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fr_pago_salario_prestaciones',
				    	'name'=>'fr_pago_salario_prestaciones',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo "</div>";
					echo "</div>";
				}
				
				if($dvpj->requiere_estabilidad_oferta == 1){
					echo "<div class='well'>";
					echo '<label for="DocumentosVpj_fe_estabilidad_oferta" class="required">'.$dvpj->getAttributeLabel('fe_estabilidad_oferta').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fe_estabilidad_oferta',
				    	'name'=>'fe_estabilidad_oferta',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo '<label for="DocumentosVpj_fv_estabilidad_oferta" class="required">'.$dvpj->getAttributeLabel('fv_estabilidad_oferta').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fv_estabilidad_oferta',
				    	'name'=>'fv_estabilidad_oferta',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo $form->checkBoxRow($dvpj,'renovacion_estabilidad_oferta',array('onClick' => 'if(this.checked){$("#estabilidad_oferta_renovacion").removeAttr("disabled"); $("#estabilidad_oferta_renovacion").slideDown();}else{$("#estabilidad_oferta_renovacion").attr("disabled","disabled"); $("#estabilidad_oferta_renovacion").slideUp();}'));
					echo ($dvpj->renovacion_estabilidad_oferta == 1)?"<div id='estabilidad_oferta_renovacion'>":"<div id='estabilidad_oferta_renovacion' style='display:none'>";
					echo '<label for="DocumentosVpj_fr_estabilidad_oferta" class="required">'.$dvpj->getAttributeLabel('fr_estabilidad_oferta').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fr_estabilidad_oferta',
				    	'name'=>'fr_estabilidad_oferta',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo "</div>";
					echo "</div>";
				}
				
				if($dvpj->requiere_responsabilidad_civil_extracontractual == 1){
					echo "<div class='well'>";
					echo '<label for="DocumentosVpj_fe_responsabilidad_civil_extracontractual" class="required">'.$dvpj->getAttributeLabel('fe_responsabilidad_civil_extracontractual').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fe_responsabilidad_civil_extracontractual',
				    	'name'=>'fe_responsabilidad_civil_extracontractual',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo '<label for="DocumentosVpj_fv_responsabilidad_civil_extracontractual" class="required">'.$dvpj->getAttributeLabel('fv_responsabilidad_civil_extracontractual').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fv_responsabilidad_civil_extracontractual',
				    	'name'=>'fv_responsabilidad_civil_extracontractual',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo $form->checkBoxRow($dvpj,'renovacion_responsabilidad_civil_extracontractual',array('onClick' => 'if(this.checked){$("#responsabilidad_civil_extracontractual_renovacion").removeAttr("disabled"); $("#responsabilidad_civil_extracontractual_renovacion").slideDown();}else{$("#responsabilidad_civil_extracontractual_renovacion").attr("disabled","disabled"); $("#responsabilidad_civil_extracontractual_renovacion").slideUp();}'));
					echo ($dvpj->renovacion_responsabilidad_civil_extracontractual == 1)?"<div id='responsabilidad_civil_extracontractual_renovacion'>":"<div id='responsabilidad_civil_extracontractual_renovacion' style='display:none'>";
					echo '<label for="DocumentosVpj_fr_responsabilidad_civil_extracontractual" class="required">'.$dvpj->getAttributeLabel('fr_responsabilidad_civil_extracontractual').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fr_responsabilidad_civil_extracontractual',
				    	'name'=>'fr_responsabilidad_civil_extracontractual',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo "</div>";
					echo "</div>";
				}
				
				if($dvpj->requiere_calidad_obra == 1){
					echo "<div class='well'>";
					echo '<label for="DocumentosVpj_fe_calidad_obra" class="required">'.$dvpj->getAttributeLabel('fe_calidad_obra').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fe_calidad_obra',
				    	'name'=>'fe_calidad_obra',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo '<label for="DocumentosVpj_fv_calidad_obra" class="required">'.$dvpj->getAttributeLabel('fv_calidad_obra').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fv_calidad_obra',
				    	'name'=>'fv_calidad_obra',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo $form->checkBoxRow($dvpj,'renovacion_calidad_obra',array('onClick' => 'if(this.checked){$("#calidad_obra_renovacion").removeAttr("disabled"); $("#calidad_obra_renovacion").slideDown();}else{$("#calidad_obra_renovacion").attr("disabled","disabled"); $("#calidad_obra_renovacion").slideUp();}'));
					echo ($dvpj->renovacion_calidad_obra == 1)?"<div id='calidad_obra_renovacion'>":"<div id='calidad_obra_renovacion' style='display:none'>";
					echo '<label for="DocumentosVpj_fr_calidad_obra" class="required">'.$dvpj->getAttributeLabel('fr_calidad_obra').'<span class="required"> *</span></label>';
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$dvpj,
						'attribute'=>'fr_calidad_obra',
				    	'name'=>'fr_calidad_obra',
				    	'language' => 'es',
				    	'options'=>array('showAnim'=>'fold', 'dateFormat' => 'yy-mm-dd', 'changeMonth' => true, 'changeYear' => true),
				    	'htmlOptions'=>array('class'=>'span3 numeric'),
					));
					echo "</div>";
					echo "</div>";
				}
			
			?>
	
			</br>
			<div class="alert alert-block alert-warning fade in">
			<?php echo $form->textAreaRow($w,'observacion', array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
			</div>
	</div>
		    <div class="form-actions"> 
		        <?php 
				$this->widget('bootstrap.widgets.BootButton', array(
					'buttonType'=>'button',
					'type'=>'warning',
					'label'=>'Enviar Ajustes en las Pólizas Requeridas',
					'htmlOptions' => array(
						'onClick'=>	'{$("#documentos-vpj-form").attr("action","/index.php/Willies/devolverPolizas/id/'.$w->id.'"); $("#documentos-vpj-form").submit()}'
							)
				)); 
				?>
				<?php 
				$this->widget('bootstrap.widgets.BootButton', array(
					'buttonType'=>'button',
					'type'=>'primary',
					'label'=>'Pólizas Validadas Correctamente',
					'htmlOptions' => array(
						'onClick'=>	'{$("#documentos-vpj-form").attr("action","/index.php/Willies/enviarPolizas/id/'.$w->id.'"); $("#documentos-vpj-form").submit()}'
							)
				)); 
				?>
		    </div> 

		<?php $this->endWidget(); ?>

	</div>
</div>