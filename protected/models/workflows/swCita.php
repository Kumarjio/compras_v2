<?php

return array(
    'initial'=>'preagendado',
    'node'=>array(
        array(
            'id'=>'preagendado',
            'label'=>'Pre-Agendado', 
            'transition'=>array(
                'doc_recibidos',
                'expirado'
              )
        ),
        array(
            'id'=>'doc_recibidos',
            'label'=>'Documentos Recibidos', 
            'transition'=>array(
                'doc_incompletos',
                'agendado',
              )
        ),
        array(
            'id'=>'doc_incompletos',
            'label'=>'Documentos Incompletos', 
            'transition'=>array(
                'preagendado',
                'agendado'
              )
        ),
        array(
            'id'=>'agendado',
            'label'=>'Agendado',  
            'transition'=>array(
                'pagado',
                'no_cumple_paciente',
                'no_cumple_medico'
              )
        ),
        array(
            'id'=>'pagado',
            'label'=>'Agendado Pagado',  
            'transition'=>array(
                'atendido',
                'no_cumple_medico'
              )
        ),
        array(
            'id'=>'no_cumple_paciente',
            'label'=>'No Cumplio el Paciente', 
        ),
        array(
            'id'=>'no_cumple_medico',
            'label'=>'No Cumplio el Medico', 
        ),
        array(
            'id'=>'atendido',
            'label'=>'Atendido', 
        ),
    )
)

?>
