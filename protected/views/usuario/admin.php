<div class="x_title">
  <h2>Usuarios </h2>
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
	'afterAjaxUpdate' => 'reinstallDatePicker',
	'columns'=>array(
		/*array(
			'name'=>'usuario',
			'type'=>'html',
			'value'=>'$data->usuario'
		),*/
	 	array(
            'name'=>'usuario',
            'type'=>'raw',
            'value'=>'$data->linkUsuario($data->usuario)',
        ),			
		array('name'=>'nombres','value'=>'ucwords(strtolower($data->nombres))'),
		array('name'=>'apellidos','value'=>'ucwords(strtolower($data->apellidos))'),
		array('name'=>'correo','value'=>'$data->correo'),
		array(
            'name' => 'fecha_creacion','value'=>'date("d/m/Y"." - "."h:i:s a", strtotime($data->fecha_creacion))',
            'filter' => $this->widget('booster.widgets.TbDatePicker',   
				array(
				'model' => $model,
				'attribute'=>'fecha_creacion',
				'htmlOptions' => 
				array(
					'id' => 'Usuario_fecha_creacion',
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
		//array('name'=>'area','value'=>'$data->area0->area'),
		array(
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{update}',
        'buttons' => array(
          'update' => array(
              'label'=>false,
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-pencil',
			  'options'=>array('style'=> 'font-size: 1.2em;'),
              'click'=> 'js:function(){return update(this);}',
          ),
        )
      ),
      array(
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{roles}',
        'buttons' => array(
          'roles' => array(
              'label'=>false,
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-eye-open',
			  'options'=>array('style'=> 'font-size: 1.2em;'),
              'click'=> 'js:function(){return roles(this);}',
          ),
        )
      ),
      array(
        'class'=>'booster.widgets.TbButtonColumn',
        'template'=>'{inhabilitar}{habilitar}',
        'buttons' => array(
          'inhabilitar' => array(
        	  'visible'=>'$data->activo',
              'label'=>false,
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-remove',
			  'options'=>array('style'=> 'font-size: 1.2em;'),
              'click'=> 'js:function(){return validaInhabilitar(this);}',
          ),
          'habilitar' => array(
        	  'visible'=>'!$data->activo',
              'label'=>false,
              'url'=>'$data->id',
              'icon'=>'glyphicon glyphicon-ok',
			  'options'=>array('style'=> 'font-size: 1.2em;'),
              'click'=> 'js:function(){return confirmarHabilitar(this);}',
          ),
        )
      ),
	),
)); 
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
   $('#Usuario_fecha_creacion').datepicker({'endDate':'23092017','format':'dd/mm/yyyy','language':'es','autoclose':true});
}
");


?>
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
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'dialogo-inhabilitar')
); ?>
<div class="modal-header">
    <h4>Inhabilitar Usuario</h4>
</div>
<div class="modal-body" id="body-inhabilitar" style="max-height: calc(100vh - 210px); overflow-y: auto;">
</div>
<div class="modal-footer">
	<?php $this->widget('booster.widgets.TbButton', array( 
		'buttonType'=>'button', 
		'context'=>'success', 
		'htmlOptions'=>array(
			'id'=>'guardar',
			'onClick'=>'confirma()',
		),
		'label'=>'Guardar', 
	)); ?>
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
    array('id' => 'modal_exitoso')
); ?>
<div class="modal-header">
    <h4>Inhabilitar Usuario</h4>
</div>
<div class="modal-body" id="body_exitoso"></div>
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
$( document ).ready(function() {
    if($("#fecha_creacion").val() != null){
    	alert($("#fecha_creacion").val());
    }
});
$('#dialogo-inhabilitar').on('hide.bs.modal', function (event) {
  	//$("#usuario-grid").yiiGridView.update("usuario-grid");
});
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
	      'url' => $this->createUrl("validarUpdate"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	      			modificar(id);
	        	}else{
	        		$("#dialogo-usuario #body-usuario").html(data.content);
	        		$("#dialogo-usuario").modal("show");
	        	}
	      }'
	    )
	);?>
    return false;
}
function modificar(id){
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
function validaInhabilitar(usuario){
	var id = $(usuario).attr("href");
    <?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("validarInhabilitar"),
	      'dataType'=>'json',
	      'success' => 'function(data){
      		if(data.status == "success"){
      			inhabilitar(id);
        	}else{
        		$("#dialogo-usuario #body-usuario").html(data.content);
        		$("#dialogo-usuario").modal("show");
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
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#dialogo-inhabilitar #body-inhabilitar").html(data.content);
	        		$("#dialogo-inhabilitar .modal-header").html(data.title);
	        		$("#dialogo-inhabilitar").modal("show");
	        	}else if(data.status == "exitoso"){
	        		$("#modal_exitoso #body_exitoso").html(data.content);
	        		$("#modal_exitoso").modal("show");
	        	}
	      }'
	    )
	);?>
}
function confirmarHabilitar(id){
	var id = $(id).attr("href");

	<?php echo CHtml::ajax(
	    array(
	      	'type' => 'POST',
	      	'data' => array('id' => 'js:id'),
	      	'url' => $this->createUrl("valida"),
	      	'dataType'=>'json',
	      	'success' => 'function(data){
	      		bootbox.confirm({
				    message: data.msj,
				    buttons: {
				        confirm: {
				            label: "Confirmar",
				            className: "btn-success"
				        },
				        cancel: {
				            label: "Cancelar",
				            className: "btn-default"
				        }
				    },
				    callback: function (confirm) {
				    	if(confirm){
				    		habilitar(id);
					    	
				    	}
				    }
			    });
	      	}'
	    )
	);?>	
	return false;
}
function habilitar(id){
	<?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'data' => array('id' => 'js:id'),
	      'url' => $this->createUrl("habilitar"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$.fn.yiiGridView.update("usuario-grid");
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