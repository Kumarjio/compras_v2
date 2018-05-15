<?php

/**
 * Description of ActiveRecordLogableBehavior
 *
 * @author soquendo
 */
class WorkflowTrazabilidad extends CActiveRecordBehavior {

    private $_oldattributes = array();

    public function afterSave($event) {
        $newattributes = $this->Owner->getAttributes();
        $oldattributes = $this->getOldAttributes();

        if (!$this->Owner->isNewRecord) {
                    
                
          $log = new TrazabilidadWfs;

          $log->model = get_class($this->Owner);
          $log->idmodel = $this->Owner->getPrimaryKey();
          $log->usuario_anterior = $oldattributes['usuario_actual'];
          $log->usuario_nuevo = $newattributes['usuario_actual'];
          $log->estado_anterior = $oldattributes['paso_wf'];
          $log->estado_nuevo = $newattributes['paso_wf']; 
	  if($oldattributes['paso_wf'] != $newattributes['paso_wf']){
	    $log->save();
	  }
          

        }else{
          if($newattributes['paso_wf'] != "swOrden/dummy"){
	    $log = new TrazabilidadWfs;

	    $log->model = get_class($this->Owner);
	    $log->idmodel = $this->Owner->getPrimaryKey();
	    $log->usuario_nuevo = $newattributes['usuario_actual'];
	    $log->estado_nuevo = $newattributes['paso_wf'];
	    $log->save();
	  }
	  
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
