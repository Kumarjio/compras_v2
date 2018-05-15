<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property integer $id
 * @property string $rol
 *
 * The followings are the available model relations:
 * @property UsuariosRoles[] $usuariosRoles
 * @property PermisosRoles[] $permisosRoles
 */
class Roles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $buscar;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rol', 'required'),
			array('rol','unique','message'=>'{attribute} "{value}" ya existe.'),
			array('activo, buscar', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rol, activo, buscar', 'safe', 'on'=>'search'),
			array('rol', 'validaUnico'),
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
			'usuariosRoles' => array(self::HAS_MANY, 'UsuariosRoles', 'id_rol'),
			'permisosRoles' => array(self::HAS_MANY, 'PermisosRoles', 'id_rol'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rol' => 'Rol',
			'activo' => 'Activo',
			'buscar'=> 'Buscar',
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
		//$criteria->compare('rol',$this->rol,true);
		//$criteria->compare('activo',1);
		if(!empty($this->buscar)){
			$criteria->addCondition("rol in (select rol from usuario where rol ilike '%".$this->buscar."%')");
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id ASC',
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Roles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function cargarRoles()
	{
		$consulta = Yii::app()->db->createCommand("SELECT id, rol FROM roles WHERE activo = TRUE ORDER BY rol")->queryAll();
		return CHtml::listData($consulta,'id', 'rol');
	}
	public function getPermisos(){
		$permisos = array();
		foreach ($this->permisosRoles as $p) {
			array_push($permisos, $p->idPermiso->nombre_permiso);
		}
		if(sizeof($permisos) == 0)
			return "";
		return "<ul><li>".implode("</li><li>", $permisos)."</li></ul>";
	}
	public function validaUnico(){
		$criteriaVal = new CDbCriteria;
		$criteriaVal->addCondition("TRIM(rol) ILIKE '".trim($this->rol)."'");
		if(!$this->isNewRecord){
			$criteriaVal->addNotInCondition('id', array($this->id));
		}

		$duplicados = Roles::model()->findAll($criteriaVal);

		if($duplicados){
			$this->addError('rol', 'El nombre del rol ya existe en el sistema.');
		}
	}
}
