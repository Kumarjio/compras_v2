<?php

/**
 * This is the model class for table "medicos".
 *
 * The followings are the available columns in table 'medicos':
 * @property integer $id_medico
 * @property string $cedula
 * @property string $primer_nombre
 * @property string $segundo_nombre
 * @property string $primer_apellido
 * @property string $segundo_apellido
 * @property string $direccion
 * @property integer $telefono_fijo
 * @property string $ciudad
 * @property string $celular
 * @property string $correo
 * @property string $tarjeta_profesional
 * @property string $nro_cuenta_bancaria
 * @property string $entidad_bancaria
 * @property integer $estado
 */
class Medicos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'medicos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('telefono_fijo, estado', 'numerical', 'integerOnly'=>true),
			array('cedula, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, direccion, ciudad, celular, correo, tarjeta_profesional, nro_cuenta_bancaria, entidad_bancaria', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_medico, cedula, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, direccion, telefono_fijo, ciudad, celular, correo, tarjeta_profesional, nro_cuenta_bancaria, entidad_bancaria, estado', 'safe', 'on'=>'search'),
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
			'id_medico' => 'Id Medico',
			'cedula' => 'Cedula',
			'primer_nombre' => 'Primer Nombre',
			'segundo_nombre' => 'Segundo Nombre',
			'primer_apellido' => 'Primer Apellido',
			'segundo_apellido' => 'Segundo Apellido',
			'direccion' => 'Direccion',
			'telefono_fijo' => 'Telefono Fijo',
			'ciudad' => 'Ciudad',
			'celular' => 'Celular',
			'correo' => 'Correo',
			'tarjeta_profesional' => 'Tarjeta Profesional',
			'nro_cuenta_bancaria' => 'Nro Cuenta Bancaria',
			'entidad_bancaria' => 'Entidad Bancaria',
			'estado' => 'Estado',
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

		$criteria->compare('id_medico',$this->id_medico);
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('primer_nombre',$this->primer_nombre,true);
		$criteria->compare('segundo_nombre',$this->segundo_nombre,true);
		$criteria->compare('primer_apellido',$this->primer_apellido,true);
		$criteria->compare('segundo_apellido',$this->segundo_apellido,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('telefono_fijo',$this->telefono_fijo);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('tarjeta_profesional',$this->tarjeta_profesional,true);
		$criteria->compare('nro_cuenta_bancaria',$this->nro_cuenta_bancaria,true);
		$criteria->compare('entidad_bancaria',$this->entidad_bancaria,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function nombreCompleto($id_medico) {
        $model = $this->findByPk($id_medico);
        return $model->primer_nombre . ' ' .$model->segundo_nombre . ' ' .$model->primer_apellido . ' ' .$model->segundo_apellido;
    }

    public function getNombreCompleto(){

		$nombreCom = $this->primer_nombre;
		if(empty($this->segundo_nombre))
			$nombreCom .= " ".$this->primer_apellido;
		else
			$nombreCom .= " ".$this->segundo_nombre." ".$this->primer_apellido;

		if(!empty($this->segundo_apellido))
			$nombreCom .= " ".$this->segundo_apellido;

		return $nombreCom;
	}

	protected function beforeValidate(){

		if(empty($this->segundo_nombre))
      		$this->segundo_nombre = " ";		
		
      	if(empty($this->segundo_apellido))
      		$this->segundo_apellido = " ";


		return parent::beforeValidate();
	}
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Medicos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
