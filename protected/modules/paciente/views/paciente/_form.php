	
	<div class="form-group">
		<?php echo $form->labelEx($model,'cedula', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'cedula',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'cedula'); ?>
	</div>

        <div class="form-group">
		<?php echo $form->labelEx($model,'nombre', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'nombre',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'celular', array('class' => 'control-label')); ?>
		<?php echo $form->textField($model,'celular',array('class'=>'form-control txtnumerico','onpaste'=>"return false",'maxlength'=>10)); ?>
		<?php echo $form->error($model,'celular'); ?>
	</div>




	
	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class' => 'btn-u btn-u-blue')); ?>
	</div>
<script type="text/javascript">
$(document).ready(function(){
    $("#Paciente_cedula").blur(function(){
        var paciente = $("#Paciente_cedula").val();
        if (paciente != ''){
            <?php echo CHtml::ajax(array(
              'url'=>$this->createUrl('traerPaciente'),
              'type'=>'post',
              'data'=>array(
                  'cc_paciente'=>'js:paciente'             
              ), 
               'dataType'=>'json',
              'success'=> "function(data){
                  if(data.status == \"success\"){
                       location.href = data.url;
                  }
              }"
          ))
          ?>;
        }
    })
    
    $('.txtnumerico').keypress(function(e){
            var tecla = document.all ? tecla = e.keyCode : tecla = e.which;
            if((tecla >= 48 && tecla <= 57) || tecla==8 || tecla==0){
                    return true
            }else{
                    return false;
            }			
    });
});

</script>