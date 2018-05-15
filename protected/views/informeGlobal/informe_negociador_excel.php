<?php 
	$this->widget('ext.phpexcel.EExcelView', array(
	'title'=>'Informe Negociador -'. date("d-m-Y h:i A"),
    'autoWidth'=>true,
    'grid_mode'=>'export', 
	'sheets'=>array(
		array(
			'sheetTitle'=>'Ahorro CYC',
			'dataProvider' => $informe_cyc->search_avanzado($model),
			'columns' => array( 
                        array(
                              'header' => 'Número de solicitud',
                              'name' => 'orden',
                              'type' => 'raw',
                              //'value' => '"<a href=\"update/id/".$data->id."\">".$data->id."</a>"',
                              'value' => 'CHtml::link($data->orden, Yii::app()->createUrl("orden/print", array("orden"=>$data->orden)))'
                              ),
                        array(
                              'header' => 'Tipo de compra',
                              'name' => 'tipo',
                              'type' => 'raw',
                              'htmlOptions'=>array('style' => 'text-align: right;'),
                              'value'=>'$data->tipo.Orden::model()->tipoNegociacionSpan($data->negociacion_directa)'
                        ),
                        'negociacion_directa',
                        array(
                              'header' => 'Descripción de la compra',
                              'name' => 'compra',
                              'htmlOptions'=>array('style' => 'text-align: right;')
                              ),

                        array(
                            'name'=>'nombre',
                            'value'=>'$data->getNombre()'
                        ),
                        
                        array(
                                    'name' => 'fecha',
                                    'value'=>'date("Y-m-d", strtotime($data->fecha))'
                                ),
                        array(
                                    'name' => 'promedio',
                                    'type'=>'number',
                                    'htmlOptions'=>array('style' => 'text-align: right;')
                                ),
                        array(
                                    'name' => 'selecionada',
                                    'type'=>'number',
                                    'htmlOptions'=>array('style' => 'text-align: right;')
                                ),
                        array(
                                    'name' => 'ahorro',
                                    'type'=>'number',
                                    'htmlOptions'=>array('style' => 'text-align: right;')
                                ),
                        array(
                                    'header'=>'%',
                                    'name' => 'porcentaje',//Yii::app()->numberFormatter->formatPercentage(
                                    'value'=>  'Yii::app()->numberFormatter->formatNumber(array("maxDecimalDigits"=>2, "multiplier"=>1, "negativePrefix"=>"(","negativeSuffix"=>")"),$data->porcentaje) . "%"',
                                    'htmlOptions'=>array('style' => 'text-align: right;')
                                ),
                        array(
                              'header' => 'moneda',
                              'name' => 'moneda',
                              'htmlOptions'=>array('style' => 'text-align: right;')
                              ),
                        array(
                              'header' => 'trm',
                              'name' => 'trm',
                              'htmlOptions'=>array('style' => 'text-align: right;')
                              ),
                        array(
                              'header' => 'negociador',
                              'name' => 'negociante',
                              'htmlOptions'=>array('style' => 'text-align: right;')
                              ),

                            )
                		),	
        array(
            'sheetTitle'=>'Ahorro SVA',
            'dataProvider' => $informe_sva->search_avanzado($model),
            'columns' => array( 
                        array(
                              'header' => 'Número de solicitud',
                              'name' => 'orden',
                              'type' => 'raw',
                              //'value' => '"<a href=\"update/id/".$data->id."\">".$data->id."</a>"',
                              'value' => 'CHtml::link($data->orden, Yii::app()->createUrl("orden/print", array("orden"=>$data->orden)))'
                              ),        
                         array(
                              'header' => 'Tipo de compra',
                              'name' => 'tipo',
                              'htmlOptions'=>array('style' => 'text-align: right;')
                              ),

                        array(
                              'header' => 'Descripcion de la compra',
                              'name' => 'compra',
                              'htmlOptions'=>array('style' => 'text-align: right;')
                              ),
                        array(
                            'name'=>'proveedor',
                            'value'=>'$data->getProveedor()'
                        ),
                        array(
                            'name'=>'fecha',
                            'value'=>'date("Y-m-d",strtotime($data->fecha))',
                        ),
                        array(
                                    'name' => 'selecionada',
                                    'type'=>'number',
                                    'htmlOptions'=>array('style' => 'text-align: right;')
                                ),
                        array(
                                    'name' => 'alta',
                                    'type'=>'number',
                                    'htmlOptions'=>array('style' => 'text-align: right;')
                                ),
                        array(
                                    'name' => 'ahorro',
                                    'type'=>'number',
                                    'htmlOptions'=>array('style' => 'text-align: right;')
                                ),
                        array(
                                    'header'=>'%',
                                    'name' => 'porcentaje',//Yii::app()->numberFormatter->formatPercentage(
                                    'value'=>  'Yii::app()->numberFormatter->formatNumber(array("maxDecimalDigits"=>2, "multiplier"=>1, "negativePrefix"=>"(","negativeSuffix"=>")"),$data->porcentaje) . "%"',
                                    'htmlOptions'=>array('style' => 'text-align: right;')
                                ),

                        array(
                              'header' => 'moneda',
                              'name' => 'moneda',
                              'htmlOptions'=>array('style' => 'text-align: right;')
                              ),
                        array(
                              'header' => 'trm',
                              'name' => 'trm',
                              'htmlOptions'=>array('style' => 'text-align: right;')
                              ),
                        array(
                              'header' => 'negociador',
                              'name' => 'negociante',
                              'htmlOptions'=>array('style' => 'text-align: right;')
                              ),

            )
        ),  
	)
));
?>
