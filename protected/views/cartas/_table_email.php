<?php

$table_style = "border-width: 1px;border-spacing: 2px;border-style: outset;border-color: gray;border-collapse: collapse;background-color: white;";
$td_style = "border-width: 1px;padding: 3px;border-style: dotted;border-color: gray;background-color: white;";

?>
<table style="<?php echo $table_style; ?>">
  <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("id"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("na"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("id_trazabilidad"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("id_plantilla"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("mensaje"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("carta"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("nombre_destinatario"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("id_tipo_entrega"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("id_proveedor"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("punteo"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("impreso"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("principal"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("id_firma"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("direccion"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("id_ciudad"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("correo"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("telefono"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("fecha_respuesta"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cartas::model()->getAttributeLabel("usuario_respuesta"); ?></td>
  </tr>
  
    <?php foreach($model as $m): ?>

    <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo $m->id; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->na; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_trazabilidad; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_plantilla; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->mensaje; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->carta; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->nombre_destinatario; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_tipo_entrega; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_proveedor; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->punteo; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->impreso; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->principal; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_firma; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->direccion; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_ciudad; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->correo; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->telefono; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->fecha_respuesta; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->usuario_respuesta; ?></td>
	</tr>
	<?php endforeach; ?>

</table>


