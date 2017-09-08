<div class="x_title">
  <h2>Usuarios</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<br>
<div class='col-md-1'>
	<div class="form-actions"> 
		<?php $this->widget('bootstrap.widgets.BootButton', array( 
			'buttonType'=>'submit',
			'icon'=>'glyphicon glyphicon-user',
			'type'=>'success',
			'label'=>$model->isNewRecord ? 'Nuevo Usuario' : 'Guardar',
      		'htmlOptions' => array('id'=>'crear_usuario'), 
		)); ?>
	</div>
</div>
<div class="row">
</div>
<br>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'usuario-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => 'striped',
	'columns'=>array(
		array('name'=>'usuario','value'=>'$data->usuario'),
		array('name'=>'nombres','value'=>'ucwords(strtolower($data->nombres))'),
		array('name'=>'apellidos','value'=>'ucwords(strtolower($data->apellidos))'),
		array('name'=>'correo','value'=>'$data->correo'),
		array('name'=>'fecha_creacion','value'=>'$data->fecha_creacion'),
		array('name'=>'cargo','value'=>'$data->cargo0->cargo'),
		array('name'=>'area','value'=>'$data->area0->area'),
		array(
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{update}',
        'buttons' => array(
          'update' => array(
              'label'=>'Actualizar',
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-pencil',
              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
              'click'=> 'js:function(){return update(this);}',
          ),
        )
      ),
      array(
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{roles}',
        'buttons' => array(
          'roles' => array(
              'label'=>'Roles',
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-eye-open',
              //'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
              'click'=> 'js:function(){return roles(this);}',
          ),
        )
      ),
      array(	
	    'class'=>'booster.widgets.TbButtonColumn',
	    'template'=>'{inhabilitar}',
	    'buttons' => array(
	    	'inhabilitar' => array(
	          'label'=>'Inhabilitar',
	          'url'=>'$data->usuario',
	          'icon'=>'glyphicon glyphicon-remove',
	          'click'=> 'js:function(){return validacion(this);}',
	      ),
	    )
	  ),
	),
)); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'dialogo-usuario')
); ?>
<div class="modal-header">
	<h4><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/users.png','this is alt tag of image',
        array('width'=>'20','height'=>'20')); 
        echo CHtml::link($image); ?> Usuarios</h4>
</div>
<div class="modal-body" id="body-usuario">
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
$("#crear_usuario").click(function(){
	<?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'url' => $this->createUrl("create"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-usuario #body-usuario").html(data.content);
	        		$("#dialogo-usuario").modal("show");
	        	}
	      }'
	    )
	);?>
});
function update(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("update"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-usuario #body-usuario").html(data.content);
	        		$("#dialogo-usuario").modal("show");
	        	}
	      }'
	    )
	);?>
    return false;
}
function roles(id){
    var id = $(id).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("usuariosRoles/usuariosRoles"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-usuario #body-usuario").html(data.content);
	        		$("#dialogo-usuario").modal("show");
	        	}
	      }'
	    )
	);?>
    return false;
}
function validacion(usuario){
    var usuario = $(usuario).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('usuario' => 'js:usuario'),
	      'url' => $this->createUrl("valida"),
	      'success' => 'function(res){
	      	if(res){
	      		$("#dialogo-usuario #body-usuario").html(res);
	        	$("#dialogo-usuario").modal("show");
	      	}else{
	      		inhabilitar(usuario);
	      	}
	      }'
	    )
	);?>
    return false;
}
function inhabilitar(usuario){
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('usuario' => 'js:usuario'),
	      'url' => $this->createUrl("inhabilitar"),
	      'success' => 'function(res){
	      	if(res){
	      		$("#dialogo-usuario #body-usuario").html(res);
	        	$("#dialogo-usuario").modal("show");
	        	$("#usuario-grid").yiiGridView.update("usuario-grid");
	      	}
	      }'
	    )
	);?>
}
</script>