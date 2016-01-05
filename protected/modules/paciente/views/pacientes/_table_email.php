<?php

$table_style = "border-width: 1px;border-spacing: 2px;border-style: outset;border-color: gray;border-collapse: collapse;background-color: white;";
$td_style = "border-width: 1px;padding: 3px;border-style: dotted;border-color: gray;background-color: white;";

?>
<table style="<?php echo $table_style; ?>">
  <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_paciente"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("cedula"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("primer_nombre"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("segundo_nombre"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("primer_apellido"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("segundo_apellido"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("sexo"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("fecha_nacimiento"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_estado_civil"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_ciudad"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("barrio"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("direccion"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("telefono"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("celular"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("correo"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_grupo_poblacion"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_clasificacion"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_grupo_etnico"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_categoria"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_tipo_afiliado"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_eps"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_ocupacion"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_nivel_educativo"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("nombre_acompanante"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("cc_acompanante"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_ciudad_acompanante"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("telefono_acompanante"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("id_parentezco"); ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo Pacientes::model()->getAttributeLabel("fecha_ingreso"); ?></td>
  </tr>
  
    <?php foreach($model as $m): ?>

    <tr>
	 <td style="<?php echo $td_style; ?>"><?php echo $m->id_paciente; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->cedula; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->primer_nombre; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->segundo_nombre; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->primer_apellido; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->segundo_apellido; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->sexo; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->fecha_nacimiento; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_estado_civil; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_ciudad; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->barrio; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->direccion; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->telefono; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->celular; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->correo; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_grupo_poblacion; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_clasificacion; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_grupo_etnico; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_categoria; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_tipo_afiliado; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_eps; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_ocupacion; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_nivel_educativo; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->nombre_acompanante; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->cc_acompanante; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_ciudad_acompanante; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->telefono_acompanante; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->id_parentezco; ?></td>
 <td style="<?php echo $td_style; ?>"><?php echo $m->fecha_ingreso; ?></td>
	</tr>
	<?php endforeach; ?>

</table>


