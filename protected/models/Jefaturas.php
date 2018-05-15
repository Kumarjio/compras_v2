<?php

/**
 * This is the model class for table "jefaturas".
 *
 * The followings are the available columns in table 'jefaturas':
 * @property integer $id
 * @property integer $id_gerencia
 * @property string $nombre
 * @property string $creacion
 * @property string $actualizacion
 *
 * The followings are the available model relations:
 * @property Orden[] $ordens
 * @property Cargos[] $cargoses
 */
class Jefaturas extends CActiveRecord
{
	
	public $gerencia_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Jefaturas the static model class
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
		return 'jefaturas';
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
			array('id_gerencia, id_vice, atribuciones', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>255),
			array('id_gerencia, id_vice, atribuciones', 'safe'),
			array('id_gerencia, id_vice', 'dependencias'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_gerencia, nombre, gerencia_search', 'safe', 'on'=>'search'),
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
			'gerencia' => array(self::BELONGS_TO, 'Gerencias', 'id_gerencia'),
			'ordens' => array(self::HAS_MANY, 'Orden', 'id_jefatura'),
			'cargoses' => array(self::HAS_MANY, 'Cargos', 'id_jefatura'),
			'idVice' => array(self::BELONGS_TO, 'Vicepresidencias', 'id_vice'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_gerencia' => 'Gerencia',
			'gerencia_search' => 'Gerencia',
			'nombre' => 'Nombre',
			'atribuciones' => 'Atribuciones (SMMLV)',
			'id_vice' => 'Vicepresidencia'
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
		$criteria->with = array("gerencia");
		if($this->id_vice){
			$criteria->addCondition("t.id_vice in (select id from vicepresidencias where upper(nombre) ilike '%".strtoupper($this->id_vice)."%')");
		}
		//$criteria->compare('id_gerencia',$this->id_gerencia);
		$criteria->compare('UPPER(gerencia.nombre)', strtoupper($this->gerencia_search), true);
		$criteria->compare('UPPER(t.nombre)',strtoupper($this->nombre),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
	        'attributes'=>array(
	            'gerencia_search'=>array(
	                'asc'=>'gerencia.nombre',
	                'desc'=>'gerencia.nombre DESC',
	            ),
	            '*',
	        ),
    	),
		));
	}

	public function nombreJefe($jefatura){
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
			where car.es_jefe = 'Si' and car.id_jefatura = $jefatura and (c.fecha_fin is null or c.fecha_fin > now()::date);
EOD;

		$res =  $this->dbConnection->createCommand($query)->queryAll();

		if(!count($res))
			throw new CException("No se encontró el nombre del jefe");

		return $res;
			

	}

	public function dependencias($attribute, $params){
			if($this->id_gerencia == "" & $this->id_vice == ""){
		        $this->addError($attribute, 'Gerencia o Vicepresidencia no puede ser nulo, diligencie alguno de los dos');
			}

	}
}