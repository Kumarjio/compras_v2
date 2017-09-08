<?php

/**
 * This is the model class for table "usuarios_flujo".
 *
 * The followings are the available columns in table 'usuarios_flujo':
 * @property integer $id
 * @property string $usuario
 * @property string $flujo
 * @property string $asignacion
 *
 * The followings are the available model relations:
 * @property Flujo $flujo0
 */
class UsuariosFlujo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_flujo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, flujo', 'required'),
			array('asignacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, flujo, asignacion', 'safe', 'on'=>'search'),
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
            'flujo0' => array(self::BELONGS_TO, 'Flujo', 'flujo'),
            'usuario0' => array(self::BELONGS_TO, 'Usuario', 'usuario'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'USUARIOS',
			'flujo' => 'Flujo',
			'asignacion' => 'Asignacion',
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
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('flujo',$this->flujo,true);
		$criteria->compare('asignacion',$this->asignacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuariosFlujo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function asignacionUsuario($flujo)
	{
		$actividad = Actividades::model()->consultaActividad($flujo);
		if($actividad != "3"){
			$consulta_minimo = UsuariosFlujo::model()->findByAttributes(array("flujo"=>$flujo),array('order'=>'asignacion'));
			if($consulta_minimo){
				$usuario = $consulta_minimo->usuario;
				$consulta_maximo = UsuariosFlujo::model()->findByAttributes(array("flujo"=>$flujo),array('order'=>'asignacion DESC'));
				if($consulta_maximo){
					$maximo = $consulta_maximo->asignacion+1;
					$consulta_minimo->asignacion = $maximo;
					$consulta_minimo->save();
					return $usuario;
				}
			}
		}else{
			$usuario = Yii::app()->user->usuario;
		}
	}
	public function search_detalle()
	{
		$criteria=new CDbCriteria;
		if(!empty($_POST['id'])){
			$criteria->compare('flujo',$_POST['id']);
		}else{
			$criteria->compare('flujo',-1);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false
		));
	}
}
