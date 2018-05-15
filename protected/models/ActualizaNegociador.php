<?php

/**
 * This is the model class for table "actualiza_negociador".
 *
 * The followings are the available columns in table 'actualiza_negociador':
 * @property string $nombre_completo
 */
class ActualizaNegociador extends CFormModel
{
	public $id_empleado;

	public function rules()
	{
		return array(
			array('id_empleado', 'required'),
			array('id_empleado', 'numerical', 'integerOnly'=>true),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id_empleado' => ' Nombre Empleado',
		);
	}
}