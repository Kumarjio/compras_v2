<?php

/**
 * This is the model class for table "vicepresidencias".
 *
 * The followings are the available columns in table 'vicepresidencias':
 * @property integer $id
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property Gerencias[] $gerenciases
 */
class Vicepresidencias extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vicepresidencias the static model class
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
		return 'vicepresidencias';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('nombre, atribuciones', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre', 'safe', 'on'=>'search'),
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
			'gerenciases' => array(self::HAS_MANY, 'Gerencias', 'id_vice'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'atribuciones' => 'Atribuciones (SMMLV)'
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
		$criteria->compare('UPPER(nombre)',strtoupper($this->nombre),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function nombreVicepresidencia($vice){
		$query = <<<EOD
			select 
			e.id,
			e.nombre_completo as nombre 
			from 
			empleados e 
				inner join 
					contratos c 
						inner join 
							cargos car
						on (car.id = c.id_cargo) 
				on (e.id = c.id_empleado) 
			where car.es_vice = 'Si' and car.id_vice = $vice and (c.fecha_fin is null or c.fecha_fin > now()::date);
EOD;

		$res =  $this->dbConnection->createCommand($query)->queryAll();

		if(!count($res))
			throw new CException("No se encontró el vicepresidente de la vicepresidencia");

		return $res;
			

	}
}