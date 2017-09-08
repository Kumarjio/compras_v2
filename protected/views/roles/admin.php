<div class="x_title">
  <h2>Roles</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<br>
<div class='col-md-1'>
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit', 
			'type'=>'primary',
			'icon'=>'glyphicon glyphicon-user',
			'label'=>$model->isNewRecord ? 'Nuevo Rol' : 'Guardar',
      		'htmlOptions' => array('id'=>'crear_rol'), 
		)); ?>
	</div>
</div>
<div class="row">
</div>
<br>
<br>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'rol-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'type' => 'striped bordered condensed',
	'columns'=>array(
		array('name'=>'roles','value'=>'$data->rol'),
		array(
		'header'=>'Modificar',	
	    'class'=>'booster.widgets.TbButtonColumn',
	    'template'=>'{update_rol}',
	    'buttons' => array(
	      	'update_rol' => array(
	          'label'=>'Modificar',
	          'url'=>'$data->id',
	          'icon'=>'glyphicon glyphicon-pencil',
	          'click'=> 'js:function(){return update_roles(this);}',
	      ),
	    )
	  ),
		array(
		'header'=>'Permisos',	
	    'class'=>'booster.widgets.TbButtonColumn',
	    'template'=>'{permisos}',
	    'buttons' => array(
	    	'permisos' => array(
	          'label'=>'Permisos',
	          'url'=>'$data->id',
	          'icon'=>'glyphicon glyphicon-eye-open',
	          'click'=> 'js:function(){return permisos(this);}',
	      ),
	    )
	  ),
	  array(
		'header'=>'Inhabilitar',	
	    'class'=>'booster.widgets.TbButtonColumn',
	    'template'=>'{inhabilitar}',
	    'buttons' => array(
	    	'inhabilitar' => array(
	          'label'=>'Inhabilitar',
	          'url'=>'$data->id',
	          'icon'=>'glyphicon glyphicon-remove',
	          'click'=> 'js:function(){return validacion(this);}',
	      ),
	    )
	  ),			
	),
)); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'dialogo-rol')
); ?>
<div class="modal-header">
	<h4><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/roles.png','this is alt tag of image',
        array('width'=>'20','height'=>'20')); 
        echo CHtml::link($image); ?> Roles</h4>
</div>
<div class="modal-body" id="body-rol">
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
$("#crear_rol").click(function(){
	<?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'url' => $this->createUrl("create"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-rol #body-rol").html(data.content);
	        		$("#dialogo-rol").modal("show");
	        	}
	      }'
	    )
	);?>
});
function update_roles(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("update"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-rol #body-rol").html(data.content);
	        		$("#dialogo-rol").modal("show");
	        	}
	      }'
	    )
	);?>
    return false;
}
function permisos(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("permisosRoles/index"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-rol #body-rol").html(data.content);
	        		$("#dialogo-rol").modal("show");
	        	}
	      }'
	    )
	);?>
    return false;
}
function validacion(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("valida"),
	      'success' => 'function(res){
	      	if(res){
	      		$("#dialogo-rol #body-rol").html(res);
	        	$("#dialogo-rol").modal("show");
	      	}else{
	      		inhabilitar(id);
	      	}
	      }'
	    )
	);?>
    return false;
}
function inhabilitar(id){
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("inhabilitar"),
	      'success' => 'function(res){
	      	if(res){
	      		$("#dialogo-rol #body-rol").html(res);
	        	$("#dialogo-rol").modal("show");
	        	$("#rol-grid").yiiGridView.update("rol-grid");
	      	}
	      }'
	    )
	);?>
    return false;
}
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