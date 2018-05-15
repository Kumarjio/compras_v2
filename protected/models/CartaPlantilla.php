<?php

/**
 * CargaMasiva class.
 * CargaMasiva is the data structure for keeping
 */
class CartaPlantilla extends CFormModel
{
	public $plantilla;
	public $carta;
	public $id_traza;
	public $texto;

	public function rules()
	{
		return array(
			array('plantilla, carta, id_traza', 'required'),
			array('texto', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'plantilla' => 'Plantilla',
			'carta' => 'Carta',
			'id_traza' => 'Trazabilidad',
			'texto' => 'Carta',
		);
	}

	protected function beforeValidate(){		
		
		$this->plantilla = trim($this->plantilla);
		$this->carta = trim($this->carta);
		$this->id_traza = trim($this->id_traza);

		if(empty($this->plantilla))
			$this->plantilla = NULL;

		if(empty($this->carta))
			$this->carta = NULL;

		if(empty($this->id_traza))
			$this->id_traza = NULL;

		return parent::beforeValidate();
	}

	public function validaRespuestas(){
		if(empty($this->id_traza)){
			$this->addError('id_traza', 'No se ha asociado una actividad a la gestión.');
			return false;
		}else{
			$cartas = Cartas::model()->findByAttributes(array("id_trazabilidad" => $this->id_traza));
			if($cartas){
				$adjuntos = AdjuntosRespuesta::model()->findAllByAttributes(array("id_trazabilidad" => $this->id_traza));
				if($adjuntos){
					$tamano_adj = 0;
					foreach ($adjuntos as $adjunto) {
						$tamano_adj = $tamano_adj + filesize( $adjunto->path_fisico );
					}
					//Validar si los adjuntos pesan mas de 8 Mb
					if($tamano_adj > 8388608){
						$this->addError('carta', 'El tamaño de los adjuntos supera las 8 Mb.');
						return false;
					}
				}
				$observaciones = ObservacionesTrazabilidad::model()->countByAttributes(array("id_trazabilidad" => $this->id_traza));
				if($observaciones == 0){
					$this->addError('carta', 'Debe ingresar una observación de la gestión realizada.');
					return false;
				}
				return true;
			}else{
				$this->addError('carta', 'Debe crear al menos una respuesta a un destinatario.');
				return false;
			}
		}

	}

}
