<?php

/**
 * Description of ActiveRecordLogableBehavior
 *
 * @author soquendo
 */
class WorkflowObservaciones extends CActiveRecordBehavior {

    private $_oldattributes = array();

    public function afterSave($event) {
        $newattributes = $this->Owner->getAttributes();
        $oldattributes = $this->getOldAttributes();

        if(isset($this->Owner->observacion) && !empty($this->Owner->observacion)){
//            if (!$this->Owner->isNewRecord) {                
                  
              $log = new Observacioneswfs;

              $log->model = get_class($this->Owner);
              $log->idmodel = $this->Owner->getPrimaryKey();
              $log->usuario = $newattributes['id_usuario'];

              if(empty($oldattributes['paso_wf']))
                $log->estado_anterior = "swCita/preagendado";
              else
                $log->estado_anterior = $oldattributes['paso_wf'];

              $log->estado_nuevo = $newattributes['paso_wf'];
              $log->observacion = $this->Owner->observacion;
              $log->save(); 
//            }
        }       
        return true;
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
