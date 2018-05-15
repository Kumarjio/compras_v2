<?php
echo "<div>Bogot&aacute;, 21 de Octubre del 2017</div><div>&nbsp;</div><div>&nbsp;</div><div><strong>Se&ntilde;or</strong></div><div><strong>Jose Luis Gonzalez Salamanca&nbsp;</strong></div><div><strong>Calle 6b 79c - 90 Interior 1 Apto 101 Conjunto Prados De Techo 1 Barrio Piodoce Castilla&nbsp;</strong></div><div><strong>Tel&eacute;fono: 3134718606&nbsp;</strong></div><div><strong>Bogota, D.c., Bogota</strong></div><div>&nbsp;</div><em><div><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Asunto: CALIFICACI&Oacute;N DE ORIGEN</strong></div><div>&nbsp;</div><div>&nbsp;</div><div>Reciba usted un cordial saludo de Seguros de Vida Alfa S.A.</div><div>&nbsp;</div><div>De la manera m&aacute;s atenta queremos informar el resultado de la calificaci&oacute;n realizada por el Grupo</div><div>Interdisciplinario de Calificaci&oacute;n de Origen y P&eacute;rdida de la Capacidad Laboral adscrito&nbsp; a la</div><div>Administradora&nbsp; de Riesgos Laborales de Seguros de Vida Alfa S.A, seg&uacute;n lo dispuesto en los Art&iacute;culo</div><div>142 del Decreto 0019 de 2012, ha&nbsp; determinado que el&nbsp; evento reportado ante&nbsp; esta Administradora,&nbsp;</div><div>con la patolog&iacute;a <strong>&ldquo;Fractura De La Epifisis Inferior Del Radio Izquierdo Y Herida En Cuero Cabelludo&rdquo;</strong>,&nbsp;</div><div>fue calificado como <strong>Accidente de origen Com&uacute;n.</strong></div><div>&nbsp;</div><div>El dictamen de calificaci&oacute;n del que anexo copia, puede ser apelado ante esta Administradora, dentro</div><div>de los (10) diez d&iacute;as siguientes a partir de su notificaci&oacute;n, de acuerdo al Decreto 0019&nbsp; de 2012</div><div>art&iacute;culo 142, en la Avenida calle 26 No. 59-15 local 6 y 7. Favor informar en la carta el motivo de</div><div>su desacuerdo y en el asunto manifestar que es una inconformidad al dictamen.</div><div>&nbsp;</div><div>Cualquier informaci&oacute;n adicional con gusto ser&aacute; atendida por la Auditora T&eacute;cnica del Departamento</div><div>de Servicios e Indemnizaciones en el tel&eacute;fono 7435333 Ext. 14606 en Bogot&aacute;.</div><div>&nbsp;</div></em><div>Cordialmente,</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div><strong>CLAUDIA PATRICIA VARGAS YAVER</strong></div><div>Direcci&oacute;n&nbsp; de Servicios e Indemnizaciones</div><div>&nbsp;</div><div>c.c.&nbsp; &nbsp; &nbsp; &nbsp;<strong>Empresa:</strong>&nbsp; &nbsp; &nbsp; Ajover  Sas &ndash; Departamento de Recursos Humanos&nbsp;&nbsp;</div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Calle  65  Bis  91-82 Tel&eacute;fono: 5949999 Ciudad: Bogota, D.c.</div><div>&nbsp; &nbsp; &nbsp; &nbsp;<strong>&nbsp; &nbsp; &nbsp; EPS:</strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Nueva Eps - Departamento de Medicina Laboral</div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Carrera 85 K No. 46 A - 66Tel&eacute;fono: 3077022 Ciudad: Bogota, D.c.</div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<strong>AFP:</strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Porvenir&nbsp; - Departamento de Medicina Laboral</div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Carrera 13 No. 26a - 65 Tel&eacute;fono: 3393000 Ciudad: Bogota, D.c.</div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<strong>Siniestro:</strong>&nbsp; &nbsp; &nbsp;Fractura De La Epifisis Inferior Del Radio Izquierdo Y Herida En Cuero Cabelludo</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>Elaboro: Danilo Ramirez Osorio</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><small><div>&ldquo;Finalmente, reiteramos que en nuestra Compa&ntilde;&iacute;a contamos con la mejor disposici&oacute;n para atender sus quejas y reclamos a trav&eacute;s</div><div>del defensor consumidor financiero, en la Av. Calle 26 No 59-15, local 6 y 7. Conmutador: 7435333 Extensi&oacute;n: 14454, Fax Ext. 14456</div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;o Correo Electr&oacute;nico: defensordelconsumidorfinanciero@segurosdevidaalfa.com.co&rdquo;.</div></small>";
die;

$destinatario = array(
    'principal'=>true, 
    'empresa'=>false,
    'eps'=>false,
    'afp'=>false,
);
//print_r($destinatario);
if($destinatario['principal']){
  echo "Hola mundo";
}

die;
$telefonos = "3577221 - 3164216413";
$telefonos = explode("-", $telefonos);
  foreach ($telefonos as $telefono) {
    $telefono = trim($telefono);
    if(is_numeric($telefono)){
      $cantidad = strlen($telefono);
      if($cantidad == "7" || $cantidad == "10"){
        echo $telefono."\n";
      }
    }
  }
die;
?>
<button class="btn btn-default source" onclick="new PNotify({
              title: 'Danilo Ramirez',
              text: 'Hola mundo',
              type: 'success',
              styling: 'bootstrap3'
          });">Success</button>
<script type="text/javascript">
function notifyMe() {
  var imagen = "http://"+window.location.host+"/images/alfa.png";
  if (!("Notification" in window)) {
  	spawnNotification("Hola mundo 2", imagen, "<?php echo Usuario::model()->nombres(Yii::app()->user->usuario);?>");
  }else if (Notification.permission === "granted") {
    spawnNotification("Hola mundo 2", imagen, "<?php echo Usuario::model()->nombres(Yii::app()->user->usuario);?>");
  }else if (Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {
      if (permission === "granted") {
        spawnNotification("Hola mundo 2", imagen, "<?php echo Usuario::model()->nombres(Yii::app()->user->usuario);?>");
      }
    });
  }
}
$("#holamundo").click(function(){
	var imagen = "http://"+window.location.host+"/images/alfa.png";
	var name = "<?php echo Usuario::model()->nombres(Yii::app()->user->usuario);?>";
    <?php echo CHtml::ajax(
	    array(
          'type' => 'POST',
          'url' => $this->createUrl("usuario/casosTutela"),
 		  'dataType'=>'json',
          'success' => 'function(data){
                if(data.status == "success"){
                    data.notificacion.forEach(function(valor, indice, arreglo){
                    	spawnNotification(valor, imagen, name);
                    });
                }
          }'
	    )
    );?> 
});
</script>
    <table border cellpadding=10 cellspacing=0 width="100%" height="100px">
       <tr style="color:#04B486;" align="center">
         <td><strong>Caso.</strong></td>
         <td><strong>Fecha de Asignación.</strong></td>
         <td><strong>Actividad</strong></td>
       </tr>
       <tr align="center">
         <td>Hola mundo</td>
         <td>Hola mundo</td>
         <td>Hola mundo</td>  
       </tr>
       <tr align="center">
       	<td style="color:#04B486;" colspan="2"><strong>Total Casos:</strong></td>
       	<td><b>14</b></td>
       </tr>
	</table>
  <br>
  <br>
  <br>
  <br>
  <div class="table-responsive">
     <table class="table table-bordered">
       <tr class="active">
         <td><strong>Negocio</strong></td>
         <td><strong>Tipificación</strong></td>
         <td><strong>Grupo</strong></td>
         <td><strong>Tipología</strong></td>
       </tr>
       <tr >
         <td>Hola mundo</td>
         <td>Hola mundo</td>
         <td>Hola mundo</td>
         <td>Hola mundo</td>  
       </tr>
</table>
</div>