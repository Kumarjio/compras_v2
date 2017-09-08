<?php

/**
 * Description of ActiveRecordLogableBehavior
 *
 * @author soquendo
 */
class WorkflowTrazabilidadCita extends CActiveRecordBehavior {

    private $_oldattributes = array();

    public function afterSave($event) {

            $newattributes = $this->Owner->getAttributes();
            $oldattributes = $this->getOldAttributes();

            if (!$this->Owner->isNewRecord) {
                                          
              $log = new Trazabilidad;

//              $log->model = get_class($this->Owner);
              $log->id_cita= $this->Owner->getPrimaryKey();
              $log->usuario_anterior = $oldattributes['id_usuario'];
              $log->usuario_actual = $newattributes['id_usuario'];

              if(empty($oldattributes['paso_wf']))
                $log->estado_anterior = "swCita/preagendado";
              else
                $log->estado_anterior = $oldattributes['paso_wf'];

              $log->estado_actual = $newattributes['paso_wf']; 
              if($oldattributes['paso_wf'] != $newattributes['paso_wf']){
                $log->save();
              }       

            }else{
                $log = new Trazabilidad;

//                $log->model = get_class($this->Owner);
                $log->id_cita = $this->Owner->getPrimaryKey();
                $log->usuario_actual = $newattributes['id_usuario'];
                $log->estado_actual = $newattributes['paso_wf'];
                $log->save();
        
            }       
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
