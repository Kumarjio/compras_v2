<?php

/**
 * CargueUsuarios class.
 * CargueUsuarios is the data structure for keeping
 */
class CargueUsuarios extends CFormModel
{
	public $actividad_tipologia;
	public $usuarios;

	public function rules()
	{
		return array(
			array('actividad_tipologia, usuarios', 'required'),
			array('actividad_tipologia, usuarios', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'actividad_tipologia' => 'Actividad',
			'usuarios' => 'Usuarios',
		);
	}

}
