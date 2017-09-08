<?php

/**
 * This is the model class for table "R_PAC_EPS".
 *
 * The followings are the available columns in table 'R_PAC_EPS':
 * @property string $NU_HIST_PAC_RPE
 * @property string $CD_NIT_EPS_RPE
 * @property string $CD_CODI_REG_RPE
 * @property string $CD_CARN_RPE
 * @property integer $NU_AFIL_RPE
 * @property integer $NU_ESTA_RPE
 * @property string $TX_ACTI_RPE
 *
 * The followings are the available model relations:
 * @property PACIENTES $nUHISTPACRPE
 */
class PacienteEpsSandiego extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'R_PAC_EPS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NU_HIST_PAC_RPE, CD_NIT_EPS_RPE, CD_CODI_REG_RPE, NU_ESTA_RPE', 'required'),
			array('NU_AFIL_RPE, NU_ESTA_RPE', 'numerical', 'integerOnly'=>true),
			array('NU_HIST_PAC_RPE', 'length', 'max'=>20),
			array('CD_NIT_EPS_RPE', 'length', 'max'=>11),
			array('CD_CODI_REG_RPE', 'length', 'max'=>2),
			array('CD_CARN_RPE', 'length', 'max'=>18),
			array('TX_ACTI_RPE', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('NU_HIST_PAC_RPE, CD_NIT_EPS_RPE, CD_CODI_REG_RPE, CD_CARN_RPE, NU_AFIL_RPE, NU_ESTA_RPE, TX_ACTI_RPE', 'safe', 'on'=>'search'),
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
			'nUHISTPACRPE' => array(self::BELONGS_TO, 'PACIENTES', 'NU_HIST_PAC_RPE'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'NU_HIST_PAC_RPE' => 'Nu Hist Pac Rpe',
			'CD_NIT_EPS_RPE' => 'Cd Nit Eps Rpe',
			'CD_CODI_REG_RPE' => 'Cd Codi Reg Rpe',
			'CD_CARN_RPE' => 'Cd Carn Rpe',
			'NU_AFIL_RPE' => 'Nu Afil Rpe',
			'NU_ESTA_RPE' => 'Nu Esta Rpe',
			'TX_ACTI_RPE' => 'Tx Acti Rpe',
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

		$criteria->compare('NU_HIST_PAC_RPE',$this->NU_HIST_PAC_RPE,true);
		$criteria->compare('CD_NIT_EPS_RPE',$this->CD_NIT_EPS_RPE,true);
		$criteria->compare('CD_CODI_REG_RPE',$this->CD_CODI_REG_RPE,true);
		$criteria->compare('CD_CARN_RPE',$this->CD_CARN_RPE,true);
		$criteria->compare('NU_AFIL_RPE',$this->NU_AFIL_RPE);
		$criteria->compare('NU_ESTA_RPE',$this->NU_ESTA_RPE);
		$criteria->compare('TX_ACTI_RPE',$this->TX_ACTI_RPE,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->dbSandiego;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PacienteEpsSandiego the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
