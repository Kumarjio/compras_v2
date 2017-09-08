<?php

/**
 * This is the model class for table "trazabilidad".
 *
 * The followings are the available columns in table 'trazabilidad':
 * @property string $id
 * @property string $na
 * @property string $user_asign
 * @property string $fecha_asign
 * @property integer $estado
 * @property integer $actividad
 * @property string $user_cierre
 * @property string $fecha_cierre
 *
 * The followings are the available model relations:
 * @property Recepcion $na0
 * @property Estados $estado0
 * @property Flujo $actividad0
 * @property Usuario $user_asign0
 */
class Trazabilidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trazabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('na, user_asign, estado, actividad', 'required'),
			array('estado, actividad', 'numerical', 'integerOnly'=>true),
			array('user_cierre, fecha_cierre, user_asign', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, na, user_asign, fecha_asign, estado, actividad, user_cierre, fecha_cierre', 'safe', 'on'=>'search'),
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
			'na0' => array(self::BELONGS_TO, 'Recepcion', 'na'),
			'estado0' => array(self::BELONGS_TO, 'Estados', 'estado'),
			'actividad0' => array(self::BELONGS_TO, 'Flujo', 'actividad'),
			'user_asign0' => array(self::BELONGS_TO, 'Usuario', 'user_asign'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'na' => 'Na',
			'user_asign' => 'Usuario',
			'fecha_asign' => 'Fecha Asign',
			'estado' => 'Estado',
			'actividad' => 'Actividad',
			'user_cierre' => 'User Cierre',
			'fecha_cierre' => 'Fecha Cierre',
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
		$criteria->compare('na',$this->na,true);
		$criteria->compare('user_asign',$this->user_asign,true);
		$criteria->compare('fecha_asign',$this->fecha_asign,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('actividad',$this->actividad);
		$criteria->compare('user_cierre',$this->user_cierre,true);
		$criteria->compare('fecha_cierre',$this->fecha_cierre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Trazabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function informacionTrazabilidad($na)
	{
		$trazabilidad = Trazabilidad::model()->findByAttributes(array("na"=>$na),array('order'=>'id DESC'));
		return $trazabilidad;
	}
	public function search_detalle()
	{
		$criteria=new CDbCriteria;
		if(!empty($_GET['na'])){
			$criteria->compare('na',base64_decode($_GET['na']));
		}else{
			$criteria->compare('na',-1);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			    'defaultOrder'=>'id ASC',
			  )
		));
	}
	public function search_pendientes()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('na',$this->na,true);
		$criteria->compare('user_asign',Yii::app()->user->usuario);
		$criteria->compare('fecha_asign',$this->fecha_asign,true);
		$criteria->compare('estado', '1');
		$criteria->compare('actividad',$this->actividad);
		$criteria->compare('user_cierre',$this->user_cierre,true);
		$criteria->compare('fecha_cierre',$this->fecha_cierre,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function estado($na){
		$model = Trazabilidad::model();
		if($this->fecha_cierre == ''){
			$imagesDir = dirname(__FILE__).'/../images/'; 
			$fecha_hasta = strtotime("+".$this->actividad0->actividad0->tiempo_empresa." days", strtotime($this->fecha_asign));
			$fecha_hoy = strtotime(date("y-m-d"));
			if($fecha_hasta == $fecha_hoy)
				return CHtml::image(Yii::app()->assetManager->publish($imagesDir.'circle_yellow.png'),"",array("style"=>"width:20px;height:20px;"));
			elseif($fecha_hasta > $fecha_hoy)
				return CHtml::image(Yii::app()->assetManager->publish($imagesDir.'circle_green.png'),"",array("style"=>"width:20px;height:20px;"));
			else
				return CHtml::image(Yii::app()->assetManager->publish($imagesDir.'circle_red.png'),"",array("style"=>"width:20px;height:20px;"));
			//return CHtml::button('hola');
			return CHtml::tag('a',array( 'class'=>'holsdafdsala','onclick'=> "return false;", 'hoaos'=>'jjlll'),$imagen);
			return CHtml::link($imagen,$this->na, array('onclick'=> 'return false;', 'class'=>'holla'));
		}
		else
			return '';
	}

	public function traerImagen($na){
		return "algo con imagen.".$na;
	}
}
