<?php

/**
 * This is the model class for table "cargos".
 *
 * The followings are the available columns in table 'cargos':
 * @property integer $id
 * @property integer $id_jefatura
 * @property string $nombre
 * @property string $recibe_dotacion
 * @property integer $es_jefe
 * @property integer $es_gerente
 * @property string $activo
 * @property string $creacion
 * @property string $actualizacion
 *
 * The followings are the available model relations:
 * @property Contratos[] $contratoses
 * @property Jefaturas $idJefatura
 */
class Cargos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cargos the static model class
	 */
	public $tipo_cargo;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cargos';
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
			array('id_jefatura, id_gerencia, id_vice', 'numerical', 'integerOnly'=>true),
			array('nombre, recibe_dotacion, activo', 'length', 'max'=>255),
			array('tipo_cargo', 'safe'),
			array('id_jefatura, id_gerencia, id_vice', 'dependencias', 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_jefatura, nombre, recibe_dotacion, es_jefe, es_gerente, activo, es_vice, id_vice', 'safe', 'on'=>'search'),
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
			'contratoses' => array(self::HAS_MANY, 'Contratos', 'id_cargo'),
			'idJefatura' => array(self::BELONGS_TO, 'Jefaturas', 'id_jefatura'),
			'idGerencia' => array(self::BELONGS_TO, 'Gerencias', 'id_gerencia'),
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
			'id_jefatura' => 'Jefatura',
			'id_gerencia' => 'Gerencia o Dirección',
			'id_vice' => 'Vicepresidencia',
			'nombre' => 'Nombre',
			'recibe_dotacion' => 'Recibe Dotacion',
			'es_jefe' => 'Es Jefe',
			'es_gerente' => 'Es Gerente',
			'activo' => 'Activo',
			
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
		if($this->es_jefe == "1")
			$criteria->addCondition("es_jefe is null");
		else
			$criteria->compare('es_jefe',$this->es_jefe);
			
		if($this->es_gerente == "1")
			$criteria->addCondition("es_gerente is null");
		else
			$criteria->compare('es_gerente',$this->es_gerente);

		if($this->es_vice == "1")
			$criteria->addCondition("es_vice is null");
		else
			$criteria->compare('es_vice',$this->es_vice);

		if($this->id_jefatura){
			$criteria->addCondition("id_jefatura in (select id from Jefaturas where upper(nombre) ilike '%".strtoupper($this->id_jefatura)."%')");
		}
		if($this->id_gerencia){
			$criteria->addCondition("id_gerencia in (select id from gerencias where upper(nombre) ilike '%".strtoupper($this->id_gerencia)."%')");
		}
		if($this->id_vice){
			$criteria->addCondition("id_vice in (select id from vicepresidencias where upper(nombre) ilike '%".strtoupper($this->id_vice)."%')");
		}
		$criteria->compare('id',$this->id);
		$criteria->compare('upper(nombre)',strtoupper($this->nombre),true);
		$criteria->compare('recibe_dotacion',$this->recibe_dotacion,true);
		$criteria->compare('activo',$this->activo,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function dependencias($attribute, $params){
		if($this->tipo_cargo == "" || $this->tipo_cargo == 1){
			if($attribute == "id_jefatura"){
		        $ev = CValidator::createValidator('required', $this, $attribute, $params);
		        $ev->validate($this);
		        if($this->tipo_cargo == 1 && $this->id_jefatura != '' ){
		        	$j = Cargos::model()->findAllByAttributes(array('id_jefatura'=>$this->id_jefatura, 'es_jefe' =>'Si'));
		        	if($j)
		        		$this->addError($attribute, 'La jefatura ya tiene un cargo asociado como jefe');
		        }
			}

		}
		elseif ($this->tipo_cargo == 2) {
			if($attribute == "id_gerencia"){
		        $ev = CValidator::createValidator('required', $this, $attribute, $params);
		        $ev->validate($this);
		        if($this->id_gerencia != '' ){
		        	$g = Cargos::model()->findAllByAttributes(array('id_gerencia'=>$this->id_gerencia, 'es_gerente' =>'Si'));
		        	if($g)
		        		$this->addError($attribute, 'La Gerencia ya tiene un cargo asociado como Gerente');
		        }
			}
			$this->id_jefatura = "";
		}
		elseif ($this->tipo_cargo == 3) {
			
			if($attribute == "id_vice"){
		        $ev = CValidator::createValidator('required', $this, $attribute, $params);
		        $ev->validate($this);
		        if($this->id_vice != '' ){
		        	$g = Cargos::model()->findAllByAttributes(array('id_vice'=>$this->id_vice, 'es_vice' =>'Si'));
		        	if($g)
		        		$this->addError($attribute, 'La Vicepresidencia ya tiene un cargo asociado como Vicepresidente');
		        }
			}	
			$this->id_jefatura = "";
			$this->id_gerencia = "";
		}
	}
}