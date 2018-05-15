<?php 
	$this->widget('ext.phpexcel.EExcelView', array(
	'title'=>'Informe Gerencias -'. date("d-m-Y h:i A"),
    'autoWidth'=>true,
    'grid_mode'=>'export', 
	'sheets'=>array(
		array(
			'sheetTitle'=>'Informe',
			'dataProvider' => $informe_gerencia->search($model),
			'columns' => array( 
                'id',
                array(
                    'name'=>'nombre_compra',
                    'footer'=>'TOTAL CONSULTA'
                ),
                array(
                    'name'=>'total',
                    'footer'=>$informe_gerencia->sumar($model),
                    'type'=>'number'
                ),
                'fecha_solicitud',
                'negociacion_directa',
                'id_jefatura',
                'jefatura',
                'id_gerencia',
                'gerencia',
                'nit',                                      
            )
		)	
	)
));
?>
