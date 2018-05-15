<?php $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Seleccionar Productos',
        'context' => 'primary',
        'htmlOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#modalProductos',
        ),
    )
);


$this->widget('booster.widgets.TbExtendedGridView', array(
	'id'=>'seleccionar-productos-om',
    'filter'=>$detalle,
    'type'=>'striped bordered',
    'dataProvider' => $detalle->search_om($om),
    //'afterAjaxUpdate' => "function(id,data){console.log(id); console.log(data);}",
    'template' => "{items}",
    'columns' => array_merge(array(
        array(
            'class'=>'booster.widgets.TbRelationalColumn',
            'name' => 'id',
            'url' => $this->createUrl('ordenMarcoCompras/traerCotizaciones'),
            //'value'=> '"id"',
            'afterAjaxUpdate' => 'js:function(tr,rowid,data){
                //bootbox.alert("mensaje "+rowid);
            }'
        )),
    	array(
    		array(
    		'name'=>'producto',
    		'value'=>'$data->producto0->nombre'
	    	),
	    	'id_orden_marco',
            array(
                'class'=>'booster.widgets.TbButtonColumn',
                'template' => '{delete}',
                'buttons' => array(
                   'delete' => array(
                        'label' => false,
                        'visible' => '$data->idOrdenMarco->paso_wf == "swOrdenMarcoCompras/llenarocm"',
                        'url'=>'Yii::app()->createUrl("ordenMarcoCompras/deleteDetalleOM", array("id"=>$data->id))',
                    ),
                ),
                'afterDelete'=>'function(link,success,data){ if(success) $("#seleccionar-productos-om").yiiGridUpdate("#seleccionar-productos-om"); }',
            ),
    	)
    ),
));