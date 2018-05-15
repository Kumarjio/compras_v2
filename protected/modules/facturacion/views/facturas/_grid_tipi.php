<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('facturas-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="well">
    <center><h5><?php echo $tipificada." - ".$tipi_nombre->descripcion_tipificada;?></h5></center><br>
<?php
echo CHtml::label('Cuenta por Pagar', 'cuenta_x_pagar', array('style'=>'font-weight: bold;'));
echo CHtml::textField('cuenta_x_pagar',$tipi_nombre->cuenta_por_pagar,array('class'=>'span5 numero valor_tipi', 'maxlength'=>17, "data_fra"=>$tipi_nombre->id_tipificadas_facturas, "data_atrib"=>"cuenta_x_pagar"));
?>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'facturas-tipi-grid-detalle',
	'dataProvider'=>$model->search_detalle($cuenta, $tipificada, $factura),
	'type'=>'striped bordered condensed',
        'enableSorting'=>false,
	'columns'=>array(
                'consecutivo_valor',
                'descripcion_valor',
                array(
                    'name'=>'centro_costos',
                    'type'=>'raw',  
                    'value'=>'CHtml::textField("centro_costos[$data->id_tipificadas_facturas]",$data->centro_costos , array("class"=>"centroAutocomplete", "style"=>"width:123px", "data_fra"=>$data->id_tipificadas_facturas, "data_atrib"=>"centro_costos","data-toggle"=>"tooltip", "data-placement"=>"bottom"))'
                ),
                array(
                    'name'=>'agencia',
                    'type'=>'raw',
                    'value'=>'CHtml::dropDownList("agencia[$data->id_tipificadas_facturas]", $data->agencia, array("100"=>"100","200"=>"200","300"=>"300"),array("class"=>"valor_tipi", "style"=>"width:123px","data_fra"=>$data->id_tipificadas_facturas, "data_atrib"=>"agencia", "prompt"=>"Selecccione..."))'
                ),
                array(
                    'name'=>'valor',
                    'type'=>'raw',
                    'value'=>'CHtml::activeTextField($data, "valor[$data->id_tipificadas_facturas]", array("value"=>$data->valor,"class"=>"maskValor valor_tipi", "style"=>"text-align: right; width:123px;", "data_fra"=>$data->id_tipificadas_facturas, "data_atrib"=>"valor"))'
                ),
            array(
              'class'=>'bootstrap.widgets.BootButtonColumn',
              'template' => '{adicionar}',
              'buttons'=>array
                        (
                          'adicionar' => array
                              (
                                'label' => "<i class='icon-arrow-down'></i>", 
                                'url' => 'Yii::app()->createUrl("facturacion/facturas/addTipificada",array("id_tipi"=>$data->id_tipificadas_facturas))',
                                'options'=>array(
                                   'title' => 'Adicionar Otra Linea',  
                                    'class'=> 'adiccionar-tipificada',
                                    'data_id_tipi'=>'$data->id_tipificadas_facturas'
      //                            'onClick'=>	'jQuery.ajax({\'url\':\'$(this).attr("href")\',\'dataType\':\'json\',\'type\':\'post\',\'success\':function(data){
      //                                    if(data.status == \'success\'){
      //                                            $(\'#myModalOrden\').modal(\'hide\');
      //                                            resetGridView("proveedores-grid");
      //                                    }else{
      //                                        alert(\'algo paso\');
      //                                    }
      //                            },\'cache\':false});return false;'                               
                                ),
                              ),
                        ),
            ),
	),
)); ?>

</div>
<script type="text/javascript">
 $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('.maskValor').maskMoney({decimal:'.',precision:0, allowZero:true});
    
    $( ".centroAutocomplete" ).autocomplete({
        source: <?php echo  CJSON::encode(array_map(function($key, $value) {
                            $algo = explode(' - ', $value);
                           return array('label' => $value, 'value' => $algo[0]);
                        }, 
                        array_keys(Facturas::model()->getCentroCosto()), 
                        Facturas::model()->getCentroCosto()));?>,
        select: function(event, ui) {  
            var selector = this;
            var url = '<?php echo Yii::app()->createUrl("facturacion/facturas/validarCentro") ?>';
            var valor = ui.item.value;
            var id_tipificadas_facturas = $(this).attr('data_fra');
            $.ajax({
             type: 'post',
             dataType : 'json',
             url : url,
             data : { valor : valor, id_tipificadas_facturas : id_tipificadas_facturas},
             success : function(data){
             //  console.log(data);
                if(data.status == "1"){
                    autoGuardar(selector,ui.item.value);
                    $("#agencia_"+id_tipificadas_facturas).focus();
                }else{
                    $(selector).notify("Este centro de costos debe ser diferente a los \n seleccionados en el mismo consecutivo","error");
                    //$(selector).attr('title','Este centro de costos debe ser diferente a los seleccionados en el mismo consecutivo');
                    $(selector).val('');
                }
             }
           });
        },
        response:function(event, ui) { 
            console.log('HL close');
        }
        
    }).focus(function(e){
        e.preventDefault();
        if($(this).val()==''){
            var selector = this;
            var valor = '<?php echo Facturas::model()->findByPk($factura)->centroCostos[0]->idCentroCostos->codigo;?>';
            var url = '<?php echo Yii::app()->createUrl("facturacion/facturas/validarCentro") ?>';
            var id_tipificadas_facturas = $(this).attr('data_fra');
            $.ajax({
                type: 'post',
                dataType : 'json',
                url : url,
                data : { valor : valor, id_tipificadas_facturas : id_tipificadas_facturas},
                success : function(data){
                //  console.log(data);
                   if(data.status == "1"){
                       $(selector).val(valor);
                       autoGuardar(selector,valor); 
                   }
                }
           });
        }
    }).blur(function(e){
        e.preventDefault();
        if($(this).val()!=''){
            var selector = this;
            var valor = $(this).val();
            var url = '<?php echo Yii::app()->createUrl("facturacion/facturas/validarCentro") ?>';
            var id_tipificadas_facturas = $(this).attr('data_fra');
            $.ajax({
                type: 'post',
                dataType : 'json',
                url : url,
                data : { valor : valor, id_tipificadas_facturas : id_tipificadas_facturas},
                success : function(data){
                //  console.log(data);
                   if(data.status == "1"){
                       autoGuardar(selector,valor); 
                   }
                   else {
                        $(selector).notify("Este centro de costos debe ser diferente a los \n seleccionados en el mismo consecutivo","error");
                        $(selector).val('');
                   }
                }
           });
        }
    });
    $('.valor_tipi').blur(function(e){
        e.preventDefault();
        autoGuardar(this,'');
    });
    function autoGuardar(selector, valor){
        if (valor == '')
            valor = selector.value;
        var id_tipificadas_facturas = $(selector).attr('data_fra');
        var atributo = $(selector).attr('data_atrib');
        if(atributo == 'valor' && valor*1 == 0)
            valor = '';
        var url = '<?php echo Yii::app()->createUrl("facturacion/facturas/guardarValor") ?>'; 
        
        var xhr =null;
        xhr = $.ajax({
            type: 'post',
            dataType : 'json',
            url : url,
            data : { valor : valor, id_tipificadas_facturas : id_tipificadas_facturas, atributo: atributo },
            success : function(data){
            //  console.log(data);
               if(data.status == "1"){
                   //resetGridView("facturas-tipi-grid-detalle");
               }else{
                   //alert("no guardo");
               }
            },
            cache: false
        });
    }
    $(".adiccionar-tipificada").click( function(e){
        e.preventDefault();
        var id_tipi = $(this).attr("href").split("/").pop();
        var centro = $("#centro_costos_"+id_tipi).val();
        var agencia = $("#agencia_"+id_tipi).val();
        var valor = $("#TipificadasFacturas_valor_"+id_tipi).val()*1;
        if(centro == '' || agencia == '' || valor == 0){
            alert("Primero diligencie todos los campos de la linea");
        }
        else 
            addTipificada($(this).attr("href"));
        return false;
    });
    function addTipificada(url)
    {
        var xhr =null;
        var xhr2 =null;
        xhr = $.ajax({'url': url ,'type':'post','dataType':'json','success':function(data)
            {
                if(data.status == 'success'){
                    xhr2 = $.ajax({
                        'url':'<?php echo Yii::app()->createUrl("facturacion/facturas/traerDetalleTipi", 
                                                array("cuenta"=>$cuenta, "tipificada"=>$tipificada, "factura"=>$factura))?>',

                        'success':function(html){
                            jQuery("#valores_tipi").html(html);
                            jQuery("#valores_tipi2").html(html);
                        },
                        cache: false,
                    });
                    //$.fn.yiiGridView.update('facturas-tipi-grid-detalle');
                    //alert('algo');
                }
            },
            cache: false
        });
        xhr2.abort();
        xhr.abort();
        return false;
    }
    
    $('.numero').keypress(function(e){
        var tecla = document.all ? tecla = e.keyCode : tecla = e.which;
        if((tecla >= 48 && tecla <= 57) || tecla==8 || tecla==0){
                return true
        }else{
                return false;
        }			
    });
});
</script>