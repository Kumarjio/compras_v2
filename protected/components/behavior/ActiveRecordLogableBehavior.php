<?php

/**
 * Description of ActiveRecordLogableBehavior
 *
 * @author nfrojas
 */
class ActiveRecordLogableBehavior extends CActiveRecordBehavior {

    private $_oldattributes = array();

    public function afterSave($event) {
			if (!$this->Owner->isNewRecord) {
			    $newattributes = $this->Owner->getAttributes();
			    $oldattributes = $this->getOldAttributes();

			    foreach ($newattributes as $name => $value) {
						$old = (!empty($oldattributes)) ? $oldattributes[$name] : '';

						$model = $this->Owner;
						$cuantos = TrazabilidadWfs::model()->count("estado_nuevo != :e", array(':e' => 'swOrden/llenaroc'));

						if($cuantos != 0){
							if ($name != "paso_wf" && $name != "usuario_actual"){
								if ($value != $old) {
						    
							    $log = new ActiveRecordLog;
							    $log->action = 'UPDATE';
							    $log->model = get_class($this->Owner);
							    $log->idmodel = $this->Owner->getPrimaryKey();
							    $log->field = $name;
							    //$log->iduser = Yii::app()->user->id;
							    $log->username = Yii::app()->user->name;
							    $log->description = $old;
							    $log->description_new = $value;
							    $log->save();

								}
							}
						}

						
			    }
			} else {
			    $log = new ActiveRecordLog;
			    $log->action = 'CREATE';
			    $log->model = get_class($this->Owner);
			    $log->idmodel = $this->Owner->getPrimaryKey();
			    
			    $log->username = Yii::app()->user->name;

			    $description = array();
			    $headerfields = array();
			    $newattributes = $this->Owner->getAttributes();
			    
			    foreach ($newattributes as $field => $value) {
						$headerfields[] = '"' . $field . '"';
						$description[] = '"' . $value . '"';
			    }
			    
			    $log->description = implode(";", $headerfields) . "\r\n" . implode(";", $description);
			    $log->save();
			}
    }

    public function afterDelete($event) {
			$log = new ActiveRecordLog;
			$log->action = 'DELETE';
			$log->model = get_class($this->Owner);
			$log->idmodel = $this->Owner->getPrimaryKey();
			//$log->field = '';
			//$log->iduser = Yii::app()->user->id;
			$log->username = Yii::app()->user->name;

			$description = array();
			$headerfields = array();
			$newattributes = $this->Owner->getAttributes();
			foreach ($newattributes as $field => $value) {
			    $headerfields[] = '"' . $field . '"';
			    $description[] = '"' . $value . '"';
			}
			$log->description = implode(";", $headerfields) . "\r\n" . implode(";", $description);
			$log->save();
    }

    public function afterFind($event) {
			$this->setOldAttributes($this->Owner->getAttributes());
		}

    
    public function getOldAttributes() {
			return $this->_oldattributes;
    }

    public function setOldAttributes($value) {
			$this->_oldattributes = $value;
    }

}

?>
