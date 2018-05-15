<?php
/**
 * This is the model class for table "adjuntos_trazabilidad".
 *
 * The followings are the available columns in table 'adjuntos_trazabilidad':
 * @property integer $id
 * @property string $id_trazabilidad
 * @property string $na
 * @property string $fecha
 * @property string $usuario
 * @property string $path
 *
 * The followings are the available model relations:
 * @property Trazabilidad $idTrazabilidad
 * @property Recepcion $na0
 * @property Usuario $usuario0
 */
class AdjuntosTrazabilidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $archivo;
	public function tableName()
	{
		return 'adjuntos_trazabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_trazabilidad, na, archivo', 'required'),
			//array('archivo', 'file', 'types'=>'jpg, gif, png, pdf, xls, csv, msg, tif', 'safe' => false),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_trazabilidad, na, fecha, usuario, path', 'safe', 'on'=>'search'),
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
            'na0' => array(self::BELONGS_TO, 'Recepcion', 'na'),
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
			'id_trazabilidad' => 'Id Trazabilidad',
			'na' => 'Na',
			'fecha' => 'Fecha',
			'usuario' => 'Usuario',
			'path' => 'Path',
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
		$criteria->compare('id_trazabilidad',$this->id_trazabilidad,true);
		$criteria->compare('na',$this->na,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdjuntosTrazabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function adjuntosConsulta($na)
	{
		return AdjuntosTrazabilidad::model()->findByAttributes(array('na'=>$na));
	}
	public function search_adjuntos()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('id_trazabilidad',$this->id_trazabilidad,true);
		$criteria->compare('na',$_POST['na']);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function extensionAdjunto($path){
		$imagen = dirname(__FILE__).'/../images/';
		/*$fi = new finfo(FILEINFO_MIME,'/usr/share/file/magic');
		$mime_type = $fi->buffer(file_get_contents($path));
		$mime_type = explode(";",$mime_type);
		$mime_type = explode("/", $mime_type[0]);
		$mime_type = $mime_type[1];*/
		$path2 = str_replace("http://correspondencia.imaginex/", "/vol2/", $path); 
		$nombre = basename($path);
		$ext= substr($nombre,stripos($nombre, '.')+1);
		$mime_type = strtolower($ext);
		if($mime_type == "jpeg" || $mime_type == "png" || $mime_type == "gif" || $mime_type == "pjpeg" || $mime_type == "bmp" || $mime_type == "jpg"){
			return CHtml::link('<img src="/images/imagen.jpg" width="26px" height="26px">',$path, array('class'=>'ficebox'));
		}else if($mime_type == "pdf"){	
			return CHtml::link('<img src="/images/pdf.png" width="27px" height="27px">',$path, array('class'=>'ficebox'));

		}else if($mime_type == "xls" || $mime_type == "xlsx" || $mime_type == "vnd.ms-excel"){	
			return CHtml::link('<img src="/images/excel.png" width="30px" height="30px">',array('trazabilidad/download','path'=>$path));
		
		}else if($mime_type == "msg"){	
			return CHtml::link('<img src="/images/msg.jpg" width="30px" height="20px">',array('trazabilidad/download','path'=>$path));

		}else if($mime_type == "tiff" || $mime_type == "tif"){	
			//return CHtml::link('<img src="/images/imagen.jpg" width="26px" height="26px">',array('trazabilidad/visorImagenesTif','path'=>$path));
			return CHtml::link('<img src="/images/imagen.jpg" width="26px" height="26px">',$path, array('class'=>'imagenTiff','id'=>basename($path)));

		}else{
			return CHtml::link('<img src="/images/document.png" width="30px" height="30px">',array('trazabilidad/download','path'=>$path));
		}
	}
	public static function guardaAdjuntos($data,$id_trazabilidad,$na){
		foreach ($data as $adjunto) {
			$adjunto->path = str_replace("http://".$_SERVER['HTTP_HOST'],"/vol2",$adjunto->path);
			$nombre = basename($adjunto->path);
			$ext= substr($nombre,stripos($nombre, '.')+1);
			$nombre = "ADJ".Yii::app()->db->createCommand("SELECT nextval('concecutivos_adjuntos_seq')")->queryScalar();
			$ruta = "/vol2/img04/arp/".date("Ymd")."/".$na."/";									
			if(!file_exists($ruta)){
				mkdir($ruta, 0775, true);
			}
			if(file_exists($ruta)){
				rename($adjunto->path, $ruta.$nombre.".".$ext);
			}
			if(file_exists($adjunto->path)){
				unlink($adjunto->path);
			}
			$adjuntos_trazabilidad = new AdjuntosTrazabilidad;
			$adjuntos_trazabilidad->archivo = $ruta.$nombre.".".$ext;
			$adjuntos_trazabilidad->archivo = str_replace("/vol2","http://".$_SERVER['HTTP_HOST'],$adjuntos_trazabilidad->archivo);
			$adjuntos_trazabilidad->path = $adjuntos_trazabilidad->archivo;
			$adjuntos_trazabilidad->id_trazabilidad = $id_trazabilidad;
			$adjuntos_trazabilidad->na = $na;
			$adjuntos_trazabilidad->usuario = Yii::app()->user->usuario;
			$adjuntos_trazabilidad->save();
		}
		return true;
	}
	public static function guardaAdjuntosCargue($id_trazabilidad,$na,$codigo_barras){

			$adjunto = new AdjuntosTrazabilidad;
			$adjunto->path = CargueMasivo::getPath($codigo_barras);
			$nombre = basename($adjunto->path);
			$ruta = "/vol2/img04/arp/".date("Ymd")."/".$na."/";									
			if(!file_exists($ruta)){
				mkdir($ruta, 0775, true);
			}
			if(file_exists($ruta)){
				rename($adjunto->path, $ruta.$nombre);
			}
			if(file_exists($adjunto->path)){
				unlink($adjunto->path);
			}
			$adjunto->archivo = $ruta.$nombre;
			$adjunto->archivo = str_replace("/vol2","http://".$_SERVER['HTTP_HOST'],$adjunto->archivo);
			$adjunto->path = $adjunto->archivo;
			$adjunto->id_trazabilidad = $id_trazabilidad;
			$adjunto->na = $na;
			$adjunto->usuario = Yii::app()->user->usuario;
			return $adjunto->save();
	}
}
