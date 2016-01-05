<?php

$table_style = "border-width: 1px;border-spacing: 2px;border-style: outset;border-color: gray;border-collapse: collapse;background-color: white;";
$td_style = "border-width: 1px;padding: 3px;border-style: dotted;border-color: gray;background-color: white;";

?>
<table style="<?php echo $table_style; ?>">
  <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo Disponibilidad::model()->getAttributeLabel("id_disponibilidad"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Disponibilidad::model()->getAttributeLabel("fecha"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Disponibilidad::model()->getAttributeLabel("inicio"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Disponibilidad::model()->getAttributeLabel("fin"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Disponibilidad::model()->getAttributeLabel("id_recurso"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Disponibilidad::model()->getAttributeLabel("estado"); ?></td>
  </tr>
  
    <?php foreach($model as $m): ?>

    <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo $m->id_disponibilidad; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->fecha; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->inicio; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->fin; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_recurso; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->estado; ?></td>
	</tr>
	<?php endforeach; ?>

</table>


