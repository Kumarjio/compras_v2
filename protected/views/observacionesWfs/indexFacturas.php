<div id="content">
<?php 
$this->widget('bootstrap.widgets.BootGridView',array(
  'id'=>'informe-efectividad-grid',
  'dataProvider'=>$dataProvider,
'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
  'type'=>'striped bordered condensed',
  'columns'=>array(
    array(
          'header'=>'Usuario',
          'name' => 'usuario',
          'value' => '$data->idUsuario->nombre_completo'
        ),
    array(
        'header'=>'Est. anterior',
        'name'=>'estado_anterior',        
        'value'=>'Facturas::model()->labelEstado($data->estado_anterior)'
    ),
    array(
        'header'=>'Est. nuevo',
        'name'=>'estado_nuevo',        
        'value'=>'Facturas::model()->labelEstado($data->estado_nuevo)'
    ),
    'observacion',
    'fecha', 
  )
)); ?>
</div>