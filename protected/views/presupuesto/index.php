<?php
$criteria = new CDbCriteria;
if($productos->id_categoria != "")
	$criteria->compare('id_categoria',$productos->id_categoria);
$criteria->order = 'nombre';
?>
<div class="x_title">
  <h2>Presupuesto </h2>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>

<?php
 
 $this->widget('booster.widgets.TbGridView',array(
    'id'=>'trazabilidad-grid',
    'dataProvider'=>$productos->search_presupuesto(),
    //'template' => "{items}",
    'filter' => $productos,
    'type' => 'striped bordered condensed',
    'responsiveTable' => true,
    'columns'=>array(
        //'id_categoria',
        //'categoria',
        array(
          	'name'=>'id_categoria',
          	'filter'=>CHtml::activeDropDownList($productos, 'id_categoria', CHtml::listData(Categorias::model()->findAll(), 'id', 'nombre'), array('class'=>'form-control', 'prompt'=>''
         	)),
         	'value'=>'$data->familia->idCategoria->nombre'

        ),
        array(
          'name'=>'id_familia',
          'header'=>'SubCategoria',
          'filter'=>CHtml::activeDropDownList($productos, 'id_familia', CHtml::listData(FamiliaProducto::model()->findAll($criteria), 'id', 'nombre'), array('class'=>'form-control', 'prompt'=>'')),
          'value'=>'$data->familia->nombre'
        ),
        'nombre',
        
        array(
	        'header'=>'Agregar',
	        'class'=>'booster.widgets.TbButtonColumn',
	        'template'=>'{gestion} ',
	        'buttons' => array(
	          	'gestion' => array(
	              	'label'=>'Seleccionar',
	              	'url'=>'CJSON::encode($data)',
	              	//'icon'=>'glyphicon glyphicon-ok',
	              	'imageUrl'=>Yii::app()->request->baseUrl.'/images/ok4.png',
	              	//'visible' => '$data->estado == 1 && $data->user_asign == Yii::app()->user->usuario',
	              	//'click'=> 'function(){observaciones($(this).parent().parent().children(":nth-child(5)").text());}',
	              	'click'=> 'js:function(){return agregarPresupuesto(this);}',
	          	),
	        )
      	),  
    ),
  )); 
echo '<div class ="row">';
	echo '<div class ="col-sm-2">';
		echo CHtml::label('Año Presupuesto', 'anio_presupuesto', array('class'=>'control-label'));
	echo '</div>';
echo '</div>';
echo '<div class ="row">';
	echo '<div class ="col-sm-4">';
		echo CHtml::dropDownList(
		 	'anio',
		 	date('Y', strtotime('+1 year', strtotime(date('Y')))), 
		 	array(
		 		date('Y', strtotime('+1 year', strtotime(date('Y')))) => date('Y', strtotime('+1 year', strtotime(date('Y')))),
		 		date('Y')=>date('Y'),
		 	),
		 	array(
		 		'class'=>'form-control'
		 	)
		);
	echo '</div>';
echo '</div>';
echo '</br>';
 
 $this->widget('booster.widgets.TbExtendedGridView',array(
    'id'=>'presupuesto-grid',
    'dataProvider'=>$presupuesto->search(),
    'template' => "{items}\n{extendedSummary}",
    //'filter' => $presupuesto,
    'type' => 'striped bordered',
    'responsiveTable' => true,
    'columns'=>array(
        array(
        	'name'=>'id_direccion',
        	'value'=>'$data->idDireccion->nombre'
        ),
        array(
        	'name'=>'id_producto',
        	'value'=>'$data->idProducto->nombre'
        ),
        array(
        	'name'=>'id_centro_costo',
        	'value'=>'$data->idCentroCosto->nombre'
        ),
        array(
        	'name'=>'id_cuenta',
        	'value'=>'$data->idCuenta->nombre'
        ),
        array(
        	'name'=>'valor',
          'htmlOptions'=>array('style' => 'text-align: right;'),
        	'type'=>'number',
        ),
        array(
          'header'=>'Consumido',
          'htmlOptions'=>array('style' => 'text-align: right;'),
          'type'=>'number',
          'value'=>'$data->consumoProducto()'
        ),
    ),
     'extendedSummary' => array(
        'title' => 'Total Presupuesto',
        'columns' => array(
            'valor' => array('label'=>'Total', 'class'=>'TbSumOperation')
        )
    ),
    'extendedSummaryOptions' => array(
        'class' => 'well pull-right',
        'style' => 'width:300px'
    ),
  )); 
$this->beginWidget(
    	'booster.widgets.TbModal',
    	array('id' => 'presupuesto_form')
	); 
?>
 
    <div class="modal-header" id="pr-modal-header">
        <!--a class="close" data-dismiss="modal">&times;</a-->
        <h4>Modal header</h4>
    </div>
 
    <div class="modal-body" id="body_presupuesto_form">
        <p>One fine body...</p>
      
    </div>
 
 
<?php $this->endWidget(); ?>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalCentro')); ?>


  <div class="modal-header">
      <h3>Seleccionar centro de costos</h3> 
  </div>

  <div id="modal-content" class="modal-body">

 <?php

	$this->widget('booster.widgets.TbGridView',array(
	'id'=>'centro-costos-grid',
	'dataProvider'=>$centro_costos_model->search_pres(),
	'type'=>'striped bordered condensed',
	'filter'=>$centro_costos_model,
	'columns'=>array(
		    'codigo',
		    'nombre',
		    //array('name'=>'nombre_jefatura_search', 'value'=>'$data->jefatura->nombre', 'header'=>'Jefatura'),
		    array(
			  	'class'=>'bootstrap.widgets.BootButtonColumn',
			  	'template' => '{select}',
				'buttons'=>array (
					'select' => array(
						'label' => "<i class='glyphicon glyphicon-ok'></i>",
						'url' => '"#".$data->id."#".$data->nombre',
						'options'=>array(
							'title' => 'Seleccionar',
							"onClick"  => '(function(e, obj){
									 var arr = $(obj).parent().find("a").attr("href").split("#");
									 $("#Presupuesto_id_centro_costo").val(arr[1]);
									 $("#Presupuesto_nombre_centro").val(arr[2]);
									 //resetGridView("centro-costos-grid");
									 $("#modalCentro").modal("hide");
									 $("#presupuesto_form").modal();
									})(event, this)',
						),
					),
			   	),
			  ),
		    ),
	));

?>
  </div>
  <div class="modal-footer">
		      <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Cerrar',
  		      'url'=>'#',
  		      'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("centro-costos-grid"); $("#modalCentro").modal("hide");$("#presupuesto_form").modal("show");'),
		      )); ?>
  </div>


	    <?php $this->endWidget(); ?>



<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'modalCuenta')); ?>


  <div class="modal-header">
		      <a class="close" data-dismiss="modal">&times;</a>
      <h3>Seleccionar centro de costos</h3> 
  </div>

  <div id="modal-content" class="modal-body">

 <?php

	$this->widget('booster.widgets.TbGridView',array(
	'id'=>'cuenta_contable_grid',
	'dataProvider'=>$cuenta_contable->search(),
	'type'=>'striped bordered condensed',
	'filter'=>$cuenta_contable,
	'columns'=>array(
		    'codigo',
		    'nombre',
		    //array('name'=>'nombre_jefatura_search', 'value'=>'$data->jefatura->nombre', 'header'=>'Jefatura'),
		    array(
			  	'class'=>'bootstrap.widgets.BootButtonColumn',
			  	'template' => '{select}',
				'buttons'=>array (
					'select' => array(
						'label' => "<i class='glyphicon glyphicon-ok'></i>",
						'url' => '"#".$data->id."#".$data->nombre',
						'options'=>array(
							'title' => 'Seleccionar',
							"onClick"  => '(function(e, obj){
									 var arr = $(obj).parent().find("a").attr("href").split("#");
									 $("#Presupuesto_id_cuenta").val(arr[1]);
									 $("#Presupuesto_nombre_cuenta").val(arr[2]);
									 //resetGridView("centro-costos-grid");
									 $("#modalCuenta").modal("hide");
									 $("#presupuesto_form").modal();
									})(event, this)',
						),
					),
			   	),
			  ),
		    ),
	));

?>
  </div>
  <div class="modal-footer">
		      <?php $this->widget('bootstrap.widgets.BootButton', array(
  'label'=>'Cerrar',
		      'url'=>'#',
		      'htmlOptions'=>array('data-dismiss'=>'modal', 'id' => "cerrar_modal", 'onClick' => 'resetGridView("centro-costos-grid"); $("#modalCuenta").modal("hide");$("#presupuesto_form").modal("show");'),
		      )); ?>
  </div>


	    <?php $this->endWidget(); ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#anio').change(function(){
		var datos = {'Presupuesto':{'anio':$(this).val()}, 'Presupuesto_page': 1, 'ajax':'presupuesto-grid'};
		$.fn.yiiGridView.update('presupuesto-grid', {
			data: datos
		});	
	});
});

  function agregarPresupuesto(id){
    var producto = $(id).attr("href");
    <?php echo CHtml::ajax(
      array(
        'type' => 'POST',
        'data' => array('producto' => 'js:producto'),
        'url' => $this->createUrl("presupuesto/crear"),
        'dataType'=>'json',
        'success' => 'function(data){
            if(data.status == "success"){
              $("#pr-modal-header").html(data.header);
              $("#body_presupuesto_form").html(data.content);
              $("#presupuesto_form").modal("show");
              
            }
        }'
      )
    );?>
    return false;
  }

  function validarFormPresup(selector){
    jQuery.ajax({
      'url':'<?php echo Yii::app()->createUrl('presupuesto/crear')?>',
      'dataType':'json',
      'data':$(selector).serialize(),
      'type':'post',
      'success':function(data){
        if(data.status == 'success'){
          $('#presupuesto-grid').yiiGridView.update('presupuesto-grid');
          $('#presupuesto_form').modal('hide'); 
        }
        else{
          $('#body_presupuesto_form').html(data.content);
        }
      },
      'cache':false}
    );
  }

 $("#modalCentro, #presupuesto_form, #modalCuenta").bind('mousewheel DOMMouseScroll', function(e) {
    var scrollTo = null;

    if (e.type == 'mousewheel') {
        scrollTo = (e.originalEvent.wheelDelta * -1);
    }
    else if (e.type == 'DOMMouseScroll') {
        scrollTo = 40 * e.originalEvent.detail;
    }

    if (scrollTo) {
        e.preventDefault();
        $(this).scrollTop(scrollTo + $(this).scrollTop());
    }
});
</script>