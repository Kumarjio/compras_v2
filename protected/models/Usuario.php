<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $usuario
 * @property string $nombres
 * @property string $apellidos
 * @property string $correo
 * @property boolean $activo
 * @property boolean $bloqueado
 * @property string $fecha_creacion
 * @property string $usuario_creacion
 * @property string $contraseña
 * @property integer $cargo
 * @property integer $area
 *
 * The followings are the available model relations:
 * @property Cargos $cargo0
 * @property Areas $area0
 */
class Usuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $repetir;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, nombres, contraseña, repetir, apellidos, correo, cargo, area', 'required'),
			array('cargo, area, usuario', 'numerical', 'integerOnly'=>true),
			array('apellidos, activo, bloqueado', 'safe'),
			array('correo','email'),
			array('repetir', 'compare', 'compareAttribute'=>'contraseña'),
			array('repetir', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, nombres, apellidos, correo, activo, bloqueado, fecha_creacion, usuario_creacion, contraseña, cargo, area', 'safe', 'on'=>'search'),
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
			'cargo0' => array(self::BELONGS_TO, 'Cargos', 'cargo'),
			'area0' => array(self::BELONGS_TO, 'Areas', 'area'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Documento (Usuario)',
			'nombres' => 'Nombres',
			'apellidos' => 'Apellidos',
			'correo' => 'Correo',
			'activo' => 'Activo',
			'bloqueado' => 'Bloqueado',
			'fecha_creacion' => 'Fecha Creación',
			'usuario_creacion' => 'Usuario Creacion',
			'contraseña' => 'Contraseña',
			'cargo' => 'Cargo',
			'area' => 'Área',
			'repetir' => 'Confirmar Contraseña',
		);
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

		//$criteria->compare('usuario',$this->usuario,true);
		//$criteria->compare('nombres',$this->nombres,true);
		//$criteria->compare('apellidos',$this->apellidos,true);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true); //Pendiente
		/*$criteria->compare('cargo',$this->cargo);*/
		/*$criteria->compare('area',$this->area);*/
		$criteria->with = array('area0','cargo0');

		if($this->usuario != ''){
			$criteria->addCondition("usuario in (select usuario from usuario where usuario = '".$this->usuario."')");
		}
		if($this->nombres != ''){
			$criteria->addCondition("nombres in (select nombres from usuario where nombres ilike '%".$this->nombres."%')");
		}
		if($this->apellidos != ''){
			$criteria->addCondition("apellidos in (select apellidos from usuario where apellidos ilike '%".$this->apellidos."%')");
		}
		if($this->cargo != ''){
			$criteria->addCondition(array('"cargo0"."cargo" ilike \'%'.$this->cargo.'%\''));

		}
		if($this->area != ''){
			$criteria->addCondition(array('"area0"."area" ilike \'%'.$this->area.'%\''));
		}

		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('activo',1);
		$criteria->compare('bloqueado',$this->bloqueado);
		$criteria->compare('usuario_creacion',$this->usuario_creacion,true);
		$criteria->compare('contraseña',$this->contraseña,true);
		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.id ASC',
			)
		));
	}
	
	/*public function cargarUsuarios(){
		$model = $this->findAll();
		return CHtml::listData($model, 'usuario', 'nombres');
	}*/

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function cargarUsuarios(){
		$consulta_Usuarios = Yii::app()->db->createCommand("SELECT usuario, nombres || ' ' || apellidos AS nombres FROM usuario WHERE activo = TRUE ORDER BY nombres")->queryAll();
		$usuarios = CHtml::listData($consulta_Usuarios,'usuario', 'nombres');
	 	return $usuarios;
	}
	public function nombres($documento){
		$usuario = Usuario::model()->findByAttributes(array("usuario"=>$documento));
		return ucwords(strtolower($usuario->nombres.' '.$usuario->apellidos));
	}
}
