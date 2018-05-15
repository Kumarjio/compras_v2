<?php

/**
 * This is the model class for table "empleados".
 *
 * The followings are the available columns in table 'empleados':
 * @property integer $id
 * @property string $nombre_completo
 * @property string $genero
 * @property string $tipo_documento
 * @property string $numero_identificacion
 * @property string $activo
 * @property string $embarazo
 * @property integer $tiempo_gestacion
 * @property integer $fecha_probable_parto
 * @property string $creacion
 * @property string $actualizacion
 *
 * The followings are the available model relations:
 * @property Orden[] $ordens
 * @property Orden[] $ordens1
 * @property Orden[] $ordens2
 * @property Contratos[] $contratoses
 */
class Empleados extends CActiveRecord
{

  public $cargo;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Empleados the static model class
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
		return 'empleados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                     array('nombre_completo, numero_identificacion, email, cargo', 'required','on'=>'insert,update'),
			array('email', 'email'),
            array('numero_identificacion', 'unique', 'attributeName' => 'numero_identificacion'),
			array('tiempo_gestacion, fecha_probable_parto', 'numerical', 'integerOnly'=>true),
			array('nombre_completo, genero, tipo_documento, numero_identificacion, activo, embarazo', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre_completo, genero, tipo_documento, numero_identificacion, activo, embarazo, tiempo_gestacion, fecha_probable_parto', 'safe', 'on'=>'search'),
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
			'ordens' => array(self::HAS_MANY, 'Orden', 'id_gerente'),
			'ordens1' => array(self::HAS_MANY, 'Orden', 'id_jefe'),
			'ordens2' => array(self::HAS_MANY, 'Orden', 'id_usuario'),
			'contratoses' => array(self::HAS_MANY, 'Contratos', 'id_empleado'),
		);
	}

    public function behaviors()
    {
      return array(
     
          'ActiveRecordLogableBehavior'=>array(
              'class' => 'application.components.behavior.ActiveRecordLogableBehavior',
          ),

                   );
    }


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre_completo' => 'Nombre Completo',
			'genero' => 'Genero',
			'tipo_documento' => 'Tipo Documento',
			'numero_identificacion' => 'Numero Identificacion',
			'activo' => 'Activo',
			'embarazo' => 'Embarazo',
			'tiempo_gestacion' => 'Tiempo Gestacion',
			'fecha_probable_parto' => 'Fecha Probable Parto',
			'creacion' => 'Creacion',
			'actualizacion' => 'Actualizacion',
		);
	}


    protected function beforeValidate(){
      if($this->isNewRecord){
        $this->genero = 'M';
        $this->tipo_documento = "CC";
        $this->activo = "Si";
      }
      return true;
    }

    protected function afterSave(){
      if($this->isNewRecord){
        $c = new Contratos;
        $c->id_cargo = $this->cargo;
        $c->id_empleado = $this->id;
        $c->fecha_inicio = "2013-01-01";
        $c->save();

      }else{

        $c = Contratos::model()->findByAttributes(array('id_empleado' => $this->id));

        if($c !== null && $this->cargo != "" && $this->cargo != null){
          $c->id_cargo = $this->cargo;
          $c->save();
        }
      }


      return true;
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
		$criteria->compare('LOWER(nombre_completo)',strtolower($this->nombre_completo),true);
		$criteria->compare('genero',$this->genero,true);
		$criteria->compare('tipo_documento',$this->tipo_documento,true);
		$criteria->compare('numero_identificacion',$this->numero_identificacion,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('embarazo',$this->embarazo,true);
		$criteria->compare('tiempo_gestacion',$this->tiempo_gestacion);
		$criteria->compare('fecha_probable_parto',$this->fecha_probable_parto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5)
		));
	}

	public function search_negociador()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('es_negociador','Si', true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5)
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
		$criteria->compare('genero',$this->genero,true);
		$criteria->compare('tipo_documento',$this->tipo_documento,true);
		$criteria->compare('numero_identificacion',$this->numero_identificacion,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('embarazo',$this->embarazo,true);
		$criteria->compare('tiempo_gestacion',$this->tiempo_gestacion);
		$criteria->compare('fecha_probable_parto',$this->fecha_probable_parto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5)
		));
	}

    
	
	public function search_2($id_orden)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(nombre_completo)',strtolower($this->nombre_completo),true);
		$criteria->compare('genero',$this->genero,true);
		$criteria->compare('tipo_documento',$this->tipo_documento,true);
		$criteria->compare('numero_identificacion',$this->numero_identificacion,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('embarazo',$this->embarazo,true);
		$criteria->compare('tiempo_gestacion',$this->tiempo_gestacion);
		$criteria->compare('fecha_probable_parto',$this->fecha_probable_parto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5)
		));
	}

	public function search_3()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;

                $criteria->compare('id',$this->id);
                $criteria->compare('LOWER(nombre_completo)',strtolower($this->nombre_completo),true);
                $criteria->compare('genero',$this->genero,true);
                $criteria->compare('tipo_documento',$this->tipo_documento,true);
                $criteria->compare('numero_identificacion',$this->numero_identificacion,true);
                $criteria->compare('activo',$this->activo,true);
                $criteria->compare('embarazo',$this->embarazo,true);
                $criteria->compare('tiempo_gestacion',$this->tiempo_gestacion);
                $criteria->compare('fecha_probable_parto',$this->fecha_probable_parto);

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>5)
                ));
        }

    public function getNombre($id){
	    $emp = $this->findByPk($id);
	    return $emp->nombre_completo;
    }

    public function validarAdministrativoFacturas(){
    	$es_empleado = EmpleadosAdministrativoFacturas::model()
    			->findByAttributes(array('id_empleado' => Yii::app()->user->getState('id_empleado')));
    	if($es_empleado)
    		return true;
    	return false;
    }

}
