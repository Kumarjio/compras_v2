<div id="producto-rechazado-<?php echo $po->orden_solicitud; ?>" style="position:absolute; width:100%; height:100%; background:#CCC url('/images/rechazado.png') repeat-y center top; opacity:0.5; filter:alpha(opacity=50); -ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=50)'; -moz-opacity:0.5; -khtml-opacity: 0.5; top:-9px; padding-bottom:9px;"> 
</div>
<?php
   $emp = Empleados::model()->findByPk($po->usuario_rechazo);
if($emp){
  echo "<div style='position:absolute; top:0px; left:0px; margin:20px; background-color:#EEE; border:#666 solid 3px; padding:10px;'>";
  echo "<p><b>Rechazado por: </b>".$emp->nombre_completo."</p>";
  echo "<p><b>Fecha y Hora: </b>".$po->fecha_rechazo."</p>";
  echo "<p><b>Razón: </b>".$po->razon_rechazo."</p>";
  echo "</div>";
}
?>