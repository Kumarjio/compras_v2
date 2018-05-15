<?php

/**
 * This is the model class for table "documentacion_vinculacion_proveedor_administrativo".
 *
 * The followings are the available columns in table 'documentacion_vinculacion_proveedor_administrativo':
 * @property integer $id
 * @property integer $id_vinculacion_proveedor_administrativo
 * @property integer $formato_vinculacion_persona_juridica
 * @property integer $formato_entrevista_persona_juridica
 * @property integer $camara_comercio
 * @property integer $cedula_representante_legal
 * @property integer $carta_relacion_socios
 * @property integer $formato_vinculacion
 * @property integer $certificacion_bancaria
 * @property integer $contrato
 * @property string $analista_o_administrativo
 */
class DocumentacionVinculacionProveedorAdministrativo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DocumentacionVinculacionProveedorAdministrativo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'documentacion_vinculacion_proveedor_administrativo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_vinculacion_proveedor_administrativo, formato_vinculacion_persona_juridica, formato_entrevista_persona_juridica, camara_comercio, cedula_representante_legal, carta_relacion_socios, formato_vinculacion, certificacion_bancaria, formato_entrevista, rut', 'numerical', 'integerOnly'=>true),
			array('formato_vinculacion_persona_juridica, formato_entrevista_persona_juridica, rut, camara_comercio, cedula_representante_legal, carta_relacion_socios, certificacion_bancaria', 'required', 'requiredValue'=>1, 'on' => 'persona_juridica', 'message'=>'Debe enviar el documento: {attribute}'),
			array('formato_vinculacion, formato_entrevista, rut, cedula_representante_legal, certificacion_bancaria', 'required', 'requiredValue'=>1, 'on' => 'persona_natural', 'message'=>'Debe enviar el documento: {attribute}'),
			array('id_vinculacion_proveedor_administrativo, formato_vinculacion_persona_juridica, formato_entrevista_persona_juridica, camara_comercio, cedula_representante_legal, carta_relacion_socios, formato_vinculacion, certificacion_bancaria, formato_entrevista, rut', 'default', 'value'=>0),
			array('analista_o_administrativo, persona', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_vinculacion_proveedor_administrativo, formato_vinculacion_persona_juridica, formato_entrevista_persona_juridica, camara_comercio, cedula_representante_legal, carta_relacion_socios, formato_vinculacion, certificacion_bancaria, formato_entrevista, analista_o_administrativo, persona', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_vinculacion_proveedor_administrativo' => 'Id Vinculacion Proveedor Administrativo',
			'formato_vinculacion_persona_juridica' => 'Formato Vinculacion Persona Juridica',
			'formato_entrevista_persona_juridica' => 'Formato Entrevista Persona Juridica',
			'camara_comercio' => 'Cámara Comercio',
			'cedula_representante_legal' => 'Cédula Representante Legal / Persona Natural',
			'carta_relacion_socios' => 'Carta Relacion Socios',
			'formato_vinculacion' => 'Formato Vinculacion Persona Natural',
			'certificacion_bancaria' => 'Certificacion Bancaria',
			'formato_entrevista' => 'Formato Entrevista Persona Natural',
			'analista_o_administrativo' => 'Analista o Administrativo',
			'rut' => 'RUT',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_vinculacion_proveedor_administrativo',$this->id_vinculacion_proveedor_administrativo);
		$criteria->compare('formato_vinculacion_persona_juridica',$this->formato_vinculacion_persona_juridica);
		$criteria->compare('formato_entrevista_persona_juridica',$this->formato_entrevista_persona_juridica);
		$criteria->compare('camara_comercio',$this->camara_comercio);
		$criteria->compare('cedula_representante_legal',$this->cedula_representante_legal);
		$criteria->compare('carta_relacion_socios',$this->carta_relacion_socios);
		$criteria->compare('formato_vinculacion',$this->formato_vinculacion);
		$criteria->compare('certificacion_bancaria',$this->certificacion_bancaria);
		$criteria->compare('formato_entrevista',$this->formato_entrevista);
		$criteria->compare('analista_o_administrativo',$this->analista_o_administrativo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}