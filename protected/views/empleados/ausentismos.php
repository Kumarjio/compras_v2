<?php
$this->breadcrumbs=array(
	'Empleados'=>array('admin'),
	'Crear Reemplazo por Ausentismo',
);

$this->menu=array(
	array('label'=>'Home','url'=>array('admin'), 'icon'=>'home'),
	array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('empleados-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
  <div class="col-md-6 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <div class="row">
          <div class="col-md-3"><h2>Ausente:</h2></div>
          <div class="col-md-6" id="ausente">Seleccione un empleado de la lista</div>
        </div>
        
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

      <?php $this->widget('booster.widgets.TbGridView',array(
      	'id'=>'empleados-grid-a',
      	'dataProvider'=>$model->search(),
      	'type'=>'striped bordered condensed',
      	'filter'=>$model,
      	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
      	'columns'=>array(
      		'nombre_completo',
      		'numero_identificacion',
      		array(
      			'class'=>'booster.widgets.TbButtonColumn',
                'template' => '{seleccionar}',
                'buttons' => array(
                   'seleccionar'=>array(
                        'icon' => 'check',
                        'url' => '"#".$data->id."#".$data->nombre_completo',
                        'options' => array(
                                "class" => 'asignar_nombre_ausente',
                        )
                    )
                )
      		),

      	),
      )); ?>
      </div>
    </div>
</div>
  <div class="col-md-6 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <div class="row">
          <div class="col-md-3"><h2>Reemplazo:</h2></div>
          <div class="col-md-6" id="reemplazo">Seleccione un empleado de la lista</div>
        </div>
        
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <?php $this->widget('booster.widgets.TbGridView',array(
        	'id'=>'empleados-grid-b',
        	'dataProvider'=>$model->search(),
        	'type'=>'striped bordered condensed',
        	'filter'=>$model,
        	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
        	'columns'=>array(
        		'nombre_completo',
        		'numero_identificacion',
        		/*
        		'embarazo',
        		'tiempo_gestacion',
        		'fecha_probable_parto',
        		'creacion',
        		'actualizacion',
        		*/
        		array(
        			'class'=>'booster.widgets.TbButtonColumn',
                    'template' => '{seleccionar}',
                    'buttons' => array(
                         'seleccionar'=>array(
                            'icon' => 'check',
                            'url' => '"#".$data->id."#".$data->nombre_completo',
                            'options' => array(
                                "class" => 'asignar_nombre_reemplazo',
                              )
                          )
                    )
        		),
        	),
        )); ?>
      </div>

</div>
</div>
</div>
<div class="row">
  <center>
   <form method="post" id="forma">
     <input type="hidden" id="ausente_in" name="ausente_id" value="" />
     <input type="hidden" id="reemplazo_in" name="reemplazo_id" value="" />
    <button id="enviar" class="btn btn-primary" type="button">Crear reemplazo</button>
   </form>
  </center>
  
</div>

    <div class="x_panel">
      <div class="x_title">
        <h3>Reemplazos actuales</h3>
        
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <?php $this->widget('booster.widgets.TbGridView',array(
        	'id'=>'empleados-grid-reemp',
        	'dataProvider'=>$model->search_reemp(),
        	'type'=>'striped bordered condensed',
        	'filter'=>$model,
        	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
        	'columns'=>array(
        		    'nombre_completo',
        		    'numero_identificacion',
                array(
                      'value' => 'Empleados::model()->getNombre($data->reemplazo)',
                      'header' => "Reemplazo"
                ),
        		    array(
                      'class'=>'booster.widgets.TbButtonColumn',
                      'template' => '{delete}',
                      'deleteButtonUrl'=>'Yii::app()->createUrl("/empleados/deleteAusentismo", array("ausente" =>  $data["id"], "ajax" => 1))',
                ),

        	),
        )); ?>
      </div>
</div>



<br /><br />

<script>
$(document).ready(function(){
    $(".asignar_nombre_ausente").live("click", function(e){
        e.preventDefault();
        var parts = $(this).attr("href").split("#");
        $("#ausente_in").val(parts[1])
        $("#ausente").html(parts[2]);
      });

    $(".asignar_nombre_reemplazo").live("click",function(e){
        e.preventDefault();
        var parts = $(this).attr("href").split("#");
        $("#reemplazo_in").val(parts[1])
        $("#reemplazo").html(parts[2]);
      });

    $("#enviar").click(function(e){
        if($("#ausente_in").val() == "" || $("#reemplazo_in").val() == ""){
          alert("Por favor seleccione ambos empleados (Ausente y reemplazo)");
        }else{
          $("#forma").submit();
        }
    });
  });
</script>