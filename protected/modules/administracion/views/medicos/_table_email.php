<?php

$table_style = "border-width: 1px;border-spacing: 2px;border-style: outset;border-color: gray;border-collapse: collapse;background-color: white;";
$td_style = "border-width: 1px;padding: 3px;border-style: dotted;border-color: gray;background-color: white;";

?>
<table style="<?php echo $table_style; ?>">
  <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("id_medico"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("cedula"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("primer_nombre"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("segundo_nombre"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("primer_apellido"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("segundo_apellido"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("direccion"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("telefono_fijo"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("ciudad"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("celular"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("correo"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("tarjeta_profesional"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("nro_cuenta_bancaria"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("entidad_bancaria"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Medicos::model()->getAttributeLabel("estado"); ?></td>
  </tr>
  
    <?php foreach($model as $m): ?>

    <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo $m->id_medico; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->cedula; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->primer_nombre; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->segundo_nombre; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->primer_apellido; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->segundo_apellido; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->direccion; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->telefono_fijo; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->ciudad; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->celular; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->correo; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->tarjeta_profesional; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->nro_cuenta_bancaria; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->entidad_bancaria; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->estado; ?></td>
	</tr>
	<?php endforeach; ?>

</table>


