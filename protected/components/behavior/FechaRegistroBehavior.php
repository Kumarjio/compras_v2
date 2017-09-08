<?php 

class FechaRegistroBehavior extends CActiveRecordBehavior {
  
  public function beforeSave($event){
    date_default_timezone_set("America/Bogota");
    $owner = $this->getOwner();
    $now = date("Y-m-d H:i:s");
    if($owner->isNewRecord){
      $owner->creacion = $now;
      $owner->actualizacion = $now;
    }else{
      $owner->actualizacion = $now;
    }

    return true;
  }
 
}

?>