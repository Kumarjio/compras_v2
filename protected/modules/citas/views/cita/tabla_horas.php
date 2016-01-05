<?php

echo CHtml::hiddenField('fecha',$fecha);
?>
   
        <ul class="nav nav-pills"><?php
            foreach ($horas as $hora) { ?>
            <li role="presentation">
            <a href="#"  onclick="return confirmar(<?php echo $hora['id_disponibilidad']?>,'<?php echo $hora['inicio']?>');"><?php echo $hora['inicio']?></a>
            </li>
            <?php    } ?>
        </ul>
<script type="text/javascript">
function confirmar(id_disponibilidad, hora){
    var paciente = $("#Cita_id_paciente").val();
    var id_especialidad = $("#Cita_id_especialidad").val();
    var especialidad =$("#Cita_id_especialidad option:selected").html(); 
    var medico =$("#especialista option:selected").html();    
    var fecha =$("#fecha").val();  
    bootbox.confirm("¿Esta seguro de tomar esta cita?<br>"+ especialidad + "<br>"+ medico + "<br>" + fecha +" "+hora, function(confirmed){
        if(confirmed){
            <?php echo CHtml::ajax(array(
                'url'=>$this->createUrl('create'),
                'type'=>'post',
                'data'=>array(
                    'id_disponibilidad'=>'js:id_disponibilidad',
                    'paciente'=>'js:paciente',
                ), 
                 'dataType'=>'json',
                 'success'=> "function(data){
                     if(data.status == \"success\"){
                            //alert(data.content);
                          location.href = data.content;
                     }
                 }"
            ))
            ?>;
        }
            
    })
}
    
</script>