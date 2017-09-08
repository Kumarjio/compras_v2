<?php

/**
 * This is the model class for table "cartas_mail".
 *
 * The followings are the available columns in table 'cartas_mail':
 * @property string $id
 * @property string $id_cartas
 * @property string $mail
 *
 * The followings are the available model relations:
 * @property Cartas $idCartas
 */
class CartasMail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cartas_mail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mail', 'required'),
			array('mail', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_cartas, mail', 'safe', 'on'=>'search'),
			array('mail','email'),
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
			'idCartas' => array(self::BELONGS_TO, 'Cartas', 'id_cartas'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_cartas' => 'Id Cartas',
			'mail' => 'Mail',
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
		$criteria->compare('id_cartas',$this->id_cartas,true);
		$criteria->compare('mail',$this->mail,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CartasMail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function validaMail($mail)
	{
		if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    		return true;
		}else{
			return false;
		}
		
	}
	public static function guardaMail($mail,$id_cartas)
	{
		$model = new CartasMail;
		$model->id_cartas = $id_cartas;
		$model->mail = $mail;
		if($model->save()){
			return true;
		}else{
			return false;
		}
	}
	public static function envioCartasMail($id,$body,$proveedor,$na)
	{	
		$img = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <img src="cid:bolivar_png" style="width:125px" /></p>';
		$mail = CartasMail::model()->findByAttributes(array("id_cartas"=>$id));
		$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
		$mailer->Host = $_SERVER['HTTP_HOST'];
		$mailer->IsSMTP();
		$mailer->From = 'daniloramirez0818@gmail.com';
		if($proveedor == "1"){
			//$mailer->AddReplyTo('wei@example.com');
		}
		$mailer->AddAddress($mail->mail);
		$mailer->FromName = 'Seguros Bolivar';
		$mailer->CharSet = 'UTF-8';
		$mailer->Subject = 'Respuesta caso: [CASO - '.$na.']';
		$mailer->AddEmbeddedImage('/correspondencia/images/bolivar.png', "my-attach", 'bolivar_png');
		$mailer->MsgHTML($body);
		$mailer->Send();
		return true;
	}
}
?>
