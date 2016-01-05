	
	<div class="form-group">
		<?php echo CHtml::label('Tipo de Cita','', array('class' => 'control-label')); ?>
		<?php echo CHtml::dropDownList('tipo_consulta','id_tipo_consulta',  CHtml::listData(TipoPrestacion::model()->findAll(), 'id_tipo_prestacion', 'descripcion'),array('class'=>'form-control','prompt'=>'Seleccione...')); ?>
		<?php echo $form->error($model,'tipo_consulta'); ?>
	</div>
        <?php echo $form->hiddenField($model,'id_paciente');?>
        <div id="esp" class="hidden">
            
            <div class="form-group">
                    <?php echo $form->label($model,'id_especialidad', array('class' => 'control-label')); ?>
                    <?php echo $form->dropDownList($model,'id_especialidad',  
                            CHtml::listData(Yii::app()->db->createCommand("select id_procedimiento, nombre_especialidad from especialidad as e "
                                                                        . " inner join procedimientos as p on p.identificador = e.id_especialidad "
                                                                        . "  where id_tipo_prestacion = 1")->queryAll(), 'id_procedimiento', 'nombre_especialidad'),
                            array('class'=>'form-control', 
                            'ajax' =>array(
                                'type'=>'POST',
                                'url'=>$this->createUrl('selectMedico'),
                                'update'=>'#especialista'
                            ),'prompt'=>'Seleccione la Especialidad')); ?>
                    <?php echo $form->error($model,'id_especialidad'); ?>
            </div>
                
            <div id="_especialista" class="hidden">

                <div class="form-group">
                        <?php echo CHtml::label('Especialista','', array('class' => 'control-label')); ?>
                        <?php echo CHtml::dropDownList('especialista','',array(''=>'Seleccione Especialidad'),array('class'=>'form-control')); ?>
                        <?php echo CHtml::hiddenField('especialista_id','',array('class'=>'form-control','readonly'=>true)); ?>
                            <?php echo $form->error($model,'especialidad'); ?>
                </div>



            </div>

        </div>

        <div id="ayuda" class="hidden">
            
            <div class="form-group">
                    <?php echo CHtml::label('Procedimiento','', array('class' => 'control-label')); ?>
                    <?php echo CHtml::dropDownList('procedimiento','id_tipo_consulta',  
                            CHtml::listData(Yii::app()->db->createCommand("select id_procedimiento, nombre_ayuda from ayudas_diagnosticas as a "
                                                                        . " inner join procedimientos as p on p.identificador = a.id_ayuda_diagnostica "
                                                                        . "  where id_tipo_prestacion = 2")->queryAll(), 'id_procedimiento', 'nombre_ayuda'),array('class'=>'form-control','prompt'=>'Seleccione...')); ?>
                    <?php echo $form->error($model,'procedimiento'); ?>
            </div>

        </div>

        <div class="form-group" id="dispo-grid">
            
	</div>
        
        




<script type="text/javascript">
$(document).ready(function(){
    $("#tipo_consulta").change(function(){
        var valor = this.value;
        if(valor == 1){
                $('#esp').removeClass('hidden');
                $('#ayuda').addClass('hidden');
                $("#procedimiento").val("");
                $('#dispo-grid').addClass('hidden');
                
        }
        else if (valor == 2){
                $('#esp').addClass('hidden');
                $('#ayuda').removeClass('hidden');
                $("#Cita_id_especialidad").val("");
                $('#_especialista').addClass('hidden');
                $('#dispo-grid').addClass('hidden');
        }
        else {
                $('#esp').addClass('hidden');
                $('#ayuda').addClass('hidden');
                $('#dispo-grid').addClass('hidden');
        }
    });
    
     $("#Cita_id_especialidad").change(function(){
        var valor = this.value;
        if(valor != ''){
            $('#_especialista').removeClass('hidden');
            $('#dispo-grid').removeClass('hidden');
            traerDisponibilidadTodos();
        }
        else {
            $('#_especialista').addClass('hidden');
            $('#dispo-grid').removeClass('hidden');
        }
    });
    $("#especialista").change(function(){
        var valor = this.value;
       if(valor != ''){
           traerDisponibilidad();
       }
       else {
           traerDisponibilidadTodos();
       }
    });
    
    
     $("#procedimiento").change(function(){
         var valor = this.value;
        if(valor != ''){
            traerDisponibilidadProcedimiento();
        }
        else {
            $('#dispo-grid').html('');
        }
     });
    
});

function traerDisponibilidad(){
    var valor = $('#especialista').val();
        <?php echo CHtml::ajax(array(
            'url'=>$this->createUrl('traerDisponibilidadMedico'),
            'type'=>'post',
            'data'=>array(
                'id_recurso'=>'js:valor'             
            ), 
             'dataType'=>'json',
             'success'=> "function(data){
                 if(data.status == \"success\"){
                    $('#dispo-grid').removeClass('hidden');
                    $('#dispo-grid').html(data.content);
                 }
             }"
        ))
        ?>;
        return true;
}    

function traerDisponibilidadTodos(){
    
        <?php echo CHtml::ajax(array(
            'url'=>$this->createUrl('traerDisponibilidadTodos'),
            'type'=>'post',
            'data'=>array(
                            
            ), 
             'dataType'=>'json',
             'success'=> "function(data){
                 if(data.status == \"success\"){
                    $('#dispo-grid').removeClass('hidden');
                      $('#dispo-grid').html(data.content);
                 }
             }"
        ))
        ?>;
        return true;
}

function traerDisponibilidadProcedimiento(){
    var valor = $('#procedimiento').val();
        <?php echo CHtml::ajax(array(
            'url'=>$this->createUrl('traerDisponibilidadProcedimiento'),
            'type'=>'post',
            'data'=>array(
                'id_procedimiento'=>'js:valor'             
            ), 
             'dataType'=>'json',
             'success'=> "function(data){
                 if(data.status == \"success\"){
                    $('#dispo-grid').removeClass('hidden');
                      $('#dispo-grid').html(data.content);
                 }
             }"
        ))
        ?>;
        return true;
}    
</script>