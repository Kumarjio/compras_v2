<div>
<?php
if($op->rechazado){ 
    $height = 120 + (count($op->omCotizacions) * 36);
?>
    <style type="text/css">
        .glyphicon{
            position: static;
        }
    </style>
    <div id="producto-rechazado-<?php echo $po->orden_solicitud; ?>" style="position:absolute; width:100%; height:<?php echo $height?>px; background:#CCC url('/images/rechazado.png') center; opacity:0.5; filter:alpha(opacity=50); -ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=50)'; -moz-opacity:0.5; -khtml-opacity: 0.5; padding-bottom:9px;"> 
    </div>
<?php
    $emp = Empleados::model()->findByPk($op->usuario_rechazo);
    if($emp){
      echo "<div style='position:absolute; left:0px; margin:20px; background-color:#EEE; border:#666 solid 3px; padding:10px;'>";
      echo "<p><b>Rechazado por: </b>".$emp->nombre_completo."</p>";
      echo "<p><b>Fecha y Hora: </b>".$op->fecha_rechazo."</p>";
      echo "<p><b>Razón: </b>".$op->razon_rechazo."</p>";
      echo "</div>";
    }

}

?>
<div id="detalle-producto "> 
    
<?php
echo CHtml::tag('h4',array(),'COTIZACIONES:  '.$op->producto0->nombre);
if($paso_actual ==  'swOrdenMarcoCompras/llenarocm' || $paso_actual == 'swOrdenMarcoCompras/devolucion'){

    $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Agregar Cotización',
            'context' => 'info',
            'id'=>'btn_crear_cotizacion',
            'url'=>$this->createUrl("ordenMarcoCompras/adicionarCotizacion", array('id_detalle_om'=>$id)),
            'htmlOptions' => array(
                'href'=>$this->createUrl("ordenMarcoCompras/adicionarCotizacion", array('id_detalle_om'=>$id)),
            ),
        )
    );
}
else {
    $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Rechazar Producto',
            'context' => 'danger',
            'id'=>'btn_rechazar_producto',
            'url'=>$this->createUrl("ordenMarcoCompras/rechazarProducto", array('id'=>$id)),
            'htmlOptions' => array(
                'href'=>$this->createUrl("ordenMarcoCompras/rechazarProducto", array('id'=>$id)),
            ),
        )
    );
}
$cont = $this->createUrl("ordenMarcoCompras/adicionarCotizacion", array('id_detalle_om'=>$id)); 

$this->widget('booster.widgets.TbExtendedGridView', array(
    'type'=>'striped bordered',
    'id'=>'cotizaciones-grid-'.$id,
    'dataProvider' => $model->search($id),
    'template' => "{items}",
    'enableSorting'=>false,
    'columns' => 
    	array(
            array(
                'name'=>'nit',
                'value'=>'$data->nit0->razon_social'
            ),
    		'cantidad',   
    		'valor_unitario',
    		'total_compra',
    		'moneda',
            'descripcion',  
            array(          
                'header' => 'Elección', 
                'type'=>'raw',
                'value'=>'OrdenMarcoCompras::model()->elecciones($data->elegido_compras, $data->elegido_comite, $data);'                
            ),  
            array(
                'type'=>'raw',
                'value'=>'($data->enviar_cotizacion_a_usuario == 1)?"<i class=\"glyphicon glyphicon-user\"></i>":""'
            ),
            array(
                'htmlOptions' => array('nowrap'=>'nowrap', 'class'=>'grid-cot'),
                'class'=>'booster.widgets.TbButtonColumn',
                'template'=>'{update} {elegir} {enviar} {subir}',
                'buttons'=>array(
                    'subir' => array(
                        'url' => 'CController::createUrl("/ordenMarcoCompras/subir", array("id"=>$data->id))',
                        'icon' => 'file',
                        'label' => 'Archivos',
                        'options' => array(
                            'class' => 'subir-archivos'
                        ),
                        //'visible' => '$data->productoOrden->orden0->paso_wf == "swOrden/en_negociacion" or $data->productoOrden->orden0->paso_wf == "swOrden/validacion_cotizaciones" or $data->productoOrden->orden0->paso_wf == "swOrden/gerente_compra" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobar_por_atribuciones" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobar_por_comite" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobado_por_comite" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobar_por_presidencia" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobar_por_junta" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobado_por_presidencia" or $data->productoOrden->orden0->paso_wf == "swOrden/aprobado_por_atribuciones"'
                    ),
                    'enviar' => array(
                        'url' => 'CController::createUrl("/ordenMarcoCompras/agregarPagosACotizacionOm", array("id_cot"=>$data->id))',
                        'icon' => 'share',
                        'label' => 'Enviar a Comite',
                        'options' => array(
                            'class' => 'enviar-cotizacion-a-usuario'
                        ),
                        'visible' => '$data->productoDetalleOm->idOrdenMarco->paso_wf == "swOrdenMarcoCompras/llenarocm"'
                    ),
                    'elegir' => array(
                        'url' => '$data->verUrlElegir()' ,
                        'icon' => 'check',
                        'label' => 'Elegir',
                        'visible' => '$data->enviar_cotizacion_a_usuario == 1 && $data->validarElegir()',
                        'options' => array(
                            'class' => 'elegir-cotizacion',
                            'data-prodorden' => $id
                        )

                    ),
                ),
                'viewButtonUrl'=>null,
                'updateButtonUrl'=>'CController::createUrl("/ordenMarcoCompras/updateCotizacion", array("id"=>$data->id))',
                'deleteButtonUrl'=>null,
            )
    	),
));?>
</div>
    
</div>