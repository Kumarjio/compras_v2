<?php
$this->breadcrumbs=array(
	'Cartas Fisicases'=>array('admin'),
	'Administrar',
);
$this->setPageTitle('Punteo Cartas Firma Fisica');
?>
<div class="x_title">
  <h2>Punteo Cartas Firma Fisica</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<div class="col-md-12" align="right">
	<?php $this->widget(
    'booster.widgets.TbButton',
    array(
    	'icon'=>'glyphicon glyphicon-list-alt',
        'label' => 'Excel',
        'context' => 'success',
        'id'=>'punteo_exel'
    )
);  ?>
</div>
<br>
<br>
<div class="panel panel-blue margin-bottom-40">
	<div class="panel-body"> 
		<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'cartas-fisicas-grid',
			'dataProvider'=>$model->search(),
			'type' => 'striped',
			'afterAjaxUpdate'=>'function(id, data){$(\'.select-on-check\').on(\'change\',function(e){actualizar(this);});}',
			//'filter'=>$model,
			'columns'=>
				array(
					array(
						'header'=>'Puntear',
						'class'=>'CCheckBoxColumn',
            			'id'=>'chbx',
            			'value'=>'$data->id_cartas',
                        'checkBoxHtmlOptions'=>array(
                                'checked'=>'checked',
                        ),  
					),
			array('header'=>'Caso',
					'value'=>'$data->idCartas->na',
					'filter'=> CHtml::textField('na','',array('class'=>'form-control')),
				),
			array('header'=>'Destinatario',
					'value'=>'$data->idCartas->nombre_destinatario',
					'filter'=> CHtml::textField('destinatario','',array('class'=>'form-control')),),
			array('header'=>'Principal',
					'value'=>'$data->idCartas->principal',
					'filter'=> CHtml::dropDownList('principal','',array('Si'=>'Si','No'=>'No'),array('class'=>'form-control','prompt'=>''))),
			array('header'=>'Courrier',
					'value'=>'$data->idCartas->proveedor0->proveedor',
					'filter'=> CHtml::dropDownList('proveedor','',array('1'=>'Certificado 472','2'=>'Servientrega'),array('class'=>'form-control','prompt'=>''))),
			array('header'=>'Dirección',
					'value'=>'$data->direccion',
					'filter'=> CHtml::textField('direcccion','',array('class'=>'form-control')),),
			array('header'=>'Tipología',
					'value'=>'$data->idCartas->na0->tipologia0->tipologia',
					'filter'=> CHtml::textField('tipologia','',array('class'=>'form-control')),),
			array('header'=>'Área',
					'value'=>'$data->idCartas->na0->tipologia0->area0->area',
					'filter'=> CHtml::textField('area','',array('class'=>'form-control')),),
			array('header'=>'Fecha',
					'value'=>'$data->idCartas->na0->fecha_entrega',
					'filter'=> CHtml::textField('fecha','',array('class'=>'form-control')),),
			array('header'=>'Hora',
					'value'=>'$data->idCartas->na0->hora_entrega',
					'filter'=> CHtml::textField('hora','',array('class'=>'form-control')),),
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>
	</div>
</div>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-punteo')
); ?>
<div class="modal-header">
    <h4 align="center"><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/carta.png','this is alt tag of image',
        array('width'=>'20','height'=>'20','title'=>'Usuario')); 
        echo CHtml::link($image); ?> Cartas</h4>
</div>
<div class="modal-body" id="body-punteo">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-prerrequisito')
); ?>
<div class="modal-header">
    <h4 align="center"><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/warning.png','this is alt tag of image',
        array('width'=>'20','height'=>'20','title'=>'Usuario')); 
        echo CHtml::link($image); ?> Atención</h4>
</div>
<div class="modal-body">
	<h5 align="center " class="red">Debe puntear para generar registros.</h5 align="center">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.select-on-check').on('change',function(e){
			actualizar(this);
		});
	});
	function actualizar(selector){
		var id = selector.value;
		<?php echo CHtml::ajax(
	      array(
	        'type' => 'POST',
	        'data' => array('id' => 'js:id'),
	        'url' => $this->createUrl("cartasFisicas/punteo"),

	        'success' => 'function(res){
	           	 	$("#cartas-fisicas-grid").yiiGridView.update("cartas-fisicas-grid");	
	             	$("#modal-punteo #body-punteo").html(res);
	             	$("#modal-punteo").modal("show");
	        }'
	      )
	    );?>
	}
	function actualizaPunteo(){
		<?php echo CHtml::ajax(
	      array(
	        'type' => 'POST',
	        'url' => $this->createUrl("actualizaPunteo"),
	        'success' => 'function(res){
	        }'
	      )
	    );?>
	}
	$("#punteo_exel").click(function(){
		<?php echo CHtml::ajax(
	      array(
	        'type' => 'POST',
	        'url' => $this->createUrl("consultaRegistros"),
	        'success' => 'function(res){
	        	if(res != ""){
	        		if(confirm("¿Desea descargar informe punteados?")){
	        			location.href="http://"+document.domain+"/correspondencia/index.php/cartasFisicas/punteoExcel";
	        		}
	        	}else{
	        		$("#modal-prerrequisito").modal("show");
	        	}
	        }'
	      )
	    );?>
	});
</script>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>