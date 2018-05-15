<div class="x_title">
	<div class='col-md-12'>
		<h2>Administrador de Cargue</h2>
	</div>
	<ul class="nav navbar-right panel_toolbox">
	</ul>
  <div class="clearfix"></div>
</div>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'cargue-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'ajaxType'=>'POST',
	'type' => 'striped',
	'afterAjaxUpdate' => 'reinstallDatePicker',
	'columns'=>array(
		array('header'=>'Codigo De Barras',
			'name'=>'codigo_barras',
			'type'=>'raw',
			'value'=>'$data->imagenCodigoBarras($data->codigo_barras)',
			'htmlOptions'=>array('class'=>'col-md-2', 'style'=>'text-align: center;')
		),
		array('header'=>'Asunto',
			'name'=>'asunto',
			'type'=>'raw',
			'value'=>'$data->asunto($data->id)',
			'htmlOptions'=>array('class'=>'col-md-3', 'style'=>'text-align: center;')
		),
		array('header'=>'Renta',
			'name'=>'renta',
			'value'=>'(!empty($data->renta)) ? $data->renta : " - "',
			'htmlOptions'=>array('class'=>'col-md-1', 'style'=>'text-align: center;')
		),
		array('header'=>'Fecha Radicación',
			'name'=>'fecha_radicacion',
			'value'=>'date("d/m/Y", strtotime($data->fecha_radicacion))',
			'htmlOptions'=>array('class'=>'col-md-2', 'style'=>'text-align: center;'),
			'filter' => $this->widget('booster.widgets.TbDatePicker',   
					array(
					'model' => $model,
					'attribute'=>'fecha_radicacion',
					'htmlOptions' => 
					array(
						'id' => 'fecha_radicacion_masivo',
						'format' => 'yy-mm-dd',
						'class' => 'form-control',
					),
					'options' => 
					array(
						'endDate' => date("dmY"),
						'format' => 'dd/mm/yyyy',
						'language' => "es",
						'autoclose'=>true,
					)
				),
	        true),
		),
		array('header'=>'Fecha De Cargue',
			'name'=>'fecha_cargue',
			'value'=>'date("d/m/Y", strtotime($data->fecha_cargue))',
			'htmlOptions'=>array('class'=>'col-md-2', 'style'=>'text-align: center;'),
			'filter' => $this->widget('booster.widgets.TbDatePicker',   
					array(
					'model' => $model,
					'attribute'=>'fecha_cargue',
					'htmlOptions' => 
					array(
						'id' => 'fecha_cargue_masivo',
						'format' => 'yy-mm-dd',
						'class' => 'form-control',
					),
					'options' => 
					array(
						'endDate' => date("dmY"),
						'format' => 'dd/mm/yyyy',
						'language' => "es",
						'autoclose'=>true,
					)
				),
	        true),
		),
		array('header'=>'Usuario De Cargue',
			'name'=>'usuario_cargue',
			'type'=>'raw',
			//'value'=>'ucwords(strtolower($data->usuarioCargue->nombres." ".$data->usuarioCargue->apellidos))',
			'value'=>'$data->nombresUsuario(ucwords(strtolower($data->usuarioCargue->nombres)), ucwords(strtolower($data->usuarioCargue->apellidos)))',
			'htmlOptions'=>array('class'=>'col-md-2', 'style'=>'text-align: center;')
		),
		/*array('header'=>'Archivo',
			'type'=>'raw',
			'value'=>'$data->imagen($data->codigo_barras)',
			'htmlOptions'=>array('style'=>'text-align: center;')
		),*/
		array(
			//'header'=>'Recepcionar',
			'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{recepcionar}',
			'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'col-md-1'),
			'buttons' => array(
				'recepcionar' => array(
					'label'=>false,
					'url'=>'base64_encode($data->id)',
					'icon'=>'glyphicon glyphicon-log-out',
					'visible'=>'($data->imagen($data->codigo_barras) != "No")',
					'options'=>array('style'=> 'font-size: 1.2em;'),
					'click'=> 'js:function(){return recepcionar(this);}',
				),
			)
		),
	),
)); 
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
   $('#fecha_cargue_masivo, #fecha_radicacion_masivo').datepicker({'endDate':'<?php date(\"dmY\"); ?>','format':'dd/mm/yyyy','language':'es','autoclose':true});
}
");
?>
<script type="text/javascript">
	function recepcionar(id){
		var rcp = $(id).attr("href");
		location.href="<?=Yii::app()->createUrl('/cargueMasivo/recepcion/?rcp')?>="+rcp;
	    return false;
	}	
</script>