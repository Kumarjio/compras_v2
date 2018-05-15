<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'flujo-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class='col-md-4'>
 	<?php echo CHtml::activeLabel($model,'id_tipología'); ?>
	<div class="form-group">
		<?php echo $form->dropDownList($model,'id_tipología', Tipologias::model()->cargaTipologias(),array('class'=>'form-control','prompt'=>'...')); ?>
	</div>
</div>
<div class='col-md-7'>
</div>
<div class='col-md-1' align="center">
	.
	<div class="form-group">
		<h3><?php echo CHtml::link('', $this->createUrl("#"), array('class'=>'glyphicon glyphicon-plus','id'=>'agregar', 'title'=>'Agregar') );?></h3>
	</div>
</div>
<!--<div class='col-md-1' align="left">
	.
	<div class="form-group">
		<h3><?php echo CHtml::link('', $this->createUrl("#"), array('class'=>'glyphicon glyphicon-trash', 'data-toggle' => 'modal', 'data-target' => '#dialogo-eliminar','id'=>'eliminar', 'title'=>'Eliminar') );?></h3>
	</div>
</div>-->
<div class="row">
</div>
<br>
<br>
<div class='col-md-12 oculto' id="tabla">
	<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'flujo-grid',
	'dataProvider'=>$model->search_detalle(''),
	'template' => "{items}",
	'type' => 'striped',
	'responsiveTable' => true,
	'columns'=>array(
			array('name'=>'Actividad','value'=>'$data->actividad0->actividad'),
			array('name'=>'Sucesión','value'=>'$data->sucesion0->actividad'),
			array(
	        'class'=>'booster.widgets.TbButtonColumn',
	        'template'=>'{editar}',
	        'buttons' => array(
	          'editar' => array(
	              'label'=>'Editar',
	              'url'=>'$data->id',
	              'icon'=>'glyphicon glyphicon-pencil',
			  	  'options'=>array('style'=> 'font-size: 1.5em;'),
	              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
	              'click'=> 'js:function(){return editar(this);}',
	          ),
	        )
	      ),
	      array(
	        'class'=>'booster.widgets.TbButtonColumn',
	        'template'=>'{usuarios}',
	        'buttons' => array(
	          'usuarios' => array(
	              'label'=>'usuarios',
	              'url'=>'$data->id',
	              'icon'=>'glyphicon glyphicon-eye-open',
			      'options'=>array('style'=> 'font-size: 1.5em;'),
	              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
	              'click'=> 'js:function(){return usuarios(this);}',
	          ),
	        )
	      ),
	      array(
	        'class'=>'booster.widgets.TbButtonColumn',
	        'template'=>'{eliminar}',
	        'buttons' => array(
	          'eliminar' => array(
	              'label'=>'Eliminar',
	              'url'=>'$data->id',
	              'icon'=>'glyphicon glyphicon-trash',
			      'options'=>array('style'=> 'font-size: 1.5em;'),
	              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
	              'click'=> 'js:function(){return eliminar(this);}',
	          ),
	        )
	      ),
	),
	)); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'dialogo-editar')
); ?>
<div class="modal-header">
    <h4>Gestión de actividad</h4>
</div>
<div class="modal-body" id="body-editar">
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
    array('id' => 'dialogo-agregar')
); ?>
<div class="modal-header">
    <h4>Agregar Actividad</h4>
</div>
<div class="modal-body" id="body-agregar">
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
$("#Flujo_tipologia").change(function(){
	tipologia = $("#Flujo_tipologia").val();
	if(tipologia != ""){
		$.fn.yiiGridView.update('flujo-grid',
			{data:{'tipologia':this.value}}
		);
		$("#tabla").show();
	}else{
		$("#tabla").hide();
	}
});
$("#editar").click(function(){
	tipologia = $("#Flujo_tipologia").val();
	if(tipologia == ""){
		alert("Seleccione una tipologia");
		return false;
	}else{
	<?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'data' => array('tipologia' => 'js:tipologia'),
          'url' => $this->createUrl("registro"),
          'success' => 'function(res){
          	if(res == ""){
          		alert("La tipologia seleccionada aun no tiene registros para editar");
          	}
          }'
        )
      );?>
	  <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('tipologia' => 'js:tipologia'),
	      'url' => $this->createUrl("editar"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-editar #body-editar").html(data.content);
	        		$("#dialogo-editar").modal("show");
	        	}
	      }'
	    )
	  );?>
	  return false;
	}
});
$("#agregar").click(function(){
	tipologia = $("#Flujo_tipologia").val();
	if(tipologia == ""){
		alert("Seleccione una tipologia");
		return false;
	}else{
	  <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('tipologia' => 'js:tipologia'),
	      'url' => $this->createUrl("crearFlujo"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-editar #body-editar").html(data.content);
	        		$("#dialogo-editar").modal("show");
	        	}
	      }'
	    )
	  );?>
	  return false;
	}
});
$("#eliminar").click(function(){
	tipologia = $("#Flujo_tipologia").val();
	if(tipologia == ""){
		alert("Seleccione una tipologia");
		return false;
	}else{
		if(confirm("¿Desea eliminar el flujo?")){		
		  <?php echo CHtml::ajax(
		    array(
		      'type' => 'POST',
		      'data' => array('tipologia' => 'js:tipologia'),
		      'url' => $this->createUrl("eliminarFlujo"),
		      'dataType'=>'json',
		      'success' => 'function(data){
		      	$("#flujo-grid").yiiGridView.update("flujo-grid");

		      }'
		    )
		  );?>
		  return false;
		}
	}
});
function editar(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("editar"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-editar #body-editar").html(data.content);
	        		$("#dialogo-editar").modal("show");
	        	}
	      }'
	    )
	);?>
    return false;
}
function eliminar(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("eliminar"),
	      'dataType'=>'json',
	      'success' => 'function(data){
			$("#flujo-grid").yiiGridView.update("flujo-grid");
	      }'
	    )
	);?>
    return false;
}
function usuarios(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("usuariosFlujo/index"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-editar #body-editar").html(data.content);
	        		$("#dialogo-editar").modal("show");
	        	}
	      }'
	    )
	);?>
    return false;
}
</script>