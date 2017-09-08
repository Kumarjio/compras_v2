<?php

/**
 * This is the model class for table "PACIENTES".
 *
 * The followings are the available columns in table 'PACIENTES':
 * @property string $NU_DOCU_PAC
 * @property string $NU_HIST_PAC
 * @property integer $NU_TIPD_PAC
 * @property string $DE_PRAP_PAC
 * @property string $DE_SGAP_PAC
 * @property string $NO_NOMB_PAC
 * @property string $NO_SGNO_PAC
 * @property string $FE_NACI_PAC
 * @property string $CD_CODI_DPTO_PAC
 * @property string $CD_CODI_MUNI_PAC
 * @property string $DE_DIRE_PAC
 * @property string $DE_TELE_PAC
 * @property integer $NU_SEXO_PAC
 * @property integer $NU_ESCI_PAC
 * @property string $FE_HIST_PAC
 * @property string $NU_SITU_PAC
 * @property string $CD_CODI_CAM_PAC
 * @property integer $NU_NUME_REG_PAC
 * @property integer $NU_NIVE_PAC
 * @property integer $NU_ESTA_PAC
 * @property string $CD_CODI_ZORE_PAC
 * @property string $CD_CODI_LUAT_PAC
 * @property string $DE_EMAIL_PAC
 * @property string $CD_CODI_OCUP_PAC
 * @property integer $NU_CONS_HIST_PAC
 * @property integer $NU_TIPO_PAC
 * @property string $CD_CODI_RELI_PAC
 * @property string $CD_CODI_BAR_PAC
 * @property string $DE_NOMB_ACOM_PAC
 * @property string $DE_DIRE_ACOM_PAC
 * @property string $DE_TELE_ACOM_PAC
 * @property string $NU_LUGN_PAC
 * @property string $CD_CODI_PARE_PAC
 * @property string $TX_CODI_CLPA_PAC
 * @property string $TX_DOCU_ACOM_PAC
 * @property string $TX_PRNO_ACOM_PAC
 * @property string $TX_SGNO_ACOM_PAC
 * @property string $TX_PRAP_ACOM_PAC
 * @property string $TX_SGAP_ACOM_PAC
 * @property integer $NU_TIPD_ACOM_PAC
 * @property string $CD_CODPTO_ACOM_PAC
 * @property string $CD_COMUNI_ACOM_PAC
 * @property string $TX_CODI_NIED_PAC
 * @property string $NU_IPSPRIMARIA_PAC
 * @property integer $CD_CODI_GPOB_PAC
 * @property integer $CD_CODI_GETN_PAC
 *
 * The followings are the available model relations:
 * @property Pacientes_Sandiego $nUSITUPAC
 * @property Pacientes_Sandiego[] $pACIENTESs
 */
class Pacientes_Sandiego extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'PACIENTES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NU_DOCU_PAC, NU_HIST_PAC, NO_NOMB_PAC, FE_NACI_PAC, FE_HIST_PAC', 'required'),
			array('NU_TIPD_PAC, NU_SEXO_PAC, NU_ESCI_PAC, NU_NUME_REG_PAC, NU_NIVE_PAC, NU_ESTA_PAC, NU_CONS_HIST_PAC, NU_TIPO_PAC, NU_TIPD_ACOM_PAC, CD_CODI_GPOB_PAC, CD_CODI_GETN_PAC', 'numerical', 'integerOnly'=>true),
			array('NU_DOCU_PAC, NU_HIST_PAC, NO_NOMB_PAC, NO_SGNO_PAC, NU_SITU_PAC, TX_DOCU_ACOM_PAC, TX_PRNO_ACOM_PAC, TX_SGNO_ACOM_PAC', 'length', 'max'=>20),
			array('DE_PRAP_PAC, DE_SGAP_PAC, NU_LUGN_PAC, TX_PRAP_ACOM_PAC, TX_SGAP_ACOM_PAC', 'length', 'max'=>30),
			array('CD_CODI_DPTO_PAC, CD_CODI_LUAT_PAC, CD_CODI_RELI_PAC, CD_CODI_PARE_PAC, TX_CODI_CLPA_PAC, CD_CODPTO_ACOM_PAC, TX_CODI_NIED_PAC', 'length', 'max'=>2),
			array('CD_CODI_MUNI_PAC, CD_CODI_BAR_PAC, CD_COMUNI_ACOM_PAC', 'length', 'max'=>3),
			array('DE_DIRE_PAC, DE_DIRE_ACOM_PAC', 'length', 'max'=>40),
			array('DE_TELE_PAC, DE_NOMB_ACOM_PAC', 'length', 'max'=>50),
			array('CD_CODI_CAM_PAC', 'length', 'max'=>5),
			array('CD_CODI_ZORE_PAC', 'length', 'max'=>1),
			array('DE_EMAIL_PAC', 'length', 'max'=>100),
			array('CD_CODI_OCUP_PAC', 'length', 'max'=>4),
			array('DE_TELE_ACOM_PAC', 'length', 'max'=>15),
			array('NU_IPSPRIMARIA_PAC', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('NU_DOCU_PAC, NU_HIST_PAC, NU_TIPD_PAC, DE_PRAP_PAC, DE_SGAP_PAC, NO_NOMB_PAC, NO_SGNO_PAC, FE_NACI_PAC, CD_CODI_DPTO_PAC, CD_CODI_MUNI_PAC, DE_DIRE_PAC, DE_TELE_PAC, NU_SEXO_PAC, NU_ESCI_PAC, FE_HIST_PAC, NU_SITU_PAC, CD_CODI_CAM_PAC, NU_NUME_REG_PAC, NU_NIVE_PAC, NU_ESTA_PAC, CD_CODI_ZORE_PAC, CD_CODI_LUAT_PAC, DE_EMAIL_PAC, CD_CODI_OCUP_PAC, NU_CONS_HIST_PAC, NU_TIPO_PAC, CD_CODI_RELI_PAC, CD_CODI_BAR_PAC, DE_NOMB_ACOM_PAC, DE_DIRE_ACOM_PAC, DE_TELE_ACOM_PAC, NU_LUGN_PAC, CD_CODI_PARE_PAC, TX_CODI_CLPA_PAC, TX_DOCU_ACOM_PAC, TX_PRNO_ACOM_PAC, TX_SGNO_ACOM_PAC, TX_PRAP_ACOM_PAC, TX_SGAP_ACOM_PAC, NU_TIPD_ACOM_PAC, CD_CODPTO_ACOM_PAC, CD_COMUNI_ACOM_PAC, TX_CODI_NIED_PAC, NU_IPSPRIMARIA_PAC, CD_CODI_GPOB_PAC, CD_CODI_GETN_PAC', 'safe', 'on'=>'search'),
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
			'nUSITUPAC' => array(self::BELONGS_TO, 'Pacientes_Sandiego', 'NU_SITU_PAC'),
			'pACIENTESs' => array(self::HAS_MANY, 'Pacientes_Sandiego', 'NU_SITU_PAC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'NU_DOCU_PAC' => 'Nu Docu Pac',
			'NU_HIST_PAC' => 'Nu Hist Pac',
			'NU_TIPD_PAC' => 'Nu Tipd Pac',
			'DE_PRAP_PAC' => 'De Prap Pac',
			'DE_SGAP_PAC' => 'De Sgap Pac',
			'NO_NOMB_PAC' => 'No Nomb Pac',
			'NO_SGNO_PAC' => 'No Sgno Pac',
			'FE_NACI_PAC' => 'Fe Naci Pac',
			'CD_CODI_DPTO_PAC' => 'Cd Codi Dpto Pac',
			'CD_CODI_MUNI_PAC' => 'Cd Codi Muni Pac',
			'DE_DIRE_PAC' => 'De Dire Pac',
			'DE_TELE_PAC' => 'De Tele Pac',
			'NU_SEXO_PAC' => 'Nu Sexo Pac',
			'NU_ESCI_PAC' => 'Nu Esci Pac',
			'FE_HIST_PAC' => 'Fe Hist Pac',
			'NU_SITU_PAC' => 'Nu Situ Pac',
			'CD_CODI_CAM_PAC' => 'Cd Codi Cam Pac',
			'NU_NUME_REG_PAC' => 'Nu Nume Reg Pac',
			'NU_NIVE_PAC' => 'Nu Nive Pac',
			'NU_ESTA_PAC' => 'Nu Esta Pac',
			'CD_CODI_ZORE_PAC' => 'Cd Codi Zore Pac',
			'CD_CODI_LUAT_PAC' => 'Cd Codi Luat Pac',
			'DE_EMAIL_PAC' => 'De Email Pac',
			'CD_CODI_OCUP_PAC' => 'Cd Codi Ocup Pac',
			'NU_CONS_HIST_PAC' => 'Nu Cons Hist Pac',
			'NU_TIPO_PAC' => 'Nu Tipo Pac',
			'CD_CODI_RELI_PAC' => 'Cd Codi Reli Pac',
			'CD_CODI_BAR_PAC' => 'Cd Codi Bar Pac',
			'DE_NOMB_ACOM_PAC' => 'De Nomb Acom Pac',
			'DE_DIRE_ACOM_PAC' => 'De Dire Acom Pac',
			'DE_TELE_ACOM_PAC' => 'De Tele Acom Pac',
			'NU_LUGN_PAC' => 'Nu Lugn Pac',
			'CD_CODI_PARE_PAC' => 'Cd Codi Pare Pac',
			'TX_CODI_CLPA_PAC' => 'Tx Codi Clpa Pac',
			'TX_DOCU_ACOM_PAC' => 'Tx Docu Acom Pac',
			'TX_PRNO_ACOM_PAC' => 'Tx Prno Acom Pac',
			'TX_SGNO_ACOM_PAC' => 'Tx Sgno Acom Pac',
			'TX_PRAP_ACOM_PAC' => 'Tx Prap Acom Pac',
			'TX_SGAP_ACOM_PAC' => 'Tx Sgap Acom Pac',
			'NU_TIPD_ACOM_PAC' => 'Nu Tipd Acom Pac',
			'CD_CODPTO_ACOM_PAC' => 'Cd Codpto Acom Pac',
			'CD_COMUNI_ACOM_PAC' => 'Cd Comuni Acom Pac',
			'TX_CODI_NIED_PAC' => 'Tx Codi Nied Pac',
			'NU_IPSPRIMARIA_PAC' => 'Nu Ipsprimaria Pac',
			'CD_CODI_GPOB_PAC' => 'Cd Codi Gpob Pac',
			'CD_CODI_GETN_PAC' => 'Cd Codi Getn Pac',
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

		$criteria->compare('NU_DOCU_PAC',$this->NU_DOCU_PAC,true);
		$criteria->compare('NU_HIST_PAC',$this->NU_HIST_PAC,true);
		$criteria->compare('NU_TIPD_PAC',$this->NU_TIPD_PAC);
		$criteria->compare('DE_PRAP_PAC',$this->DE_PRAP_PAC,true);
		$criteria->compare('DE_SGAP_PAC',$this->DE_SGAP_PAC,true);
		$criteria->compare('NO_NOMB_PAC',$this->NO_NOMB_PAC,true);
		$criteria->compare('NO_SGNO_PAC',$this->NO_SGNO_PAC,true);
		$criteria->compare('FE_NACI_PAC',$this->FE_NACI_PAC,true);
		$criteria->compare('CD_CODI_DPTO_PAC',$this->CD_CODI_DPTO_PAC,true);
		$criteria->compare('CD_CODI_MUNI_PAC',$this->CD_CODI_MUNI_PAC,true);
		$criteria->compare('DE_DIRE_PAC',$this->DE_DIRE_PAC,true);
		$criteria->compare('DE_TELE_PAC',$this->DE_TELE_PAC,true);
		$criteria->compare('NU_SEXO_PAC',$this->NU_SEXO_PAC);
		$criteria->compare('NU_ESCI_PAC',$this->NU_ESCI_PAC);
		$criteria->compare('FE_HIST_PAC',$this->FE_HIST_PAC,true);
		$criteria->compare('NU_SITU_PAC',$this->NU_SITU_PAC,true);
		$criteria->compare('CD_CODI_CAM_PAC',$this->CD_CODI_CAM_PAC,true);
		$criteria->compare('NU_NUME_REG_PAC',$this->NU_NUME_REG_PAC);
		$criteria->compare('NU_NIVE_PAC',$this->NU_NIVE_PAC);
		$criteria->compare('NU_ESTA_PAC',$this->NU_ESTA_PAC);
		$criteria->compare('CD_CODI_ZORE_PAC',$this->CD_CODI_ZORE_PAC,true);
		$criteria->compare('CD_CODI_LUAT_PAC',$this->CD_CODI_LUAT_PAC,true);
		$criteria->compare('DE_EMAIL_PAC',$this->DE_EMAIL_PAC,true);
		$criteria->compare('CD_CODI_OCUP_PAC',$this->CD_CODI_OCUP_PAC,true);
		$criteria->compare('NU_CONS_HIST_PAC',$this->NU_CONS_HIST_PAC);
		$criteria->compare('NU_TIPO_PAC',$this->NU_TIPO_PAC);
		$criteria->compare('CD_CODI_RELI_PAC',$this->CD_CODI_RELI_PAC,true);
		$criteria->compare('CD_CODI_BAR_PAC',$this->CD_CODI_BAR_PAC,true);
		$criteria->compare('DE_NOMB_ACOM_PAC',$this->DE_NOMB_ACOM_PAC,true);
		$criteria->compare('DE_DIRE_ACOM_PAC',$this->DE_DIRE_ACOM_PAC,true);
		$criteria->compare('DE_TELE_ACOM_PAC',$this->DE_TELE_ACOM_PAC,true);
		$criteria->compare('NU_LUGN_PAC',$this->NU_LUGN_PAC,true);
		$criteria->compare('CD_CODI_PARE_PAC',$this->CD_CODI_PARE_PAC,true);
		$criteria->compare('TX_CODI_CLPA_PAC',$this->TX_CODI_CLPA_PAC,true);
		$criteria->compare('TX_DOCU_ACOM_PAC',$this->TX_DOCU_ACOM_PAC,true);
		$criteria->compare('TX_PRNO_ACOM_PAC',$this->TX_PRNO_ACOM_PAC,true);
		$criteria->compare('TX_SGNO_ACOM_PAC',$this->TX_SGNO_ACOM_PAC,true);
		$criteria->compare('TX_PRAP_ACOM_PAC',$this->TX_PRAP_ACOM_PAC,true);
		$criteria->compare('TX_SGAP_ACOM_PAC',$this->TX_SGAP_ACOM_PAC,true);
		$criteria->compare('NU_TIPD_ACOM_PAC',$this->NU_TIPD_ACOM_PAC);
		$criteria->compare('CD_CODPTO_ACOM_PAC',$this->CD_CODPTO_ACOM_PAC,true);
		$criteria->compare('CD_COMUNI_ACOM_PAC',$this->CD_COMUNI_ACOM_PAC,true);
		$criteria->compare('TX_CODI_NIED_PAC',$this->TX_CODI_NIED_PAC,true);
		$criteria->compare('NU_IPSPRIMARIA_PAC',$this->NU_IPSPRIMARIA_PAC,true);
		$criteria->compare('CD_CODI_GPOB_PAC',$this->CD_CODI_GPOB_PAC);
		$criteria->compare('CD_CODI_GETN_PAC',$this->CD_CODI_GETN_PAC);

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
	 * @return Pacientes_Sandiego the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
