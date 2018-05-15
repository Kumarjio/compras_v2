<?php
$this->breadcrumbs=array(
	'Todas las solicitudes'
);


$this->menu=array(
	array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
	array('label'=>'Home','url'=>array('admin'), 'icon'=>'home'),
);


?>

<h2>Todas las Solicitudes</h2>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'orden-asignadas-grid',
	'dataProvider'=>$model->search_todas(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
	'rowCssClassExpression' => '($data->paso_wf == "swOrden/aprobado_por_comite" or $data->paso_wf == "swOrden/aprobado_por_presidencia")?"aprobado":""',
	'columns'=>array(
		array(
		      'header' => 'Número de solicitud',
		      'name' => 'id',
		      'type' => 'raw',
		      //'value' => '"<a href=\"update/id/".$data->id."\">".$data->id."</a>"',
		      'value' => 'CHtml::link(($data->id >= 500000000)?"No Asignado":$data->id, Yii::app()->createUrl("orden/print", array("orden"=>$data->id)))'
		      ),
		array(
			'header'=>'Tipo Compra',
			'name' => 'tipo_compra',
			'type' => 'raw',
			'filter' => CHtml::listData(TipoCompra::model()->findAll(), "id", "nombre"),
			'value' => '($data->tipo_compra != "")? $data->tipoCompra->nombre.Orden::model()->tipoNegociacionSpan($data->negociacion_directa) :""'
		),
		'nombre_compra',
		//'resumen_breve',
		array(
			'header'=>'Jefatura',
			'name' => 'id_jefatura',
			'filter' => CHtml::listData(Jefaturas::model()->findAll(), "id", "nombre"),
			'value' => '($data->id_jefatura != "")? $data->idJefatura->nombre :""'
		),
		array(
			'header'=>'Usuario Solicitante',
			'name' => 'nombre_usuario_search',
			'value' => '$data->idUsuario->nombre_completo'
		),
		array(
		    'header'=>'Estado Actual',
		    'name'=>'paso_wf',
		    'filter'=>SWHelper::allStatuslistData($model),
		    'value'=>'Orden::model()->labalEstado($data->paso_wf)'
		),
        array('header' => "Fecha del Último Estado", 'value' => '$data->getLastDate()'),
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template' => '{cancelar}',
			'header'=>'Acciones',
			'visible'=>Yii::app()->user->getState('jefe_compras'),
			'buttons' => array(
					   'cancelar' => array(
					   		'label'=>"<i class='icon-remove'></i>",     // text label of the button
						    'url'=>'Yii::app()->createUrl(\'orden/cancelar/id/\'. $data->id)',       // a PHP expression for generating the URL of the button
						    //'imageUrl'=>'...',  // image URL of the button. If not set or false, a text link is used
						    'options'=>array('title' => 'Cancelar Orden', 'class'=>'cancelar'), // HTML options for the button tag
						    //'click'=>"function(){if(confirm('Esta seguro de cancelar esa orden?')){return true;}else{return false;}}",     // a JS function to be invoked when the button is clicked
						    'visible'=>"Yii::app()->user->getState('jefe_compras')",   // a PHP expression for determining whether the button is visible
					     ),

			   )
		),
	),
)); ?>


<script type="text/javascript">
	jQuery('#orden-asignadas-grid a.cancelar').live('click',function() {
        if(!confirm('Esta seguro de cancelar esa orden?')) return false;
        var th=this;
        var afterDelete=function(){};
        $.fn.yiiGridView.update('orden-asignadas-grid', {
                type:'POST',
                url:$(this).attr('href'),
                success:function(data) {
                        $.fn.yiiGridView.update('orden-asignadas-grid');
                        afterDelete(th,true,data);
                },
                error:function(XHR) {
                        return afterDelete(th,false,XHR);
                }
        });
        return false;
});
</script>