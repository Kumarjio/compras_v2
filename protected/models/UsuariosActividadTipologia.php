<?php

/**
 * This is the model class for table "usuarios_actividad_tipologia".
 *
 * The followings are the available columns in table 'usuarios_actividad_tipologia':
 * @property string $id
 * @property string $usuario
 * @property string $id_actividad_tipologia
 * @property integer $asignacion
 *
 * The followings are the available model relations:
 * @property Usuario $usuario0
 * @property ActividadTipologia $idActividadTipologia
 */
class UsuariosActividadTipologia extends CActiveRecord
{
	public $nombre_completo;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_actividad_tipologia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, id_actividad_tipologia', 'required'),
			array('asignacion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, id_actividad_tipologia, asignacion', 'safe', 'on'=>'search'),
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
			'usuario0' => array(self::BELONGS_TO, 'Usuario', 'usuario'),
			'idActividadTipologia' => array(self::BELONGS_TO, 'ActividadTipologia', 'id_actividad_tipologia'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Usuario',
			'id_actividad_tipologia' => 'Id Actividad Tipologia',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('id_actividad_tipologia',$this->id_actividad_tipologia,true);
		$criteria->compare('asignacion',$this->asignacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuariosActividadTipologia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function asignacionUsuarioActividad($sucesion)
	{
		$consulta_minimo = UsuariosActividadTipologia::model()->with( array('usuario0'=>array("alias"=>"c",'condition'=>'c.activo = true')))->findByAttributes(array("id_actividad_tipologia"=>$sucesion),array('order'=>'asignacion'));
		if($consulta_minimo){
			$usuario = $consulta_minimo->usuario;
			$consulta_maximo = UsuariosActividadTipologia::model()->with( array('usuario0'=>array("alias"=>"c",'condition'=>'c.activo = true')))->findByAttributes(array("id_actividad_tipologia"=>$sucesion),array('order'=>'asignacion DESC'));
			if($consulta_maximo){
				$maximo = $consulta_maximo->asignacion+1;
				$consulta_minimo->asignacion = $maximo;
				$consulta_minimo->save();
			}
		}else{
			$usuario = Yii::app()->user->usuario;
		}
		return $usuario;
	}
	public function search_detalle(){

		$criteria=new CDbCriteria;

		//$criteria->select = 't.usuario, ati.id_tipologia';
		//$criteria->join = "INNER JOIN actividad_tipologia AS ati ON ati.id = t.id_actividad_tipologia ";
		$criteria->compare('id',$this->id,true);
		$criteria->compare('usuario',$_GET['usuario']);
		$criteria->compare('id_actividad_tipologia',$this->id_actividad_tipologia,true);
		$criteria->compare('asignacion',$this->asignacion);

        //$criteria->group = 't.usuario, ati.id_tipologia';
        //$criteria->order = 'ati.id_tipologia ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getActividades(){
		$actividades = array();
		$consulta = ActividadTipologia::model()->findAllByAttributes(array("id"=>$this->id_actividad_tipologia));
		foreach ($consulta as $actividad) {
			array_push($actividades, ucwords(strtolower($actividad->idActividad->actividad)));
		}
		if(sizeof($actividades) == 0)
			return "";
		return "<ul><li>".implode("</li><li>", $actividades)."</li></ul>";
	}

	public static function cargaUsuariosActividad($id_actividad)
	{
		$usuario = Yii::app()->user->usuario;
		return CHtml::listData(UsuariosActividadTipologia::model()->findAll(array("condition"=>"id_actividad_tipologia =  $id_actividad AND \"usuario0\".\"activo\" = true AND \"usuario0\".\"usuario\" <> '$usuario'","select"=>"INITCAP(usuario0.nombres) || ' '|| INITCAP(usuario0.apellidos) AS nombre_completo",'order' => 'usuario0.nombres', 'with'=>'usuario0')),'usuario0.usuario',CHtml::encode('nombre_completo'),true);
	}
}