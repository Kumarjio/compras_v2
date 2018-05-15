
<div class="x_title">

	<div class="row">
		<div class="col-md-6">
			<h1>Proveedores</h1>
			
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
								array('label'=>'Crear','url'=>array('create'), 'icon'=>'fa fa-plus'),
				            ),  
				          )
				      )
				    )
				);
				?>
			</div>
		</div>
	</div>
</div>
<div class="x_content">
	<div class="row">
		<div class="col-md-12">
			
			<?php $this->widget('booster.widgets.TbGridView',array(
				'id'=>'proveedor-grid',
				'dataProvider'=>$model->search(),
				'type'=>'striped bordered condensed',
				'filter'=>$model,
				'ajaxUpdateError' => 'function(xhr){if(xhr.status == 400){alert("No se pudo eliminar el registo. Por favor verifique que no tenga ningun otro registro asociado.")}else{alert("Hay un error en los datos ingresados para la búsqueda. Por favor valide.")}}',
				'columns'=>array(
					'nit',
					'razon_social',
					array(
						'class'=>'booster.widgets.TbButtonColumn',
						'template' => '{members}  {contactos}  {update}  {delete}',
						'htmlOptions' => array('width' => '56px'),
						'header' => 'Operaciones',
						'buttons' => array(
							'members' => array(
								'url' => 'Yii::app()->createUrl("proveedor/miembros", array("id" => $data->nit))',
								'icon' => 'user',
								'label' => 'Miembros'
							),
							'contactos' => array(
								'url' => 'Yii::app()->createUrl("contactoProveedor/admin", array("id_proveedor" => $data->nit))',
								'icon' => 'book',
								'label' => 'Contactos'
							),
						)
					),
				),
			)); ?>
		</div>
	</div>
</div>
