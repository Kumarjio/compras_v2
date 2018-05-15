<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'myModal')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Trazabilidad</h4>
</div>
<div class="modal-body">
    <?php 
	if($model->id_docpro>0){
		$this->widget('bootstrap.widgets.BootGridView',array(
		'id'=>'documento-proveedor-grid2',
		'dataProvider'=>$model_traza->search_traza($model->id_docpro),
		'type'=>'striped bordered condensed',
		'columns'=>array(
			array(
				'name'=>'estado',
				'value'=>'$data->estado_rel->estado',
				'htmlOptions'=>array('width'=>'20%')
			),		
			array(
				'name'=> 'fecha_insert',
				'type'=> 'text',
				'value'=> '(strlen($data->fecha_insert)>0) ? date("Y-m-d",strtotime($data->fecha_insert) ) : ""',
				'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'15%')
			),
			array(
				'name'=> 'user_insert',
				'htmlOptions'=>array('style'=> 'text-align:center', 'width'=>'15%')
			),
			array(
				'name'=> 'observacion',
				'type'=> 'raw',
				'htmlOptions'=>array('width'=>'50%')
			)			
		),
	) ); 
	}else{
		echo "No se encontraron registros";
	}
	?>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>

<?php $this->endWidget(); ?>