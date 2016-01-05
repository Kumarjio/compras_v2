<?php

$table_style = "border-width: 1px;border-spacing: 2px;border-style: outset;border-color: gray;border-collapse: collapse;background-color: white;";
$td_style = "border-width: 1px;padding: 3px;border-style: dotted;border-color: gray;background-color: white;";

?>
<table style="<?php echo $table_style; ?>">
  <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo Cita::model()->getAttributeLabel("id_cita"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cita::model()->getAttributeLabel("id_paciente"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Cita::model()->getAttributeLabel("id_disponibilidad"); ?></td>
  </tr>
  
    <?php foreach($model as $m): ?>

    <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo $m->id_cita; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_paciente; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_disponibilidad; ?></td>
	</tr>
	<?php endforeach; ?>

</table>


