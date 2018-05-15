<div class="x_title">
	<div class='col-md-12'>
		<h2>Administración Actividades</h2>
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
			'icon'=>'glyphicon glyphicon-align-justify',
			'type'=>'danger',
			'label'=>'Nueva Actividad',
      		'htmlOptions' => array('id'=>'crear_actividad'), 
		)); ?>
	</div>
</div>
<div class='col-md-9'></div>
<div class='col-md-2'>
	<?php echo CHtml::activeTextField($model,'buscar',array('class'=>'form-control','maxlength'=>'24','placeholder'=>'Consulta actividad...')); ?>
</div>
<div class="row">
</div>
<br>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'actividades_grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'ajaxType'=>'POST',
	'filterSelector'=>'{filter}, #Actividades_buscar, select',
	'type' => 'striped',
	'columns'=>array(
		array(
			'name'=>'actividad',
            'htmlOptions'=>array('align'=>'left', 'width'=>'20%'),
		),
		array(
			//'header'=>'Modificar',
	        'class'=>'booster.widgets.TbButtonColumn',
	        'headerHtmlOptions'=>array('align'=>'right', 'width'=>'80%'),
	        'template'=>'{editar}',
	        'buttons' => array(
	          	'editar' => array(		
	              	//'label'=>'Modificar',
	              	'url'=>'$data->id',
	              	'icon'=>'glyphicon glyphicon-pencil',
			  	  	'options'=>array('style'=> 'font-size: 1.5em;'),
	              	'click'=> 'js:function(){return editar(this);}',
	              //'click'=> 'js:function(){return tipologias(this);}',
	         	),
	        ),
	        'htmlOptions'=>array('align'=>'right')
	    ),
	),
)); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'crea_actividad')
); ?>
<div class="modal-header">
	<h4>Nueva Actividad</h4>
</div>
<div class="modal-body" id="body_creacion">
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
    array('id' => 'edita_actividad')
); ?>
<div class="modal-header">
    <h4>Gestión Actividad</h4>
</div>
<div class="modal-body" id="body_edicion">
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
$("#crear_actividad").click(function(){
	<?php echo CHtml::ajax(
	    array(
	      'type' => 'POST',
	      'url' => $this->createUrl("create"),
	      'dataType'=>'json',
	      'success' => 'function(data){
	      		if(data.status == "success"){
	        		$("#crea_actividad #body_creacion").html(data.content);
	        		$("#crea_actividad").modal("show");
	        	}
	      }'
	    )
	);?>
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
	        		$("#edita_actividad #body_edicion").html(data.content);
	        		$("#edita_actividad").modal("show");
	        	}else{
	        		alert(data.content);
	        	}
	      }'
	    )
	);?>
    return false;
}
</script>