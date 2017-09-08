<?php
$this->setPageTitle('Impresion Imagine');
?>
<div class="x_title">
  <h2>Bandeja de impresión Imagine</h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<div class="col-md-11" align="right">
	<?php $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Impresión',
        'context' => 'primary',
    )
);  ?>
</div>
<div class="col-md-1">
	<?php $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Excel',
        'context' => 'success',
    )
);  ?>
</div>
<br>
<br>
<br>
<br>
<div class='col-md-12'>
  <?php
  $this->widget('booster.widgets.TbGridView',array(
  'id'=>'pendientes-grid',
  'dataProvider'=>$model->search_impresion(''),
  'type' => 'striped',
  'responsiveTable' => true,
  'columns'=>array(
  		array(
			'header'=>'Imprimir',
			'class'=>'CCheckBoxColumn',
			'id'=>'$data->id',
			'value'=>'$data->id_cartas',
			//'selectableRows' => '100',
			'visible'=>'$data->idCartas->impreso == 1',
	        /*'checkBoxHtmlOptions'=>array(
	                'checked'=>'checked',
	        ),  */
		),
      	array('name'=>'caso','value'=>'$data->idCartas->na'),
      	array('name'=>'destinatario','value'=>'$data->idCartas->nombre_destinatario'),
      	array('name'=>'principal','value'=>'$data->idCartas->principal'),
      	array('name'=>'courrier','value'=>'$data->idCartas->proveedor0->proveedor'),
      	array('name'=>'tipología','value'=>'$data->idCartas->na0->tipologia0->tipologia'),
      	array('name'=>'impreso','value'=>'$data->idCartas->impreso'),
    ),
  )); ?>
</div>