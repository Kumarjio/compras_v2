<div class="x_title">
	<div class='col-md-12'>
		<h2>Plantillas</h2>
	</div>
	<ul class="nav navbar-right panel_toolbox">
	</ul>
  <div class="clearfix"></div>
</div>
<br>
<div class='col-md-1'>
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit',
			'icon'=>'glyphicon glyphicon-edit',
			'type'=>'info',
			'label'=>'Nueva Plantilla',
      		'htmlOptions' => array('id'=>'crear_plantilla'), 
		)); ?>
	</div>
</div>
<div class='col-md-9'></div>
<div class='col-md-2'>
	<?php echo CHtml::activeTextField($model,'buscar',array('class'=>'form-control','maxlength'=>'24','placeholder'=>'Consulta plantilla...')); ?>
</div>
<div class="row">
</div>
<br>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'plantilla-grid',
	'dataProvider'=>$model->search_detalle(),
	//'filter'=>$model,
	'filterSelector'=>'{filter}, #PlantillasCartas_buscar, select',
	'ajaxType'=>'POST',
	'type' => 'striped',
	'columns'=>array(
		array('header'=>'Plantilla',
			  'name'=>'nombre',
			  'value'=>'ucwords(strtolower($data->nombre))'),
		array(
		'header'=>'Modificar',
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{update}',
        'buttons' => array(
          'update' => array(
              'label'=>'Modificar',
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-pencil',
			  'options'=>array('style'=> 'font-size: 1.3em;'),
              'visible' => '$data->id != 1',
              'click'=> 'js:function(){return validaUpdate(this);}',
          ),
        )
      ),
      array(
      	'header'=>'Tipologías',
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{tipologias}',
        'buttons' => array(
          'tipologias' => array(
              'label'=>'Tipologias',
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-eye-open',
			  'options'=>array('style'=> 'font-size: 1.3em;'),
              'visible' => '$data->id != 1',
              'click'=> 'js:function(){return tipologias(this);}',
          ),
        )
      ),
      array(
      	'header'=>'Habilitar / Inhabilitar',	
	    'class'=>'booster.widgets.TbButtonColumn',
	    'template'=>'{inhabilitar}{habilitar}',
	    'buttons' => array(
	    	'inhabilitar' => array(
	          'label'=>'Inhabilitar',
	          'url'=>'$data->id',
	          'icon'=>'glyphicon glyphicon-remove',
			  'options'=>array('style'=> 'font-size: 1.3em;'),
	          'visible' => '$data->id != 1 && $data->activa',
	          'click'=> 'js:function(){return inhabilitar(this);}',
	      ),
	     	'habilitar' => array(
	          'label'=>'Habilitar',
	          'url'=>'$data->id',
	          'icon'=>'glyphicon glyphicon-ok',
			  'options'=>array('style'=> 'font-size: 1.3em;'),
	          'visible' => '$data->id != 1 && !$data->activa',
	          'click'=> 'js:function(){return habilitar(this);}',
	      ),
	    )
	  ),
	),
)); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'dialogo-plantilla')
); ?>
<div class="modal-header">
	<h4><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/plantilla.png','this is alt tag of image',
        array('width'=>'20','height'=>'20')); 
        echo CHtml::link($image); ?> Plantillas</h4>
</div>
<div class="modal-body" id="body-plantilla">
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
$("#crear_plantilla").click(function(){
	<?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'url' => $this->createUrl("create"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-plantilla #body-plantilla").html(data.content);
	        		$("#dialogo-plantilla").modal("show");
	        	}
	      }'
	    )
	);?>
});
function tipologias(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("plantillaTipologia/index"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-plantilla #body-plantilla").html(data.content);
	        		$("#dialogo-plantilla").modal("show");
	        	}
	      }'
	    )
	);?>
    return false;
}
function inhabilitar(id){
	var id = $(id).attr("href");
	bootbox.confirm({
	    message: "<h4>¿Esta seguro de inhabilitar esta plantilla?</h4>",
	    buttons: {
	        confirm: {
	            label: "Confirmar",
	            className: "btn-info"
	        },
	        cancel: {
	            label: "Cancelar",
	            className: "btn-default"
	        }
	    },
	    callback: function (confirm) {
		    if(confirm){
			    <?php echo CHtml::ajax(
				    array(
				      'type' => 'POST',
				      'data' => array('id' => 'js:id'),
				      'url' => $this->createUrl("inhabilitar"),
				      'success' => 'function(res){
				      	if(res){
							$("#dialogo-plantilla #body-plantilla").html(res);
				        	$("#dialogo-plantilla").modal("show");
				        	$("#plantilla-grid").yiiGridView.update("plantilla-grid");
				      	}
				      }'
				    )
				);?>
		    }
	    }
  	});
  return false;
}
function habilitar(id){
	var id = $(id).attr("href");
		bootbox.confirm({
	    message: "<h4>¿Esta seguro de Habilitar esta plantilla?</h4>",
	    buttons: {
	        confirm: {
	            label: "Confirmar",
	            className: "btn-info"
	        },
	        cancel: {
	            label: "Cancelar",
	            className: "btn-default"
	        }
	    },
	    callback: function (confirm) {
		    if(confirm){
			    <?php echo CHtml::ajax(
				    array(
				      'type' => 'POST',
				      'data' => array('id' => 'js:id'),
				      'url' => $this->createUrl("habilitar"),
				      'success' => 'function(res){
				      	if(res){
							$("#dialogo-plantilla #body-plantilla").html(res);
				        	$("#dialogo-plantilla").modal("show");
				        	$("#plantilla-grid").yiiGridView.update("plantilla-grid");
				      	}
				      }'
				    )
				);?>
		    }
	    }
  	});
  return false;
}
function validaUpdate(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("validarUpdate"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	      			update(id);
	        	}else{
	        		$("#dialogo-plantilla #body-plantilla").html(data.content);
	        		$("#dialogo-plantilla").modal("show");
	        	}
	      }'
	    )
	);?>
    return false;
}
function update(id){
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("update"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-plantilla #body-plantilla").html(data.content);
	        		$("#dialogo-plantilla").modal("show");
	        	}
	      }'
	    )
	);?>
}
</script>