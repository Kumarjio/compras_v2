<?php
/**
 * This is the model class for table "adjuntos_recepcion".
 *
 * The followings are the available columns in table 'adjuntos_recepcion':
 * @property integer $id
 * @property string $na
 * @property string $path
 * @property boolean $activo
 *
 * The followings are the available model relations:
 * @property Recepcion $na0
 */
class AdjuntosRecepcion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $archivo;
	public function tableName()
	{
		return 'adjuntos_recepcion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.

		return array(
			array('na, path', 'required'),
			//array('archivo', 'file', 'types'=>'jpg, gif, png, pdf, xls, csv, msg, tif', 'safe' => false),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('archivo', 'safe'),
			array('id, na, path, activo, archivo', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'na' => 'Na',
			'path' => 'Archivo',
			'activo' => 'Activo',
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
        $criteria->compare('na',$this->na);
        $criteria->compare('path',$this->path,true);
        $criteria->compare('activo',1);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdjuntosRecepcion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function extensionAdjunto($path){
		$imagen = dirname(__FILE__).'/../images/';
		$path2 = str_replace("http://correspondencia.imaginex/", "/vol2/", $path); 
		$nombre = basename($path);
		$ext= substr($nombre,stripos($nombre, '.')+1);
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
			//return CHtml::link('<img src="/images/imagen.jpg" width="26px" height="26px">',array('trazabilidad/visorImagenesTif','path'=>$path));
			return CHtml::link('<img src="/images/imagen.jpg" width="26px" height="26px">',$path, array('class'=>'imagenTiff','id'=>basename($path)));

		}else{
			return CHtml::link('<img src="/images/document.png" width="30px" height="30px">',array('trazabilidad/download','path'=>$path));
		}
	}
}
