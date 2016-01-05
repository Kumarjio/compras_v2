<?php

$table_style = "border-width: 1px;border-spacing: 2px;border-style: outset;border-color: gray;border-collapse: collapse;background-color: white;";
$td_style = "border-width: 1px;padding: 3px;border-style: dotted;border-color: gray;background-color: white;";

?>
<table style="<?php echo $table_style; ?>">
  <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo Documentos::model()->getAttributeLabel("id_documento"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Documentos::model()->getAttributeLabel("nombre_documento"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Documentos::model()->getAttributeLabel("estado"); ?></td>
  </tr>
  
    <?php foreach($model as $m): ?>

    <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo $m->id_documento; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->nombre_documento; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->estado; ?></td>
	</tr>
	<?php endforeach; ?>

</table>


