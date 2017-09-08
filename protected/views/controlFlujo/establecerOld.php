<style type="text/css">
    /*html, body {
        font: 11pt arial;
    }*/
    h1 {
        font-size: 150%;
        margin: 5px 0;
    }
    h2 {
        font-size: 100%;
        margin: 5px 0;
    }
    table.view {
        width: 100%;
    }
    table td {
        vertical-align: top;
    }
    table table {
        background-color: #f5f5f5;
        border: 1px solid #e5e5e5;
    }
    table table td {
        vertical-align: middle;
    }
    input[type=text], pre {
        border: 1px solid lightgray;
    }
    pre {
        margin: 0;
        padding: 5px;
        font-size: 10pt;
    }
    #network {
        width: 100%;
        height: 400px;
        /*border: 1px solid lightgray;*/
    }
    </style>
<body onload="draw();">
<div class="x_title">
  <h3>Ajustar Flujo</h3>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<br>
<div class='col-md-12'>
  <div class="form-group">
    En esta sección usted tendrá la posibilidad de modificar el flujo de esta tipología haga todos los cambios necesarios, pero al final haga clic en el botón guardar todo.
  </div>
</div>
<div class="row">
</div>
<br>
<div class='col-md-4'>
<?php echo CHtml::label('Actividades', ''); ?>
  <div class="form-group">
    <?php echo CHtml::dropDownList('Actividades', '' ,CHtml::listData(Actividades::model()->findAll(),'id', 'actividad'), array('class'=>'form-control', 'prompt'=>'...')) ?>
    <?php echo CHtml::hiddenField('idActividad',$id_max);?>
  </div>
</div>
<div class="row">
</div>
<div class='col-md-4'>
    <div class="form-actions"> 
    <?php $this->widget('bootstrap.widgets.BootButton', array( 
            'type'=>'success',
            'id'=>'node-add',
            'label'=>'Agregar Actividad', 
            'htmlOptions'=>array(
                'onclick'=>'addNode();',
            ),
    )); ?>
    </div>
</div>
<div class="row">
</div>
<br>
<br>
<div class='col-md-4'>
    <?php echo CHtml::label('Desde', 'edge-from'); ?>
    <div class="form-group">
        <?php echo CHtml::dropDownList('desde', '' ,CHtml::listData($actividades,'id', 'idActividad.actividad'), array('class'=>'form-control', 'prompt'=>'...')) ?>
        <?php echo CHtml::hiddenField('idRelacion',$id_max_ege);?>
    </div>
</div>
<div class='col-md-4'>
    <?php echo CHtml::label('Hasta', 'edge-from'); ?>
    <div class="form-group">
    <?php echo CHtml::dropDownList('hasta', '' ,CHtml::listData($actividades,'id', 'idActividad.actividad'), array('class'=>'form-control', 'prompt'=>'...')) ?>
    </div>
</div>
<div class='col-md-4'>
    <?php echo CHtml::label('Enlace',''); ?>
    <div class="form-actions"> 
    <?php $this->widget('bootstrap.widgets.BootButton', array( 
            'type'=>'success',
            'id'=>'edge-add',
            'label'=>'Agregar', 
            'htmlOptions'=>array(
                'onclick'=>'addEdge();',
            ),
    )); ?>
    <?php $this->widget('bootstrap.widgets.BootButton', array( 
            'type'=>'success',
            'id'=>'edge-update',
            'label'=>'Actualizar', 
            'htmlOptions'=>array(
                'onclick'=>'updateEdge();',
            ),
    )); ?>
    <?php $this->widget('bootstrap.widgets.BootButton', array( 
            'type'=>'success',
            'id'=>'edge-remove',
            'label'=>'Eliminar', 
            'htmlOptions'=>array(
                'onclick'=>'removeEdge();',
            ),
    )); ?>
    </div>
</div>
<div class="row">
</div>
<br>
<br>
<div class="x_title">
  <h3>Vista Grafica</h3>
    <ul class="nav navbar-right panel_toolbox">
    </ul>
  <div class="clearfix"></div>
</div>
<div class='col-md-12'>
    <div id="network"></div>
</div>
</body>
<script type="text/javascript">
    var nodes, edges, network;
    // convenience method to stringify a JSON object
    function toJSON(obj) {
        return JSON.stringify(obj, null, 4);
    }
    function addNode() {
        var id = parseInt($("#idActividad").val()) + 1;
        $("#idActividad").val(id);
        var label  = $("#Actividades option:selected").text();
        var value = $("#Actividades").val();
        var tipologia = '<?php echo $_GET[tipo];?>';
        $("#Actividades").val('');
        $('#desde').append($('<option>', {
            value: id,
            text: label
        }));
        $('#hasta').append($('<option>', {
            value: id,
            text: label
        }));
        try {
            nodes.add({
                id: id,
                label: label,
                value: value
            });
        }
        catch (err) {
            alert(err);
        }
        console.log(nodes.get());
    }
    function updateNode() {
        try {
            nodes.update({
                id: document.getElementById('node-id').value,
                label: document.getElementById('node-label').value
            });
        }
        catch (err) {
            alert(err);
        }
    }
    function removeNode() {
        try {
            nodes.remove({id: document.getElementById('node-id').value});
        }
        catch (err) {
            alert(err);
        }
    }
    function addEdge() {
        var id = parseInt($("#idRelacion").val()) + 1;
        var from = $("#desde").val();
        var to = $("#hasta").val();
        $("#idRelacion").val(id);
        try {
            edges.add({
                id: id,
                from: from,
                to: to,
                arrows: 'to'
            });
        }
        catch (err) {
            alert(err);
        }
    }
    var from = $("#desde").val();
    var to = $("#hasta").val();
    /*function updateEdge() {
        try {
            edges.update({
                id: document.getElementById('edge-id').value,
                from: document.getElementById('edge-from').value,
                to: document.getElementById('edge-to').value
            });
        }
        catch (err) {
            alert(err);
        }
    }*/
    function removeEdge() {
        try {
            edges.remove({id: document.getElementById('edge-id').value});
        }
        catch (err) {
            //alert(err);
        }
    }
    function draw() {
        // create an array with nodes

        nodes = new vis.DataSet();
        nodes.on('*', function () {
            
        });
        /*nodes.add([
            {id: '1', label: 'Node 1'},
            {id: '2', label: 'Node 2'},
            {id: '3', label: 'Node 3'},
            {id: '4', label: 'Node 4'},
            {id: '5', label: 'Node 5'}
        ]);*/
        nodes.add(<?php echo $flujo?>);
        console.log(<?php echo $flujo?>);
        // create an array with edges
        edges = new vis.DataSet();
        edges.on('*', function () {
            
        });
        /*edges.add([
            {id: '1', from: '1', to: '2'},
            {id: '2', from: '1', to: '3'},
            {id: '3', from: '2', to: '4'},
            {id: '4', from: '2', to: '5'}
        ]);*/
        edges.add(<?php echo $edges; ?>);
        // create a network
        var container = document.getElementById('network');
        var data = {
            nodes: nodes,
            edges: edges
        };
        var options = {
        };
        network = new vis.Network(container, data, options);

    }
    function getNodos(){
        
    }

    </script>