<?php

/**
 * CargaMasiva class.
 * CargaMasiva is the data structure for keeping
 */
class CargaMasiva extends CFormModel
{
	public $adjunto;

	public function rules()
	{
		return array(
			array('adjunto', 'required'),
			array('adjunto', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'adjunto' => 'Archivo Recepción',
		);
	}

}
