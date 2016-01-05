<?php

/**
 * This is the model class for table "viajes.empleados".
 *
 * The followings are the available columns in table 'viajes.empleados':
 * @property integer $id
 * @property string $numero_identificacion
 * @property string $nombre_completo
 * @property boolean $es_jefe
 * @property boolean $es_gerente
 * @property integer $id_jefe
 * @property integer $id_gerente
 * @property string $creacion
 * @property string $actualizacion
 *
 * The followings are the available model relations:
 * @property ContactoEmpleados[] $contactoEmpleadoses
 * @property Viaje[] $viajes
 * @property Viaje[] $viajes1
 * @property Viaje[] $viajes2
 * @property Viaje[] $viajes3
 * @property Viaje[] $viajes4
 * @property Empleados $idJefe
 * @property Empleados[] $empleadoses
 * @property Empleados $idGerente
 * @property Empleados[] $empleadoses1
 */
class Empleados extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'viajes.empleados';
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
			array('numero_identificacion, nombre_completo, email, cuenta_ahorros', 'required'),
			array('email', 'email'),
			array('numero_identificacion', 'unique','attributeName' => 'numero_identificacion'),
			array('id_jefe, id_gerente', 'numerical', 'integerOnly'=>true),
			array('numero_identificacion', 'length', 'max'=>30),
			array('id_gerente', "requeridos_con_jefe"),
			array('nombre_completo', 'length', 'max'=>100),
			array('es_jefe, es_gerente, creacion, actualizacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, numero_identificacion, nombre_completo, es_jefe, es_gerente, id_jefe, id_gerente, creacion, actualizacion', 'safe', 'on'=>'search'),
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
			'contactoEmpleadoses' => array(self::HAS_MANY, 'ContactoEmpleados', 'empleado'),
			'viajes' => array(self::HAS_MANY, 'Viaje', 'solicitante'),
			'viajes1' => array(self::HAS_MANY, 'Viaje', 'id_jefe'),
			'viajes2' => array(self::HAS_MANY, 'Viaje', 'id_gerente'),
			'viajes3' => array(self::HAS_MANY, 'Viaje', 'id_viajero_empleado'),
			'viajes4' => array(self::HAS_MANY, 'Viaje', 'usuario_actual'),
			'idJefe' => array(self::BELONGS_TO, 'Empleados', 'id_jefe'),
			'empleadoses' => array(self::HAS_MANY, 'Empleados', 'id_jefe'),
			'idGerente' => array(self::BELONGS_TO, 'Empleados', 'id_gerente'),
			'empleadoses1' => array(self::HAS_MANY, 'Empleados', 'id_gerente'),
		);
	}

	public function requeridos_con_jefe(){
		if($this->id_jefe != "" && $this->id_gerente == ""){	
			$this->addError("id_gerente", "Si el empleado tiene primer aprobador, debe tener un segundo aprobador");
		}

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'numero_identificacion' => 'Numero Identificacion',
			'nombre_completo' => 'Nombre Completo',
			'es_jefe' => 'Es Jefe',
			'es_gerente' => 'Es Gerente',
			'id_jefe' => 'Primer Aprobador',
			'id_gerente' => 'Segundo Aprobador',
			'creacion' => 'Creacion',
			'actualizacion' => 'Actualizacion',
		);
	}

	public function esJefe($id_jefe, $id_gerente){
		$id = Yii::app()->user->id_empleado;
		if(($id_jefe == null && $id_gerente != null) || $id == $id_jefe)
			return true;
		
		return false;
	}

	public function esGerente($id_gerente){
		$id = Yii::app()->user->id_empleado;
		$reemplazandoGerente = Empleados::model()->findByAttributes(array('reemplazo' => $id));
		if($reemplazandoGerente !== NULL){
			if($id_gerente == $reemplazandoGerente->id){
				return true;
			}
		}
		return $id == $id_gerente;
	}

	public function esAdmin(){
		$pars = Parametros::model()->find();
		return $pars->usuario_administrativo == Yii::app()->user->id_empleado;
	}


	public function nombreEmpleado($id){
		$e = $this->findByPk($id);
		return $e->nombre_completo;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('numero_identificacion',$this->numero_identificacion,true);
		$criteria->compare('lower(nombre_completo)',strtolower($this->nombre_completo),true);
		$criteria->compare('es_jefe',$this->es_jefe);
		$criteria->compare('es_gerente',$this->es_gerente);
		$criteria->compare('id_jefe',$this->id_jefe);
		$criteria->compare('id_gerente',$this->id_gerente);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('actualizacion',$this->actualizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_reemp()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->condition = "reemplazo is not null";
		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(nombre_completo)',strtolower($this->nombre_completo),true);
		$criteria->compare('numero_identificacion',$this->numero_identificacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5)
		));
	}

	public function todosLosGerentes(){
		$c = new CDbCriteria;
		$c->select = "id, nombre_completo";
		$c->condition = "id_jefe is null and id_gerente is null";
		return Empleados::model()->findAll($c);
	}

	public function getNombre($id){
      $emp = $this->findByPk($id);
      return $emp->nombre_completo;
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Empleados the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
