<?php

/**
 * This is the model class for table "gerencias".
 *
 * The followings are the available columns in table 'gerencias':
 * @property integer $id
 * @property string $nombre
 * @property string $creacion
 * @property string $actualizacion
 *
 * The followings are the available model relations:
 * @property Orden[] $ordens
 */
class Gerencias extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Gerencias the static model class
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
		return 'gerencias';
	}

	public function behaviors()
	{
		return array(
			'fechaRegistro' => array(
			'class' => 'application.components.behavior.FechaRegistroBehavior'
			),
		);
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
			array('nombre', 'length', 'max'=>255),
			array('atribuciones', 'numerical', 'integerOnly'=>true),
			array('actualizacion, atribuciones, id_vice, es_direccion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, actualizacion', 'safe', 'on'=>'search'),
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
			'ordens' => array(self::HAS_MANY, 'Orden', 'id_gerencia'),
			'jefaturas' => array(self::HAS_MANY, 'Jefaturas', 'id_gerencia'),
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
			'nombre' => 'Nombre',
			'actualizacion' => 'Actualizacion',
			'es_direccion' => 'Es Dirección',
			'id_vice' => 'Vicepresidencia',
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
		if($this->id_vice){
			$criteria->addCondition("id_vice in (select id from vicepresidencias where upper(nombre) ilike '%".strtoupper($this->id_vice)."%')");
		}

		if($this->es_direccion == "0")
			$criteria->addCondition("es_direccion is null");
		else
			$criteria->compare('es_direccion',$this->es_direccion);
		$criteria->compare('id',$this->id);
		$criteria->compare('UPPER(nombre)',strtoupper($this->nombre),true);
		$criteria->compare('actualizacion',$this->actualizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function nombreGerente($gerencia){
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
			where car.es_gerente = 'Si' and car.id_gerencia = $gerencia and (c.fecha_fin is null or c.fecha_fin > now()::date);
EOD;

		$res =  $this->dbConnection->createCommand($query)->queryAll();

		if(!count($res))
			throw new CException("No se encontró el gerente de la gerencia");

		return $res;
			

	}

	public function jefaturaYGerencia(){
	  
	  $empleado = Yii::app()->user->getState("id_empleado");
	  
	  $query = "select max(fecha_inicio),id_cargo,id_jefatura, id_gerencia, id_vice from cargos ca inner join contratos co on (ca.id = co.id_cargo) where id_empleado = $empleado group by id_cargo, id_jefatura, id_gerencia, id_vice";

	  $res =  $this->dbConnection->createCommand($query)->queryAll();


	  $decir_jefe = "select id_empleado from contratos where id_cargo = (select id from cargos where id_jefatura = {$res[0]['id_jefatura']} and es_jefe = 'Si')";

	  $decir_gerente = "select id_empleado from contratos where id_cargo = (select id from cargos where id_gerencia = {$res[0]['id_gerencia']} and es_gerente = 'Si')";

	  $decir_vice = "select id_empleado from contratos where id_cargo = (select id from cargos where id_vice = {$res[0]['id_vice']} and es_vice = 'Si')";
      


	  if($res[0]['id_vice'] != ""){
        $vice = $this->dbConnection->createCommand($decir_vice)->queryAll();
	  	$res[0]['id_vicepre'] = $vice[0]['id_empleado'];
	  }
	  else {
	  	$res[0]['id_vice'] = null;
	  }

	  if($res[0]['id_gerencia'] != ""){
	  	$gerencia_activa = Gerencias::model()->findByPk($res[0]['id_gerencia'])->activo;
	  	if($gerencia_activa){
	        $gerente = $this->dbConnection->createCommand($decir_gerente)->queryAll();	  
		  	$res[0]['id_gerente'] = $gerente[0]['id_empleado'];
	  	}
	  	else
	  		$res[0]['val_gerencia'] = true;
	  }
	  else {
	  	$res[0]['id_gerente'] = null;
	  }

	  if($res[0]['id_jefatura'] != ""){
        $jefe = $this->dbConnection->createCommand($decir_jefe)->queryAll();
	  	$res[0]['id_jefe'] = $jefe[0]['id_empleado']; 
	  }
	  else {
	  	$res[0]['id_jefe'] = null; 
	  }
	  /*else if(!Yii::app()->user->getState("gerente") == true){
        if($res[0]['id_jefatura'] != ""){
          $jefe = $this->dbConnection->createCommand($decir_jefe)->queryAll();
          $res[0]['id_jefe'] = $jefe[0]['id_empleado'];
        }else{
          $res[0]['id_jefe'] = null;
        }
	  }else{
	  	$jefe = $this->dbConnection->createCommand($decir_jefe)->queryAll();
	  	if($empleado == $jefe[0]['id_empleado']){
	  		$res[0]['id_jefe'] = $jefe[0]['id_empleado'];
	  	}
	  	else{
  			$res[0]['id_jefe'] = null;
  		}
	  }
	  
	  $gerente = $this->dbConnection->createCommand($decir_gerente)->queryAll();	  
	  $res[0]['id_gerente'] = $gerente[0]['id_empleado'];*/


	  return $res;

	  
	  
	}
}

