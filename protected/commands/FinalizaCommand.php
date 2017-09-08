<?php
class FinalizaCommand extends CConsoleCommand{

	public function run($args){

 		Yii::app()->getModule('citas');
      	$model = Cita::model()->findAllByAttributes(array("paso_wf"=>"swCita/agendado"));

		foreach ($model as $cita){
			if( strtotime(date("Y-m-d", strtotime($cita->idDisponibilidad->fecha))." ".$cita->idDisponibilidad->inicio) < strtotime(date("Y-m-d H:i")) ){
		  		$cita->paso_wf = "swCita/no_cumple_paciente";
				$cita->observacion = "FINALIZA EL PROCESO DE LA CITA.";
				$cita->id_usuario = "1";
				if($cita->validate()){
					$cita->save();
					echo "Actualiza Cita ID: ".$model->id_cita." \n";
				}else{
					var_dump($cita->getErrors());
				}
			}
		}
    }
}
?>