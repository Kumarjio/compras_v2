<?php
class CrearPermisosCommand extends CConsoleCommand
{

	public function actionIndex(){
		$controllers = Yii::app()->metadata->getControllers();
		$validos = array('CiudadController',
				         'CentroCostosController',
						 'ContactoEmpleadosController',
						 'CotizacionViajeController',
						 'EmisionHotelController',
						 'EmpleadosController',
						 'GastosViajeController',
						 'ItinerarioController',
						 'ParametrosController',
						 'SiteController',
						 'TransporteAdicionalController',
						 'ViajeController',
						 'ViajerosExternosController');
		$codigo = 1;
		
		foreach ($controllers as $n => $cont) {
			if(in_array($cont, $validos)){
				$actions = Yii::app()->metadata->getActions($cont);
				foreach ($actions as $k => $act) {
					$cod = sprintf("VIA%04s", $codigo);
					$codigo++;
					$permiso = new Permisos;
					$permiso->nombre_accion = str_replace("Controller", "", $cont)."/".$act;
					$permiso->codigo = $cod;
					$permiso->save();
				}
			}
		}

	}

}