
<div class="x_title">

	<div class="row">
		<div class="col-md-6">
			<h1>Informe Ahorro CYC</h1>
			
		</div>
		<div class="col-md-6">
			
			<div align="right">
				
				<?php

				$this->widget(
				    'booster.widgets.TbButtonGroup',
				    array(    
				        'size' => 'large',
				        'buttons' => array(array(
				          'label'=>'Acciones',
				          'items'=>
				            array(
								array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'fa fa-bank'),
								array('label'=>'Crear','url'=>array('create'), 'icon'=>'fa fa-plus'),
				            ),  
				          )
				      )
				    )
				);
				?>
			</div>
		</div>
	</div>
</div>
<div class="x_content">
	<div class="row">
		<div class="col-md-12">
			
				<?php $this->widget('booster.widgets.TbGridView',array(
					'id'=>'ahorro-grid',
					'dataProvider'=>$model->search(),
					'type'=>'striped bordered condensed',
					'filter'=>$model,
					'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
					'columns'=>array(
						array(
						      'header' => 'Número de solicitud',
						      'name' => 'orden',
						      'type' => 'raw',
						      //'value' => '"<a href=\"update/id/".$data->id."\">".$data->id."</a>"',
						      'value' => 'CHtml::link($data->orden, Yii::app()->createUrl("orden/print", array("orden"=>$data->orden)))'
						      ),
						array(
						      'header' => 'Tipo de compra',
						      'name' => 'tipo',
						      'htmlOptions'=>array('style' => 'text-align: right;')
						      ),

						array(
						      'header' => 'Descripción de la compra',
						      'name' => 'compra',
						      'htmlOptions'=>array('style' => 'text-align: right;')
						      ),
				                array(
				                    'name'=>'nombre',
				                    'value'=>'$data->getNombre()'
				                ),
						
						array(
				                    'name' => 'fecha',
				                    'value'=>'date("Y-m-d", strtotime($data->fecha))'
				                ),
						array(
				                    'name' => 'promedio',
				                    'type'=>'number',
				                    'htmlOptions'=>array('style' => 'text-align: right;')
				                ),
						array(
				                    'name' => 'selecionada',
				                    'type'=>'number',
				                    'htmlOptions'=>array('style' => 'text-align: right;')
				                ),
						array(
				                    'name' => 'ahorro',
				                    'type'=>'number',
				                    'htmlOptions'=>array('style' => 'text-align: right;')
				                ),
						array(
				                    'header'=>'%',
				                    'name' => 'porcentaje',//Yii::app()->numberFormatter->formatPercentage(
				                    'value'=>  'Yii::app()->numberFormatter->formatNumber(array("maxDecimalDigits"=>2, "multiplier"=>1, "negativePrefix"=>"(","negativeSuffix"=>")"),$data->porcentaje) . "%"',
				                    'htmlOptions'=>array('style' => 'text-align: right;')
				                ),
						array(
						      'header' => 'moneda',
						      'name' => 'moneda',
						      'htmlOptions'=>array('style' => 'text-align: right;')
						      ),
						array(
						      'header' => 'trm',
						      'name' => 'trm',
						      'htmlOptions'=>array('style' => 'text-align: right;')
						      ),
						array(
						      'header' => 'negociador',
						      'name' => 'negociante',
						      'htmlOptions'=>array('style' => 'text-align: right;')
						      ),
					),
				)); ?>
		</div>
	</div>
</div>
