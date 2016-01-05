<?php
foreach ($horas as $hora) {
    
}


?>
   
        <ul class="nav nav-pills"><?php
            foreach ($horas as $hora) { ?>
            <li role="presentation">
            <a href="#"  onclick='return confirmar(<?php echo $hora['id_disponibilidad']?>);'><?php echo $hora['inicio']?></a>
            </li>
            <?php    } ?>
        </ul>
<script type="text/javascript">
function confirmar(id_disponibilidad){
    //var paciente = $("#Cita_id_paciente").val();
    //var id_especialidad = $("#Cita_id_especialidad").val();
    bootbox.confirm("¿Esta seguro de eliminar este cupo?", function(confirmed){
        if(confirmed){
            <?php echo CHtml::ajax(array(
                'url'=>$this->createUrl('/citas/disponibilidad/delete'),
                'type'=>'post',
                'data'=>array(
                    'id_disponibilidad'=>'js:id_disponibilidad'//,
                    //'paciente'=>'js:paciente',
                    //'especialidad'=>'js:id_especialidad'
                ), 
                 'dataType'=>'json',
                 'success'=> "function(data){
                    alert(data);
                    traerDisponibilidad();
                 }"
            ))
            ?>;
        }
            
    })
}
    
</script>