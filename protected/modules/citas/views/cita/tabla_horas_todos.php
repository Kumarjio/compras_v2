<?php
foreach ($horas as $hora) {
    
}


?>
   
        <ul class="nav nav-pills"><?php
            foreach ($horas as $hora) { ?>
            <li role="presentation">
            <a href="#"  onclick='confirmar2("<?php echo $hora['inicio']?>");'><?php echo $hora['inicio']?></a>
            </li>
            <?php    } 
           
            
            ?>
        </ul>
<script type="text/javascript">
function confirmar(hora){
    var paciente = "07:00";
    var id_especialidad = $("#Cita_id_especialidad").val();
    bootbox.dialog({
        title : "¿Esta seguro de tomar esta cita?",
        message :'<div class="form-group">'+
            data.combo+
            '</div>'
    });
        
            
}

function confirmar2(hora){
    var paciente = $("#Cita_id_paciente").val(); 
    var id_especialidad = $("#Cita_id_especialidad").val();
    <?php echo CHtml::ajax(array(
        'url'=>$this->createUrl('seleccionarMedico'),
        'type'=>'post',
        'data'=>array(
            'id_especialidad'=>'js:id_especialidad',
            'paciente'=>'js:paciente',
            'hora'=>'js:hora',
            'fecha'=>$fecha
        ), 
         'dataType'=>'json',
         'success'=> "function(data){
             bootbox.dialog({
                title : '¿Esta seguro de tomar esta cita?',
                message :'<div class=\"form-group\">'+
                    data.label + data.combo +
                    '</div>',
                buttons: {
                    success: {
                      label: \"Tomar Cita\",
                      className: \"btn-success\",
                      callback: function() {
                        var id_disponibilidad = $(\"#medico_modal\").val();
                        tomarCita(id_disponibilidad, data.id_especialidad, data.paciente);
                      }
                    },
                }
            });
         }"
    ))
    ?>
    
}

function tomarCita (id_disponibilidad, id_especialidad, paciente){
    <?php echo CHtml::ajax(array(
                'url'=>$this->createUrl('create'),
                'type'=>'post',
                'data'=>array(
                    'id_disponibilidad'=>'js:id_disponibilidad',
                    'paciente'=>'js:paciente',
                    'especialidad'=>'js:id_especialidad',
                ), 
                 'dataType'=>'json',
                 'success'=> "function(data){
                     if(data.status == \"success\"){
                          location.href = data.content;
                     }
                 }"
            ))
            ?>
}

    
</script>