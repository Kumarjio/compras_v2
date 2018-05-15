<?php
/**
 * This is the model class for table "cargue_masivo".
 *
 * The followings are the available columns in table 'cargue_masivo':
 * @property integer $id
 * @property string $codigo_barras
 * @property string $asunto
 * @property string $renta
 * @property string $fecha_cargue
 * @property string $usuario_cargue
 * @property boolean $recepcionado
 * @property string $fecha_radicacion
 * @property string $na
 *
 * The followings are the available model relations:
 * @property Usuario $usuarioCargue
 */
class CargueMasivo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cargue_masivo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo_barras, asunto, fecha_radicacion, usuario_cargue', 'required'),
            array('renta, recepcionado, na', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, codigo_barras, asunto, fecha_radicacion, renta, fecha_cargue, usuario_cargue, recepcionado, na', 'safe', 'on'=>'search'),
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
            'usuarioCargue' => array(self::BELONGS_TO, 'Usuario', 'usuario_cargue'),
        );
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'codigo_barras' => 'Codigo Barras',
            'asunto' => 'Asunto',
            'fecha_radicacion' => 'Fecha Radicacion',
            'renta' => 'Renta',
            'fecha_cargue' => 'Fecha Cargue',
            'usuario_cargue' => 'Usuario Cargue',
            'recepcionado' => 'Recepcionado',
            'na' => 'Na',
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
        $criteria->compare('UPPER(codigo_barras)',strtoupper($this->codigo_barras),true);
        $criteria->compare('UPPER(asunto)',strtoupper($this->asunto),true);
        $criteria->compare('renta',$this->renta,true);
        $criteria->compare('recepcionado',0);
        $criteria->with = array('usuarioCargue');
        //$criteria->compare('fecha_radicacion',$this->fecha_radicacion,true);
        //$criteria->compare('fecha_cargue',$this->fecha_cargue,true);
        //$criteria->compare('usuario_cargue',$this->usuario_cargue,true);

        if(!empty($this->usuario_cargue)){
			$criteria->addCondition(array('"usuarioCargue"."nombres" ilike \'%'.$this->usuario_cargue.'%\' OR "usuarioCargue"."apellidos" ilike \'%'.$this->usuario_cargue.'%\''));
		}
		if(!empty($this->fecha_radicacion)){
			$criteria->addCondition("fecha_radicacion in (select fecha_radicacion from cargue_masivo where fecha_radicacion::date = TO_DATE('".$this->fecha_radicacion."', 'DD/MM/YYYY'))"); 
		}
		if(!empty($this->fecha_cargue)){
			$criteria->addCondition("fecha_cargue in (select fecha_cargue from cargue_masivo where fecha_cargue::date = TO_DATE('".$this->fecha_cargue."', 'DD/MM/YYYY'))"); 
		}
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CargueMasivo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function imagen($codigo_barras)
	{
		$carpeta = "/vol2/img04/mti_pdf/";
		if(is_dir($carpeta)){
			if($dir = opendir($carpeta)){
				while(($archivo = readdir($dir)) !== false){
					if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
						$nombre = explode(".", $archivo);
						$nombre = $nombre[0];
						if(strtoupper($nombre) == strtoupper($codigo_barras)){
							return CHtml::link('<u>Si</u>',"http://".$_SERVER['HTTP_HOST']."/img04/mti_pdf/$archivo", array('data-fancybox'=>'gallery'));
						}
					}
				}
				closedir($dir);
			}
		}
		return "No";
	}
	public static function imagenCodigoBarras($codigo_barras)
	{
		$carpeta = "/vol2/img04/mti_pdf/";
		if(is_dir($carpeta)){
			if($dir = opendir($carpeta)){
				while(($archivo = readdir($dir)) !== false){
					if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
						$nombre = explode(".", $archivo);
						$nombre = $nombre[0];
						if(strtoupper($nombre) == strtoupper($codigo_barras)){
							return CHtml::link('<u>'.$codigo_barras.'</u>',"http://".$_SERVER['HTTP_HOST']."/img04/mti_pdf/$archivo", array('data-fancybox'=>'gallery'));
						}
					}
				}
				closedir($dir);
			}
		}
		return $codigo_barras;
	}
	public static function devuelveNumeros($cadena)
	{
		$cadena = substr($cadena, 0, 30);
		$patron = '/[^0-9]/';
		$numero = preg_replace ($patron, '', $cadena);
		if(!empty($numero)){
		  return $numero; 
		}else{
		  return false;
		}
	}
	public static function direccionWeb($id)
	{
		$id = base64_decode($id);
		$cargue = CargueMasivo::model()->findByPk($id);
		$carpeta = "/vol2/img04/mti_pdf/";
		if(is_dir($carpeta)){
			if($dir = opendir($carpeta)){
				while(($archivo = readdir($dir)) !== false){
					if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
						$nombre = explode(".", $archivo);
						$nombre = $nombre[0];
						if(strtoupper($nombre) == strtoupper($cargue->codigo_barras)){
							return "http://".$_SERVER['HTTP_HOST']."/img04/mti_pdf/$archivo";
						}
					}
				}
				closedir($dir);
			}
		}
		return false;
	}
	public static function asunto($id)
	{
		$cargue = CargueMasivo::model()->findByPk($id);
		$asunto = substr($cargue->asunto, 0, 25)." ...";
		return '<address title="'.$cargue->asunto.'">'.$asunto.'</address>';
	}
	public static function nombresUsuario($nombres, $apellidos)
	{
		$ver = $nombres." ...";
		$nombre_completo = $nombres." ".$apellidos;
		return '<address title="'.$nombre_completo.'">'.$ver.'</address>';
	}
	public static function getPath($codigo_barras)
	{
		$carpeta = "/vol2/img04/mti_pdf/";
		if(is_dir($carpeta)){
			if($dir = opendir($carpeta)){
				while(($archivo = readdir($dir)) !== false){
					if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
						$nombre = explode(".", $archivo);
						$nombre = $nombre[0];
						if(strtoupper($nombre) == strtoupper($codigo_barras)){
							return $carpeta.$archivo;
						}
					}
				}
				closedir($dir);
			}
		}
	}
	public static function nuevoCargue()
	{
		$consulta = CargueMasivo::model()->findAllByAttributes(array("recepcionado"=>false));
		foreach ($consulta as $value) {
			$rpta = CargueMasivo::imagen($value->codigo_barras);
			if($rpta != "No"){
				return $value->id;
			}
		}
		return false;
	}
}
