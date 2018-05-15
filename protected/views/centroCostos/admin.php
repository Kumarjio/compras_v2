	<div class="x_title">

		<div class="row">
			<div class="col-md-6">
				<h1>Centros de Costo</h1>
				
			</div>
			<div class="col-md-6">
				
				<div align="right">
					
					<?php

					$this->widget(
					    'booster.widgets.TbButtonGroup',
					    array(    
					        'size' => 'large',
					        'buttons' => array(array(
					          'label'=>'Acciones',
					          'items'=>
					            array(
									array('label'=>'Home','url'=>array('/orden/admin'), 'icon'=>'fa fa-bank'),
									array('label'=>'Crear','url'=>array('create'), 'icon'=>'fa fa-book'),
					            ),  
					          )
					      )
					    )
					);

					Yii::app()->clientScript->registerScript('search', "
					$('.search-button').click(function(){
						$('.search-form').toggle();
						return false;
					});
					$('.search-form form').submit(function(){
						$.fn.yiiGridView.update('centro-costos-grid', {
							data: $(this).serialize()
						});
						return false;
					});
					");
					?>
				</div>
			</div>
		</div>


          <h2></h2>
        
        <div class="clearfix"></div>
    </div>
	<div class="x_content">
		<div class="row">
			<div class="col-md-12">
				
				<?php $this->widget('booster.widgets.TbGridView',array(
					'id'=>'centro-costos-grid',
					'dataProvider'=>$model->search(),
					'type'=>'striped bordered condensed',
					'filter'=>$model,
					'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
					'columns'=>array(
						//'id',
						'codigo',
						//'id_jefatura',
						'nombre',
						array(
							'class'=>'booster.widgets.TbButtonColumn',
							'template' => '{view}  {delete}'
						),
					),
				)); ?>
			</div>
		</div>
	</div>
