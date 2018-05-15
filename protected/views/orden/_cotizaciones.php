<div>
<?php
if($op->id_marco_detalle == ''){
    if($op->rechazado){ 
        $height = 120 + (count($op->CotizacionsOpEnviadas) * 36);
?>
    <style type="text/css">
        .glyphicon{
            position: static;
        }
    </style>
    <div id="producto-rechazado-<?php echo $op->id; ?>" style="position:absolute; width:100%; height:<?php echo $height?>px; background:#CCC url('/images/rechazado.png') center; opacity:0.5; filter:alpha(opacity=50); -ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=50)'; -moz-opacity:0.5; -khtml-opacity: 0.5; padding-bottom:9px;"> 
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
echo CHtml::tag('h4',array(),'COTIZACIONES:  '.$id);
if($paso_actual ==  'swOrden/en_negociacion'){

    $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Agregar Cotización',
            'context' => 'info',
            'id'=>'btn_crear_cotizacion',
            'url'=>$this->createUrl("orden/adicionarCotizacion", array('orden_producto'=>$id)),
            'htmlOptions' => array(
                'href'=>$this->createUrl("orden/adicionarCotizacion", array('orden_producto'=>$id)),
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
            'url'=>$this->createUrl("orden/rechazarProducto", array('id'=>$id)),
            'htmlOptions' => array(
                'href'=>$this->createUrl("orden/rechazarProducto", array('id'=>$id)),
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
                'value'=>'Orden::model()->elecciones($data->elegido_compras, $data->elegido_comite, $data->elegido_usuario, $data);'                
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
                    'update' => array(
                        'visible' =>  '$data->ordenProducto->idOrden->paso_wf == "swOrden/en_negociacion"'
                    ),
                    'enviar' => array(
                        'url' => 'CController::createUrl("/orden/agregarPagosACotizacionOp", array("id_cot"=>$data->id))',
                        'icon' => 'share',
                        'label' => 'Enviar a Usuario',
                        'options' => array(
                            'class' => 'enviar-cotizacion-a-usuario'
                        ),
                        'visible' => '$data->ordenProducto->idOrden->paso_wf == "swOrden/en_negociacion"'
                    ),
                    'elegir' => array(
                        'url' => '$data->verUrlElegir()' ,
                        'icon' => 'check',
                        'label' => 'Elegir',
                        'visible' => '$data->enviar_cotizacion_a_usuario == 1',// && $data->validarElegir()',
                        'options' => array(
                            'class' => 'elegir-cotizacion',
                            'data-prodorden' => $id
                        )

                    ),
                ),
                'viewButtonUrl'=>null,
                'updateButtonUrl'=>'CController::createUrl("/orden/updateCotizacionOp", array("id"=>$data->id))',
                'deleteButtonUrl'=>null,
            )
    	),
));
}else {
    $disabled = false;
    if($op->rechazado){ 
        $disabled = true;
        $height = 120 + (count($op->CotizacionsOp) * 36);
?>
        <style type="text/css">
            .glyphicon{
                position: static;
            }
        </style>
        <div id="producto-rechazado-<?php echo $op->id; ?>" style="position:absolute; width:100%; height:<?php echo $height?>px; background:#CCC url('/images/rechazado.png') center; opacity:0.5; filter:alpha(opacity=50); -ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=50)'; -moz-opacity:0.5; -khtml-opacity: 0.5; padding-bottom:9px;"> 
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
    if($paso_actual == "swOrden/validacion_cotizaciones" || $paso_actual == "swOrden/gerente_compra" || $paso_actual == "swOrden/vicepresidente_compra"){
        echo "<div class='row'> <div class='col-md-6'>";
        if($op->aprobado_consumo == 1){
            echo '<p><b>Producto aprobado para consumo</b></p>';
        }
        else{

            $this->widget(
                'booster.widgets.TbButton',
                array(
                    'label' => 'Aprobar Consumo Marco',
                    'context' => 'info',
                    'id'=>'btn_aprobar_consumo',
                    'url'=>$this->createUrl("orden/aprobarConsumo", array('orden_producto'=>$id)),
                    'htmlOptions' => array(
                        'href'=>$this->createUrl("orden/aprobarConsumo", array('orden_producto'=>$id)),
                    ),
                )
            );
        }
        echo "</div> <div class='col-md-6'>";
        $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'NO Aprobar Consumo Marco',
                'context' => 'danger',
                'id'=>'btn_rechazar_producto',
                'url'=>$this->createUrl("orden/rechazarProducto", array('id'=>$id)),
                'htmlOptions' => array(
                    'href'=>$this->createUrl("orden/rechazarProducto", array('id'=>$id)),
                    'disabled'=>$disabled
                ),
            )
        );
        echo "</div></br></br></br></br></br></br></br>";

    }
    else
        echo "Este producto sera consumido por una orden marco, no es necesario agregar cotizaciones. ";
}


?>
</div>
    
</div>