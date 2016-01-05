<?php echo CHtml::label('Citas Programadas con Especialistas', 'con_especialista'); ?>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'cita-grid',
			'dataProvider'=>$model->search_tipo_1($id_paciente),
			'enableSorting' => false,
			'columns'=>array(
                                array(
                                    'header'=>'Medico',
                                    'value'=>'Medicos::model()->nombreCompleto($data->idDisponibilidad->idRecurso->id_relacionado)'
                                ),
                                array(
                                    'header'=>'Especialidad',
                                    'value'=>'$data->idEspecialidad->nombre_especialidad'
                                ),
                                array(
                                    'header'=>'Fecha',
                                    'value'=>'date("Y-m-d",strtotime($data->idDisponibilidad->fecha))'
                                ),
                                array(
                                    'header'=>'Hora',
                                    'value'=>'$data->idDisponibilidad->inicio'
                                ),
			),
		)); 
?>

<?php echo CHtml::label('Examenes Programados', 'con_ayudas'); ?>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'cita-grid',
			'dataProvider'=>$model->search_tipo_2($id_paciente),
			'enableSorting' => false,
			'columns'=>array(
                                array(
                                    'header'=>'Examen',
                                    'value'=>'AyudasDiagnosticas::model()->findByPk($data->idDisponibilidad->idRecurso->id_relacionado)->nombre_ayuda'
                                ),
                                array(
                                    'header'=>'Fecha',
                                    'value'=>'date("Y-m-d",strtotime($data->idDisponibilidad->fecha))'
                                ),
                                array(
                                    'header'=>'Hora',
                                    'value'=>'$data->idDisponibilidad->inicio'
                                ),
			),
		)); 
?>