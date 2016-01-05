<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'disponibilidad-grid',
			'dataProvider'=>$model->search($id_recurso),
			'enableSorting' => false,
			'columns'=>array(
				'id_disponibilidad',
                                'fecha',
                                'inicio',
                                'fin',
                                'id_recurso',
                                'estado',
                                array(
                                    'name'=>'estado',
                                    'type'=>'raw',
                                    'value'=>'($data->estado == 0)? CHtml::ajaxButton("Tomar Cita",Yii::app()->createUrl("citas/cita/seleccionarCita",array("id_disponibilidad"=>$data->id_disponibilidad)),'
                                    . 'array('
                                    . ' "beforeSend"=>"alert(\'se fue\')",'
                                            
                                    . '),array("class"=>"btn-primary") ): ""' 
                                ),
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
//                                array(
//                                    'class'=>'ext.yiibooster.widgets.TbSwitch',
//                                    'name' => 'testToggleButton',
//                                    'events' => array(
//                                        'switchChange' => 'js:function($el, status, e){console.log($el, status, e);}'
//                                    )
//                                ),
			),
		)); 
$algo = $this->widget(
    'ext.yiibooster.widgets.TbSwitch',
    array(
        'name' => 'testToggleButtonB',
        'options' => array(
            'size' => 'large', //null, 'mini', 'small', 'normal', 'large
            'onColor' => 'success', // 'primary', 'info', 'success', 'warning', 'danger', 'default'
            'offColor' => 'danger',  // 'primary', 'info', 'success', 'warning', 'danger', 'default'
        ),
    )
);

$algo = html_
?>