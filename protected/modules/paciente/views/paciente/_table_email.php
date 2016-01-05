<?php

$table_style = "border-width: 1px;border-spacing: 2px;border-style: outset;border-color: gray;border-collapse: collapse;background-color: white;";
$td_style = "border-width: 1px;padding: 3px;border-style: dotted;border-color: gray;background-color: white;";

?>
<table style="<?php echo $table_style; ?>">
  <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo Paciente::model()->getAttributeLabel("nombre"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Paciente::model()->getAttributeLabel("cedula"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Paciente::model()->getAttributeLabel("celular"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Paciente::model()->getAttributeLabel("telefono"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Paciente::model()->getAttributeLabel("correo"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Paciente::model()->getAttributeLabel("id_paciente"); ?></td>
  </tr>
  
    <?php foreach($model as $m): ?>

    <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo $m->nombre; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->cedula; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->celular; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->telefono; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->correo; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_paciente; ?></td>
	</tr>
	<?php endforeach; ?>

</table>


