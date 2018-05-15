<?php $this->menu_izquierdo=array(
        array( 'label'=>'Home', 'url'=>Yii::app()->createUrl("/")),
    ); ?>
	<h2>Contratos  
	<?php

		if(Yii::app()->user->getState('gerente')){
			echo $empleado->contratoses[0]->idCargo->idGerencia->nombre;
		}
		elseif (Yii::app()->user->getState('jefe')) {
			echo $empleado->contratoses[0]->idCargo->idJefatura->nombre;
		}
	?>
	</h2>

<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'documento-proveedor-grid',
	'dataProvider'=>$model->search_area(),
	'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
		array(
		'header'=>'Tipo Documento',
		'type'=>'raw',
		'value' => '$data->tipo_documento_rel->tipo_documento'
		),
		array(
            'name'=>'proveedor',
            'type'=>'raw',
            'value'=>'$data->traerNits()',
            'filter'=>CHtml::textField('DocumentoProveedor[proveedor]', $model->proveedor, array('class'=>'form-control solo-numero'))
		),
		array(
            'name'=>'name_proveedor',
            'header'=>'Razon Social',
            'type'=>'raw',
            'value'=>'$data->traerRazonSocial()'
		),
		'nombre_contrato',
		//'objeto',
		array(
			'name'=> 'fecha_inicio',
			'type'=> 'text',
			'value'=> '(strlen($data->fecha_inicio)>0) ? date("Y-m-d",strtotime($data->fecha_inicio) ) : ""'
		),
		array(
			'name'=> 'fecha_fin',
			'type'=> 'text',
			'value'=> '(strlen($data->fecha_fin)>0) ? date("Y-m-d",strtotime($data->fecha_fin) ) : ""'
		),
		/*array(
			'header'=>'No. Documentos',
			'value'=>'DocumentoProveedor::numDocs($data->id_docpro)'
		),*/
    array(
			'header'=>'Estado',
			'value'=>'$data->estado_rel->estado'
		),
          array(
              'name'=>'id_jefatura',
              'value'=>'$data->jefatura->nombre',
              'visible'=>Yii::app()->user->getState('gerente')
          ),
	),
)); ?>

<script type="text/javascript">

	$(document).ready(function (){

        $('.solo-numero').keyup(function (){
           	this.value = (this.value + '').replace(/[^0-9]/g, '');
        });

    });

</script>