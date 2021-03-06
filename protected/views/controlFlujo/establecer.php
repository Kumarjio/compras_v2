<style type="text/css">
#mynetwork {
  position:relative;
  /*width: 1049px;*/
  height: 600px;
  /*border: 1px solid lightgray;*/
}
.letter-primary {
  color:#045FB4;
}
/*table.legend_table {
  font-size: 11px;
  border-width:1px;
  border-color:#d3d3d3;
  border-style:solid;
}
table.legend_table,td {
  border-width:1px;
  border-color:#d3d3d3;
  border-style:solid;
  padding: 2px;
}
div.table_content {
  width:80px;
  text-align:center;
}
div.table_description {
  width:100px;
}*/
/*#network-popUp {
  display:none;
  position:absolute;
  top:180px;
  z-index:299;
  width:250px;
  height:120px;
  background-color: #f9f9f9;
  border-style:solid;
  border-width:2px;
  border-color: #5394ed;
  padding:10px;
  text-align: center;
}*/
#sumaTiempos{
  text-align: center;
}
#tiempoInterno{
  text-align: center;
}
</style>  
<body onload="init();">
    <div class="x_title">
      <div class='col-md-1'>
      <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.BootButton', array(
          'buttonType'=>'button',
          'icon'=>'glyphicon glyphicon-arrow-left',
          'type'=>'primary',
          'label'=>'Atras',
          'htmlOptions' => array('id'=>'atras_desde_establecer'), 
        )); ?>
      </div>
    </div>
      <div class='col-md-5'>
        <h3>Ajustar Flujo  <?php //echo Tipologias::nombreTipologia($_GET['tipo']); ?></h3>
      </div>
        <ul class="nav navbar-right panel_toolbox">
        </ul>
      <div class="clearfix"></div>
    </div>


<div class="table-responsive">
  <table class="table table-bordered">
    <tr width="100%">
      <td width="50%"><h5><strong class="letter-primary">Tipologia: </strong></h5><?php echo Tipologias::nombreTipologia($_GET['tipo']); ?></td>
      <td width="30%"><h5><strong class="letter-primary">Area: </strong></h5><?php echo Areas::nombreArea($_GET['tipo']); ?></td>
      <td width="10%"><h5><strong class="letter-primary">Tiempo Interno: </strong></h5><?php echo CHtml::textField('tiempoInterno', $tiempoInterno, array('class'=>'form-control','maxlength'=>'2','readonly'=>true)); ?></td>
      <td width="10%"><h5><strong class="letter-primary">Tiempo Cliente: </strong></h5><?php echo CHtml::textField('sumaTiempos', $sumaTiempos, array('class'=>'form-control','maxlength'=>'2')); ?></td>
    </tr>
   </table>
</div>
      <!--<div class='col-md-2'>
        <h3>Tiempos: </h3>
      </div>
      <div class='col-md-1'>
        <h3>Interno</h3>
      </div>
      <div class='col-md-1'>
        <h4><?php //echo CHtml::textField('tiempoInterno', $tiempoInterno, array('class'=>'form-control','maxlength'=>'2','readonly'=>true)); ?></h4>
      </div>
      <div class='col-md-1'>
        <h3>Cliente</h3>
      </div>
      <div class='col-md-1'>
        <h4><?php //echo CHtml::textField('sumaTiempos', $sumaTiempos, array('class'=>'form-control','maxlength'=>'2')); ?></h4>
      </div>-->
    <div class='col-md-12'>
      <div class="form-group">
        En esta sección usted tendrá la posibilidad de modificar el flujo de esta tipología, haga todos los cambios necesarios, presione el boton guardar cambios para no perder su trabajo, pero al final haga clic en el botón definir flujo.
      </div>
    </div>
    <div class='col-md-6'>
      <div class="form-group">
            <?php $this->widget('bootstrap.widgets.BootButton', array( 
            'type'=>'primary',
            'label'=>'Guardar Cambios',
            'htmlOptions'=>array(
                'id'=>'guardarTodo',
                'class'=>'form-control',
            ),
            )); ?>
      </div>
    </div>
    <div class='col-md-6'>
      <div class="form-group">
            <?php $this->widget('bootstrap.widgets.BootButton', array( 
            'type'=>'success',
            'label'=>'Definir Flujo',
            'htmlOptions'=>array(
                'id'=>'definirFlujo',
                'class'=>'form-control',
            ),
            )); ?>
      </div>
    </div>
    <div class="oculto">
      <?php echo CHtml::tag('span',array('id'=>'operation'));?>
      <?php echo CHtml::tag('/span');?>
    </div>
    <div class="row">
        <?php echo CHtml::hiddenField('node-id',$id_max);?>
        <?php echo CHtml::hiddenField('puede_salir',1);?>
        <?php echo CHtml::hiddenField('idRelacion',$id_max_ege);?>
    </div>
    <div class='col-md-12 oculto'>
        <?php echo CHtml::dropDownList('locale', '' ,array("es"=>"es"), array('class'=>'form-control')) ?>
    </div>
    <?php $this->beginWidget(
        'booster.widgets.TbModal',
        array('id' => 'network-popUp')
    ); ?>
    <div class="modal-header">
        <h4><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/configuracion.png','this is alt tag of image',
          array('width'=>'20','height'=>'20')); 
          echo CHtml::link($image); ?> Gestión de flujos</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class='col-md-9'>
          <?php echo CHtml::label('Actividad *', ''); ?>
        </div>
        <div class='col-md-3'>
          <?php echo CHtml::label('Tiempo gestión *', ''); ?>
        </div>
        <div class='col-md-9'>
          <?php echo CHtml::dropDownList('node-label', '' ,CHtml::listData(Actividades::model()->findAll(array('condition'=>"id not in ( select id_actividad from actividad_tipologia where id_tipologia = :p)",'order'=>'actividad','params'=>array(':p'=>$tipologia))),'id', 'actividad'), array('class'=>'form-control', 'prompt'=>'...')) ?>
        </div>
        <div class='col-md-3'>
           <?php echo CHtml::textField('tiempoGestion','', array('class'=>'form-control','maxlength'=>'2'));?>
        </div>
      </div>  
      <br>   
      <div class="row">
        <div class='col-md-12'>
          <?php echo CHtml::label('Usuarios *', ''); ?>
        </div>
        <div class='col-md-12'>
          <?php $this->widget('ext.select2.ESelect2',array(
            'name'=>'usuarios_flujo',
            'data'=>UsuariosAreas::cargarUsuariosArea($_GET['tipo']),
            'htmlOptions'=>array(
              'options'=>array('selected'=>true), //the selected values
              'multiple'=>'multiple',
              'style'=>'width:100%',
            ),
          ));?>
        </div>
      </div>
    </div>    
    <div class="modal-footer">
      <?php $this->widget('bootstrap.widgets.BootButton', array( 
      'type'=>'success',
      'label'=>'Guardar',
      'htmlOptions'=>array(
          'id'=>'saveButton',
      ),
      )); ?>
      <?php $this->widget('bootstrap.widgets.BootButton', array( 
      'type'=>'warning',
      'label'=>'Cancelar',
      'htmlOptions'=>array(
          'id'=>'cancelButton',
      ),
      )); ?>
    </div>
    <?php $this->endWidget(); ?>
    <div id="mynetwork" class="col-md-12"></div> 
</body>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-error-flujo')
); ?>
<div class="modal-header">
    <h4 align="center"><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/warning.png','this is alt tag of image',
        array('width'=>'20','height'=>'20','title'=>'Usuario')); 
        echo CHtml::link($image); ?> Atención</h4>
</div>
<div class="modal-body" id="body-error-flujo">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => 
              array('id'=>'cierre-error-flujo'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-error-flujo2')
); ?>
<div class="modal-header">
    <h4 align="center"><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/warning.png','this is alt tag of image',
        array('width'=>'20','height'=>'20','title'=>'Usuario')); 
        echo CHtml::link($image); ?> Atención</h4>
</div>
<div class="modal-body" id="body-error-flujo2">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-flujo-ok')
); ?>
<div class="modal-header">
    <h4><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/settings.png','this is alt tag of image',
        array('width'=>'20','height'=>'20','title'=>'Usuario')); 
        echo CHtml::link($image); ?> Flujo</h4>
</div>
<div class="modal-body" id="body-flujo-ok">
  <h5 align='center'>Flujo guardado y listo para definir.</h5>
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $( document ).ready(function() {
      $("#tiempoGestion, #sumaTiempos").keyup(function (){
          this.value = (this.value + '').replace(/[^0-9]/g, '');
      });
    });
    /*
    window.onbeforeunload = function(event) {
        var salir = $("#puede_salir").val();
        alert('salir = ' + salir);
        if(salir == 0)
          event.returnValue = "Write something clever here..";
        else
          event.returnValue = "";
    };*/
    var nodes = null;
    var edges = null;
    var network = null;
    var nodos_visitados = [];
    nodes = new vis.DataSet();
    nodes.on('*', function () {
        
    });
    nodes.add(<?php echo $flujo?>);
    console.log(<?php echo $flujo?>);
    edges = new vis.DataSet();
    edges.on('*', function () {
        
    });
    edges.add(<?php echo $edges; ?>);

    var data = {nodes:nodes, edges:edges};
    var seed = 2;
    function setDefaultLocale() {
      var defaultLocal = navigator.language;
      var select = document.getElementById('locale');
      select.selectedIndex = 0; // set fallback value
      for (var i = 0, j = select.options.length; i < j; ++i) {
        if (select.options[i].getAttribute('value') === defaultLocal) {
          select.selectedIndex = i;
          break;
        }
      }
    }
    function destroy() {
      if (network !== null) {
        network.destroy();
        network = null;
      }
    }
    function draw() {
      destroy();
      nodes = [];
      edges = [];
      // create a network
      var container = document.getElementById('mynetwork');
      var options = {
        layout: {randomSeed:seed}, // just to make sure the layout is the same when the locale is changed
        locale: document.getElementById('locale').value,
        locales:{
          es: {
            edit: 'Editar',
            del: 'Eliminar selecci\u00f3n',
            back: '\u00c1tras',
            addNode: 'Agregar Actividad',
            addEdge: 'Agregar Flujo',
            editNode: 'Editar Actividad',
            editEdge: 'Editar Frujo',
            addDescription: 'Haga clic en un lugar vac\u00edo para colocar un nueva actividad.',
            edgeDescription: 'Haga clic en una actividad y arrastre la arista hacia otra actividad para conectarlos.',
            editEdgeDescription: 'Haga clic en un punto de control y arrastrelo a una actividad para conectarlo.',
            createEdgeError: 'No se puede conectar una arista a un grupo.',
            deleteClusterError: 'No es posible eliminar grupos.',
            editClusterError: 'No es posible editar grupos.'
          }
        },
        manipulation: {
          addNode: function (data, callback) {
            // filling in the popup DOM elements
            //document.getElementById('operation').innerHTML = "";
            //document.getElementById('node-id').value = data.id;
            //document.getElementById('node-label').value = data.label;
            var id = parseInt($("#node-id").val()) + 1;
            $("#node-id").val(id);
            $("#node-label").val("");
            $("#tiempoGestion").val("");
            $("#usuarios_flujo").val("");
            $('#usuarios_flujo').trigger('change');
            console.log(id);
            console.log(data); 
            data.nuevo = "Si";
            document.getElementById('saveButton').onclick = saveData.bind(this, data, callback);
            document.getElementById('cancelButton').onclick = clearPopUp.bind();
            //document.getElementById('network-popUp').style.display = 'block';["1012323187","1040742092"]
            $("#network-popUp").modal("show");
          },
          editNode: function (data, callback) {
            /*if(data.id_actividad == 1 || data.id_actividad == 20){
                $("#modal-error-flujo2 #body-error-flujo2").html("<h5 align='center' class='red'>No puede editar esta actividad.</h5>");
                $("#modal-error-flujo2").modal("show");
              callback(data);
            }else{*/
              // filling in the popup DOM elements
              //
              //console.log(data.id_actividad);
              $("#node-label").val(data.id_actividad);
              $("#tiempoGestion").val(data.tiempo);
              //console.log($("#node-label").val());
              $("#usuarios_flujo").val(data.usuario);
              $('#usuarios_flujo').trigger('change');
              $('#node-label').append($('<option>', {
                  value: data.id_actividad,
                  text: data.label,
              }));
              $('#node-label').val(data.id_actividad);
              document.getElementById('operation').innerHTML = "";
              document.getElementById('node-id').value = data.id;
              //document.getElementById('node-label').value = data.label;
              data.editado = "Si";
              document.getElementById('saveButton').onclick = saveData.bind(this, data, callback);
              document.getElementById('cancelButton').onclick = cancelEdit.bind(this,callback);
              //document.getElementById('network-popUp').style.display = 'block';
              $("#network-popUp").modal("show");
             //}
          },
          addEdge: function (data, callback) {
            data.arrows = 'to';
            var actividadFrom = getActividad(data.from);
            var actividadTo = getActividad(data.to);
            if(actividadFrom == 1 && actividadTo == 20 || actividadTo == 1 && actividadFrom == 20){
                bootbox.alert({
                  message: "<h5>Este flujo no se permite</h5>",
                  buttons: {
                    ok: {
                        label: "Aceptar",
                        className: "btn-danger"
                    },
                  },
                  callback: function () {
                  }
                });  
            }else{
                if (data.from == data.to) {
                bootbox.alert({
                  message: "<h5>Este flujo no se permite</h5>",
                  buttons: {
                    ok: {
                        label: "Aceptar",
                        className: "btn-danger"
                    },
                  },
                  callback: function () {
                  }
                });  
                //callback(data);            
              }else {
                callback(data);
              }
            }
          },
          deleteNode: function (data, callback){
            var todos_nodos = devolverNodos();
            bootbox.confirm({
              message: "<h3>¿Esta seguro de eliminar este elemento?</h3><br><br> <h5>Despues no lo podrá recuperar.</h5>",
              buttons: {
                  confirm: {
                      label: 'Confirmar',
                      className: 'btn-primary'
                  },
                  cancel: {
                      label: 'Cancelar',
                      className: 'btn-default'
                  }
              },
              callback: function (confirm) {
                if(!confirm){
                  callback(false);
                }else{
                  var para_eliminar = getObjects(todos_nodos, "id", data.nodes[0]);
                  console.log(para_eliminar);
                  var resta = para_eliminar[0].tiempo;
                  restaTiempos = parseInt($("#sumaTiempos").val()) - resta;
                  $("#sumaTiempos").val(restaTiempos);
                  restaInterno = parseInt($("#tiempoInterno").val()) - resta;
                  $("#tiempoInterno").val(restaInterno);

                  //if(para_eliminar[0].id_actividad == 1 || para_eliminar[0].id_actividad == 20 || para_eliminar[0].id_actividad == 3){
                  if(para_eliminar[0].id_actividad == 1 || para_eliminar[0].id_actividad == 20){
                    $("#modal-error-flujo2 #body-error-flujo2").html("<h5 align='center' class='red'>No puede eliminar esta actividad.</h5>");
                    $("#modal-error-flujo2").modal("show");
                    callback(false);
                  }
                  else{
                    <?php echo CHtml::ajax(
                        array(
                          'type' => 'POST',
                          'url' => $this->createUrl("deleteFlujo"),
                          'dataType'=>'json',
                          'data'=>array('nodo'=>'js:data.nodes[0]', 'tipologia'=>$_GET['tipo']),
                          'success' => 'function(response){
                            if(response.status == "success"){
                              console.log(response.content);
                              callback(data);
                            }
                            else {
                              console.log(response.content);
                            }
                          }'
                        )
                    );?>

                  }
                }
              }
            });
            /*if(!confirm("¿Esta seguro de eliminar este elemento ya despues no lo podrá recuperar? ")){
              callback(false);
            }else{
              var para_eliminar = getObjects(todos_nodos, "id", data.nodes[0]);
              console.log(para_eliminar);
              var resta = para_eliminar[0].tiempo;
              restaTiempos = parseInt($("#sumaTiempos").val()) - resta;
              $("#sumaTiempos").val(restaTiempos);
              restaInterno = parseInt($("#tiempoInterno").val()) - resta;
              $("#tiempoInterno").val(restaInterno);


          
              if(para_eliminar[0].id_actividad == 1 || para_eliminar[0].id_actividad == 20 || para_eliminar[0].id_actividad == 3){
                $("#modal-error-flujo2 #body-error-flujo2").html("<h5 align='center' class='red'>No puede eliminar esta actividad.</h5>");
                $("#modal-error-flujo2").modal("show");
                callback(false);
              }
              else{
                <?php echo CHtml::ajax(
                    array(
                      'type' => 'POST',
                      'url' => $this->createUrl("deleteFlujo"),
                      'dataType'=>'json',
                      'data'=>array('nodo'=>'js:data.nodes[0]', 'tipologia'=>$_GET['tipo']),
                      'success' => 'function(response){
                        if(response.status == "success"){
                          console.log(response.content);
                          callback(data);
                        }
                        else {
                          console.log(response.content);
                        }
                      }'
                    )
                );?>

              }
              
            }*/
          }
        },

        /*edges: {
          "smooth": false
        },
        "layout": {
          "hierarchical": {
            "enabled": true,
            "blockShifting": false,
            "edgeMinimization": false,
            "sortMethod": "directed"
          }
  },*/
      };
      network = new vis.Network(container, data, options);
    }
    function clearPopUp() {
      document.getElementById('saveButton').onclick = null;
      document.getElementById('cancelButton').onclick = null;
      //document.getElementById('network-popUp').style.display = 'none';
      $("#network-popUp").modal("hide");
    }
    function cancelEdit(callback) {
      clearPopUp();
      callback(null);
    }
    function saveData(data,callback) {
      var actividad = document.getElementById('node-label').value;
      var usuarios = $("#usuarios_flujo").val();
      var tiempo = $("#tiempoGestion").val();
        if(usuarios != null && actividad != "" && tiempo !=""){
          data.tiempo = parseInt($("#tiempoGestion").val());
          var suma = parseInt($("#sumaTiempos").val()) + data.tiempo;
          $("#sumaTiempos").val(suma);
          var sumaInterno = parseInt($("#tiempoInterno").val()) + data.tiempo;
          $("#tiempoInterno").val(sumaInterno);
          data.id = parseInt(document.getElementById('node-id').value);
          data.value = document.getElementById('node-label').value;
          console.log(data.id);
          if(data.value == 1 || data.value == 20)
            data.color = '#F5A9A9'
          data.id_actividad= document.getElementById('node-label').value;
          data.label  = $("#node-label option:selected").text();
          data.usuario =  $("#usuarios_flujo").val();
          //console.log(usuarios);
          $("#node-label option[value='"+data.id_actividad+"']").remove();
          $("#puede_salir").val(0);
          clearPopUp();
          callback(data);
      }else{
        $("#network-popUp").modal("hide");
        $("#modal-error-flujo #body-error-flujo").html("<h5 align='center' class='red'>Debe Ingresar por lo menos un usuario una actividad y tiempo de gestión.</h5>");
        $("#modal-error-flujo").modal("show");
        //alert("Debe Ingresar por lo menos un usuario");
      }
    }
    function init() {
      setDefaultLocale();
      draw();
    }
    function getActividad(id){
      var informacion = getObjects(data.nodes.get(),"id", id);
      return informacion[0].id_actividad;
    }
    $('#guardarTodo').on('click',function(e){
      var nodos_enviar = data.nodes.get();
      var edges_enviar = data.edges.get();
      /*$.each(edges_enviar, function(i, item) {
          console.log("inicia item");
          console.log(item);
          console.log(getObjects(edges_enviar, "from", item.to));
      });*/
      var sumaTiempos = $("#sumaTiempos").val();
      var nodo_recepcion = getObjects(nodos_enviar, "id_actividad", "1") ;
      var nodo_cierre = getObjects(nodos_enviar, "id_actividad", "20");
      var para_iniciar = getObjects(edges_enviar, "from", nodo_recepcion[0].id) ;
      var validar = true;
      if(para_iniciar.length == 0){
        $("#modal-error-flujo2 #body-error-flujo2").html("<h5 align='center' class='red'>Para poder guardar ud debe llevar todos los caminos a cierre de caso.</h5>");
        $("#modal-error-flujo2").modal("show");
        //alert("Para poder guardar ud debe llevar todos los caminos a cierre de caso.");
        return false;
      }
      //nodos_visitados.push(nodo_recepcion[0].id);
      $.each(para_iniciar, function(i, item) {
        //nodos_visitados.push(item.to);
        validar =  validar && isComplet(edges_enviar, item, i,nodo_cierre[0].id);
      });
      //var validar = isComplet(edges_enviar, para_iniciar[0], 0);

      console.log(validar);
      if(nodos_visitados.length + 1 != nodos_enviar.length)
        validar = false;
      console.log(nodos_visitados);
      nodos_visitados = [];

      if(!validar){
        $("#modal-error-flujo2 #body-error-flujo2").html("<h5 align='center' class='red'>Para poder guardar ud debe llevar todos los caminos a cierre de caso.</h5>");
        $("#modal-error-flujo2").modal("show");
        return false;
      }
      else{
      <?php echo CHtml::ajax(
          array(
            'type' => 'POST',
            'url' => $this->createUrl("guardarConexiones"),
            'dataType'=>'json',
            'data'=>array('nodos'=>'js:nodos_enviar', 'enlaces'=>'js:edges_enviar', 'tipologia'=>$_GET['tipo'], 'sumaTiempos'=>'js:sumaTiempos'),
            'success' => 'function(response){
              if(response.status == "success"){
                console.log(data);
                console.log(response.content.flujo);
                console.log(network);
                nodes = null;
                edges = null;
                nodes = new vis.DataSet();
                nodes.add(response.content.flujo);
                edges = new vis.DataSet();
                edges.add(response.content.edges);
                data = {nodes:nodes, edges:edges};
                network.setData(data);
                network.redraw();
                $("#modal-flujo-ok").modal("show");
              }
              else {
                $("#modal-error-flujo2 #body-error-flujo2").html(response.content);
                $("#modal-error-flujo2").modal("show");
                console.log(response.content);
              }
            }'
          )
      );?>
      }
    });
    function isComplet(obj, item, i,cierre){

      var agregar = true;
      for (var j in nodos_visitados){
        if(nodos_visitados[j] == item.from){
          agregar = false
        }
      }
      if(agregar)
        nodos_visitados.push(item.from);
      
      var result = true;
      if(item.to == cierre){
        result  = true;
      }
      else{
        for (var j in nodos_visitados){
          if(nodos_visitados[j] == item.to){
            console.log("item ya visitado " + item.to + " y viene del " + item.from);
            return !es_circular(item.to, item);
          }
        }
        var obj2 = getObjects(data.edges.get(), "from", item.to);
        if(obj2.length == 0){
                  console.log("problema no tiene nada",item);
                  return false; 
                }
        $.each(obj2, function(i, item) {
          result =  result && isComplet(obj2, item, i,cierre);
        });
      }
      return result;

    }
    function getObjects(obj, key, val) {
      var objects = [];
      for (var i in obj) {
        //alert(i);
          if (!obj.hasOwnProperty(i)) continue;
          if (typeof obj[i] == 'object') {
            //alert('objeto');
              objects = objects.concat(getObjects(obj[i], key, val));
          } else if (i == key && obj[key] == val) {
            //alert('no objeto');
              objects.push(obj);
          }

      }
      return objects;
    }   
    function devolverNodos(){
      return data.nodes.get();
    }
    function es_circular(aguja, item){
      var result = false;
      if(item.from == aguja){
              console.log("item problema es circular",item);
              return true;
            }
      var anteriores = getObjects(data.edges.get(), "to", item.from);
      if(anteriores.length == 0)
        return false;
      $.each(anteriores, function(i, item) {
        result =  result || es_circular(aguja, item);
      });
      return result;

    }
    function cerrarventana() { 

    // La siguiente línea se usa si se desea mostrar un mensaje propio.
      // event.returnValue = "\n Desea cerrar el sistema? \n"; 
      event.returnValue = ""; 
    }
    $("#sumaTiempos").blur(function(){
      var nodos = data.nodes.get();
      var suma = 0;
      nodos.forEach(function(nodo) {
        suma = parseInt(nodo.tiempo) + suma;
      });
      var tiempoActual = $("#sumaTiempos").val();
      if(tiempoActual == ""){
        $("#sumaTiempos").val(suma);
      }else{
        if(tiempoActual < suma){
           $("#sumaTiempos").val(suma);
        }
      }
    });
    $("#cierre-error-flujo").click(function(){
      $("#modal-error-flujo").modal("hide");
      $("#network-popUp").modal("show");
    });

    $("#definirFlujo").click(function(){
      <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'url' => $this->createUrl("validaActividad"),
          'dataType'=>'json',
          'data'=>array('tipologia'=>$_GET['tipo']),
          'success' => 'function(response){
            if(response.status == "success"){
              confirmaFlujo();
            }else{
              $("#modal-error-flujo2 #body-error-flujo2").html(response.content);
              $("#modal-error-flujo2").modal("show");
            }
          }'
        )
      );?>
    });
    function confirmaFlujo() { 
      bootbox.confirm({
        message: "<h3>¿Esta seguro de confirmar el flujo?</h3><br><br>*Al definir el flujo, queda en operación sin opción de cambios futuros.",
        buttons: {
            confirm: {
                label: 'Confirmar',
                className: 'btn-success'
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-default'
            }
        },
        callback: function (confirm) {
          if(confirm){
            <?php echo CHtml::ajax(
              array(
                'type' => 'POST',
                'url' => $this->createUrl("definirFlujo"),
                'dataType'=>'json',
                'data'=>array('tipologia'=>$_GET['tipo']),
                'success' => 'function(response){
                  if(response.status == "success"){
                    bootbox.alert({
                        message: "<h5>Flujo definido en operación</h5>",
                        buttons: {
                          ok: {
                              label: "Aceptar",
                              className: "btn-success"
                          },
                        },
                        callback: function () {
                          location.href="'.Yii::app()->createUrl('controlFlujo/createTipologia').'" 
                        }
                    });
                  }else{
                    $("#modal-error-flujo2 #body-error-flujo2").html(response.content);
                    $("#modal-error-flujo2").modal("show");
                  }
                }'
              )
          );?>
          }
        }
      });
    }
   //location.href="'.Yii::app()->createUrl('controlFlujo/createTipologia').'"
$("#atras_desde_establecer").click(function(){
  location.href="<?=Yii::app()->createUrl('/controlFlujo/createTipologia')?>";
  return false;
});
</script>