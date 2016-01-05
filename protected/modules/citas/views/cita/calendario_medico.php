
<div class="form-group" align="center">
        <?php echo CHtml::label('Fechas Disponibles', 'fechas_disponibles');?>
        <div id="date">

        </div>
    </div>
    <div class="form-group">
        <?php echo CHtml::label('Horario Disponible', 'horario_disponibles');?>
        <div id="hours">

        </div>
    </div>


<?php 
    
?>

<script type="text/javascript">
$(document).ready(function(){
  
//    var availableDates = ["13-12-2015","01-12-2015","02-12-2015","03-12-2015","04-12-2015","05-12-2015","06-12-2015","21-12-2015"];
    var availableDates = <?php echo $dias_disponibles;?>;
        

        function available(date) {
          d = date.getDate();
          if (d<10)
              d = '0'+d;
          m = (date.getMonth()+1);
          if (m<10)
              m = '0'+m;
          
          dmy = date.getFullYear()+ "-" +m + "-" +d;
          if (availableDates.indexOf(dmy) != -1) {
            return {
                classes: 'active'
            };
          } else {
            return false;
          }
        }
        
        $('#date').datepicker({
            format: "yyyy-mm-dd",
            language: "es",
            beforeShowDay: available,
        });
        
        $('#date').on("changeDate", function() {
            var fecha = $('#date').datepicker('getFormattedDate');
            var id_recurso = <?php echo $id_recurso;?>;
            <?php echo CHtml::ajax(array(
            'url'=>$this->createUrl('traerCitasDisponibles'),
            'type'=>'post',
            'data'=>array(
                'fecha'=>'js:fecha',
                'id_recurso'=>'js:id_recurso'
            ), 
             'dataType'=>'json',
             'success'=> "function(data){
                 if(data.status == \"success\"){
                      $('#hours').html(data.content);
                 }
             }"
        )) 
        ?>;
        });
});  
</script>