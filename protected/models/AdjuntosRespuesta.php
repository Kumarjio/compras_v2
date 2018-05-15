<?php

/**
 * This is the model class for table "adjuntos_respuesta".
 *
 * The followings are the available columns in table 'adjuntos_respuesta':
 * @property string $id_adjunto
 * @property integer $id_trazabilidad
 * @property string $nombre_adjunto
 * @property string $path_web
 * @property string $path_fisico
 * @property string $usuario
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Trazabilidad $idTrazabilidad
 * @property Usuario $usuario0
 */
class AdjuntosRespuesta extends CActiveRecord
{
	public $archivo;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'adjuntos_respuesta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_trazabilidad, archivo, usuario, fecha', 'required'),
			array('id_trazabilidad', 'numerical', 'integerOnly'=>true),
			array('nombre_adjunto, archivo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_adjunto, id_trazabilidad, nombre_adjunto, path_web, path_fisico, usuario, fecha', 'safe', 'on'=>'search'),
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
			'idTrazabilidad' => array(self::BELONGS_TO, 'Trazabilidad', 'id_trazabilidad'),
			'usuario0' => array(self::BELONGS_TO, 'Usuario', 'usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_adjunto' => 'Id Adjunto',
			'id_trazabilidad' => 'Id Trazabilidad',
			'nombre_adjunto' => 'Nombre Adjunto',
			'path_web' => 'Path Web',
			'path_fisico' => 'Path Fisico',
			'usuario' => 'Usuario',
			'fecha' => 'Fecha',
			'archivo' => 'Archivo',
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

		$criteria->compare('id_adjunto',$this->id_adjunto,true);
		$criteria->compare('id_trazabilidad',$this->id_trazabilidad);
		$criteria->compare('nombre_adjunto',$this->nombre_adjunto,true);
		$criteria->compare('path_web',$this->path_web,true);
		$criteria->compare('path_fisico',$this->path_fisico,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_adjuntos()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$casos = array();
		$sqlTra = "SELECT id FROM trazabilidad WHERE na = ".$_POST['na'];
		$qryTra = Yii::app()->db->createCommand($sqlTra)->queryAll();
		foreach($qryTra as $traza){
			$casos[] = $traza['id'];
		}
		$criteria = new CDbCriteria;	

		$criteria->compare('id_adjunto',$this->id_adjunto,true);
		$criteria->addInCondition('id_trazabilidad',$casos);
		//$criteria->compare('id_trazabilidad',$this->id_trazabilidad);
		$criteria->compare('nombre_adjunto',$this->nombre_adjunto,true);
		$criteria->compare('path_web',$this->path_web,true);
		$criteria->compare('path_fisico',$this->path_fisico,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate(){		
		
		$this->usuario = Yii::app()->user->usuario;
		$this->fecha = date("Y-m-d H:i:s");

		return parent::beforeValidate();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdjuntosRespuesta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function cargaLink($path){
		$imagen = dirname(__FILE__).'/../images/';
		$nombre = basename($path);
		$ext = substr($nombre,stripos($nombre, '.')+1);
		$mime_type = strtolower($ext);
		if($mime_type == "jpeg" || $mime_type == "png" || $mime_type == "gif" || $mime_type == "pjpeg" || $mime_type == "bmp" || $mime_type == "jpg"){
			return CHtml::link('<img src="/images/imagen.jpg" width="26px" height="26px">',$path, array('class'=>'ficebox'));
		}else if($mime_type == "pdf"){	
			return CHtml::link('<img src="/images/pdf.png" width="26px" height="26px">',$path, array('class'=>'ficebox'));
		}else if($mime_type == "xls" || $mime_type == "xlsx" || $mime_type == "vnd.ms-excel"){	
			return CHtml::link('<img src="/images/excel.png" width="30px" height="30px">',array('trazabilidad/download','path'=>$path));
		
		}else if($mime_type == "msg"){	
			return CHtml::link('<img src="/images/msg.jpg" width="30px" height="20px">',array('trazabilidad/download','path'=>$path));

		}else if($mime_type == "tiff" || $mime_type == "tif"){
			return CHtml::link('<img src="/images/imagen.jpg" width="26px" height="26px">',$path, array('class'=>'imagenTiff','id'=>basename($path)));
		}else{
			return CHtml::link('<img src="/images/document.png" width="30px" height="30px">',array('trazabilidad/download','path'=>$path));
		}
	}
}
