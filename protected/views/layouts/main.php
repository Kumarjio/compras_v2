<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"/>-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <?php Yii::app()->clientScript->registerCssFile('/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css'); ?>
    <!-- Font Awesome -->
    <?php Yii::app()->clientScript->registerCssFile('/gentelella/vendors/font-awesome/css/font-awesome.min.css'); ?>
    <!-- NProgress -->
    <?php Yii::app()->clientScript->registerCssFile('/gentelella/vendors/nprogress/nprogress.css'); ?>

    <?php Yii::app()->clientScript->registerScriptFile('/static/js/app.js'); ?>
    <!-- iCheck -->
    <?php Yii::app()->clientScript->registerCssFile('/gentelella/vendors/iCheck/skins/flat/green.css'); ?>
    <!-- Custom Theme Style -->
    <?php if(!Yii::app()->user->isGuest){ ?>
    <?php Yii::app()->clientScript->registerCssFile('/gentelella/build/css/custom.min.css'); ?>
    <?php } ?>
    <!--[if lt IE 8]>
        <?php Yii::app()->clientScript->registerScriptFile('/static/js/respond.js'); ?>
    <![endif]-->
    <?php Yii::app()->clientScript->registerCssFile('/static/vis/dist/vis-network.min.css'); ?>
    
    <?php Yii::app()->clientScript->registerCssFile('/static/fancybox/jquery.fancybox.min.css'); ?>
    <!-- PNotify -->
    <?php Yii::app()->clientScript->registerCssFile('/gentelella/vendors/pnotify/dist/pnotify.css'); ?>

    <?php Yii::app()->clientScript->registerCssFile('/gentelella/vendors/pnotify/dist/pnotify.buttons.css'); ?>

    <?php Yii::app()->clientScript->registerCssFile('/gentelella/vendors/pnotify/dist/pnotify.nonblock.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/fileuploader.css'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/static/js/jquery.mask.js'); ?>
  </head>
  <style type="text/css">
    .centro
    {
        text-align:center;
    }
    .alertaImagine
    {
        color:#B40404;
    }
    .oculto
    {
        display:none;
    }
    .red
    {
        color:#FF0000;
    }
    .blue
    {
        color:#08088A;
    }
    .lightBlue
    {
        color:#0080FF;
    }
    .hand
    {
        cursor: pointer;
    }
    .espacio
    {
        padding-left : 800px
    }
    .inicial 
    {
        text-transform: capitalize;
    }
    .yellow 
    {
        background-color:#FFFF00;
    }
    textarea
    {
        resize:none;
    }
    .form-control:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
    }
    .embed-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
    }
    .embed-container iframe {
        position: absolute;
        top:0;
        left: 0;
        width: 100%;
        height: 100%;
    }
  </style>
<?php if(Yii::app()->user->isGuest){ ?>
        <div class="container-fluid">
            <div class="x_panel">
                <?php echo $content; ?>
            </div>
        </div>      
<?php }else{?>
<body class="nav-md">
<div class="oculto"> 
  <?php $this->widget(
    'booster.widgets.TbCKEditor',
    array(
        'name' => 'ckeditor,css,js',
    )
);?>
</div>
<div id="content">
    <!-- menu profile quick info -->
    <div class="container body">
        <div class="main_container">
            <?php //if(!Yii::app()->user->isGuest): ?>   
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <br>
                    <div class="clearfix"></div>
                    <br>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                      <div class="profile_pic">
                        <?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/user.png','this is alt tag of image',
                            array('width'=>'80','height'=>'80','title'=>'Usuario')); 
                        echo CHtml::link($image); ?>
                      </div>
                      <div class="profile_info">
                        <span><?php if(!Yii::app()->user->isGuest){echo Yii::app()->user->name;?></span>
                        <h2><?php echo Yii::app()->user->name; } ?></h2>
                      </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <!-- sidebar menu -->
                    <br>
                    <?php $this->renderPartial('//site/menu'); ?>
                    <br>
                    <!-- /sidebar menu -->
                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                      <a data-toggle="tooltip" data-placement="top" title="Imprimir" onclick="window.print();">
                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                      </a>
                      <a data-toggle="tooltip" data-placement="top" title="Ampliar" href="javascript:void(0);" id="ampliar">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                      </a>
                      <a data-toggle="tooltip" data-placement="top" title="Consultar" id="consulta">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </a>
                      <a data-toggle="tooltip" data-placement="top" title="Salir" href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                      </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <div class="profile clearfix">
                                <div class="profile_pic">
                                    <!--<img class="profile-img" src="/images/bolivar.png" width="90" alt="">-->
                                    <!--<img class="profile-img" src="/images/home.png" width="150" alt="">-->
                                    <?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/tuya_logo.jpg','this is alt tag of image',
                                        array('width'=>'100','title'=>'Inicio','id'=>'home')); 
                                    echo CHtml::link($image); ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            </div>
            <?php //endif ?>
            <div class="right_col" role="main">
                <div class="row">
                    <div class="page-title">
                        <div class="col-md-12">
                            <div class="x_panel" id="contentJ">
                                <?php echo $content; ?>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <!--=== End Content Part ===-->
    </div> 
</div>
<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modal-consulta')
); ?>
<div class="modal-header">
        <h4><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/consulta.png','this is alt tag of image',
        array('width'=>'20','height'=>'20')); 
        echo CHtml::link($image); ?> Consultar caso</h4>
</div>
<div class="modal-body">
<?php /*$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    'name'=>'consulta_autocomplete',
    'source'=>$this->createUrl("recepcion/casos"),
    'options'=>array(
        'minLength'=>'2',
    ),
    'htmlOptions'=>array(
        'class'=>'form-control','id'=>'input_consulta'
    ),
));*/?>
<?php echo CHtml::radioButtonList('tipo_busqueda','1', array('1'=>'Caso', '2'=>'Documento'),array('class'=>'radio-inline')); ?>
<?php echo CHtml::textField('consulta_autocomplete','',array('class'=>'form-control','maxlength'=>'10')); ?>
</div>
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'icon'=>'glyphicon glyphicon-share-alt', 
        'type'=>'info',
        'label'=>'Consultar',
        'htmlOptions' => array('id'=>'gestion_carta','id'=>'consulta_data'), 
    )); ?>
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
    array('id' => 'modal-msj12')
); ?>
<div class="modal-header">
        <h4><?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/consulta.png','this is alt tag of image',
        array('width'=>'20','height'=>'20')); 
        echo CHtml::link($image); ?> Consultar caso</h4>
</div>
<div class="modal-body" id="body-msj12">
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'htmlOptions' => array('id' => 'cerrar-msj12'),
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>
</body>
<?php }?>
<script src="/gentelella/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/gentelella/vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<!--<script src="/gentelella/vendors/Chart.js/dist/Chart.min.js"></script>-->
<!-- gauge.js -->
<script src="/gentelella/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<!-- <script src="/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>-->
<!-- iCheck -->
<script src="/gentelella/vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="/gentelella/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="/gentelella/vendors/Flot/jquery.flot.js"></script>

<script src="/gentelella/vendors/Flot/jquery.flot.pie.js"></script>

<script src="/gentelella/vendors/Flot/jquery.flot.time.js"></script>

<script src="/gentelella/vendors/Flot/jquery.flot.stack.js"></script>

<script src="/gentelella/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>

<script src="/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>

<script src="/gentelella/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="/gentelella/vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="/gentelella/vendors/jqvmap/dist/jquery.vmap.js"></script>

<script src="/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

<script src="/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<?php Yii::app()->clientScript->registerScriptFile('/static/js/moment.min.js'); ?>

<?php Yii::app()->clientScript->registerScriptFile('/static/vis/dist/vis.js'); ?>

<?php Yii::app()->clientScript->registerScriptFile('/static/fancybox/jquery.fancybox.min.js'); ?>

<?php Yii::app()->clientScript->registerScriptFile('/static/tiff-master/tiff.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/fileuploader.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/utils.js'); ?>
    <!-- jQuery Smart Wizard -->
<?php Yii::app()->clientScript->registerScriptFile('/gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js'); ?>
<!--<script src="/static/js/jquery.datetimepicker.js"></script>-->
<!--<script src="/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>-->
<!-- Custom Theme Scripts -->
<script src="/gentelella/build/js/custom.js"></script>
<!-- PNotify -->
<?php Yii::app()->clientScript->registerScriptFile('/gentelella/vendors/pnotify/dist/pnotify.js'); ?>

<?php Yii::app()->clientScript->registerScriptFile('/gentelella/vendors/pnotify/dist/pnotify.buttons.js'); ?>

<?php Yii::app()->clientScript->registerScriptFile('/gentelella/vendors/pnotify/dist/pnotify.nonblock.js'); ?>

<script>
$( document ).ready(function() {
    $('#consulta_autocomplete').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
    var usuario = "<?=Yii::app()->user->isGuest?>";
    if(usuario != "1"){
        setInterval(function(){ validaCasosTutela(); }, 3600000);
    }
});
function refIndex(){
    location.href="<?=Yii::app()->getBaseUrl(true).Yii::app()->getHomeUrl()?>/correspondencia/site/index/";
}
$("#ampliar").click(function(e){
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||    // metodo alternativo
      (!document.mozFullScreen && !document.webkitIsFullScreen)) {               // metodos actuales
    if (document.documentElement.requestFullScreen) {
      document.documentElement.requestFullScreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullScreen) {
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
    }
  }
});
$("#consulta").click(function(){
    $("#consulta_autocomplete").focus();
    $("#modal-consulta").modal("show");
});
$("#consulta_data").click(function(){
    var data = $("#consulta_autocomplete").val();
    var tipo_busqueda = $('#tipo_busqueda input:radio[name=tipo_busqueda]:checked').val();

    if(data != ""){
        <?php echo CHtml::ajax(
        array(
              'type' => 'POST',
              'data' => array('data' => 'js:data', 'tipo' => 'js:tipo_busqueda'),
              'url' => $this->createUrl("recepcion/valida"),
              'success' => 'function(res){
                if(res){
                    $("#consulta_autocomplete").val("");
                    location.href=res;
                }else{
                    $("#consulta_autocomplete").val("");
                    $("#modal-consulta").modal("hide");
                    $("#modal-msj12 #body-msj12").html("<h5 align=\'center\' class=\'red\'>No se encontraron resultados de la busqueda.</h5>");
                    $("#modal-msj12").modal("show"); 
                }
              }'
            )
        );?>
    }else{
        $("#modal-consulta").modal("hide");
        $("#modal-msj12 #body-msj12").html("<h5 align='center' class='red'>Debe ingresar un caso para consultar.</h5>");
        $("#modal-msj12").modal("show");
    }
});
$("#cerrar-msj12").click(function(){
    $("#modal-msj12").modal("hide");
    $("#modal-consulta").modal("show");
});
$("#home").click(function(){
    location.href="<?=Yii::app()->getBaseUrl(true).Yii::app()->getHomeUrl()?>";
});
function validaCasosTutela() {
    var imagen = "http://"+window.location.host+"/images/alfa3.png";
    <?php echo CHtml::ajax(
        array(
          'type' => 'POST',
          'url' => $this->createUrl("usuario/casosTutela"),
          'dataType'=>'json',
          'success' => 'function(data){
                if(data.status == "success"){
                    if(data.notificacion){
                        data.notificacion.forEach(function(valor, indice, arreglo){
                            notifyMe(valor, imagen, data.name);
                        });
                    }
                    if(data.alerta){
                        data.alerta.forEach(function(valor, indice, arreglo){
                            notifyMe(valor, imagen, data.name);
                        });
                    }
                }
          }'
        )
    );?>
}
function notifyMe(theBody, theIcon, theTitle) {
  if (!("Notification" in window)) {
    new PNotify({
              title: theTitle,
              text: theBody,
              type: 'success',
              styling: 'bootstrap3'
    });
  }else if (Notification.permission === "granted") {
    spawnNotification(theBody, theIcon, theTitle);
  }else if (Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {
      if (permission === "granted") {
        spawnNotification(theBody, theIcon, theTitle);
      }
    });
  }
}
function spawnNotification(theBody,theIcon,theTitle) {
  var options = {
      body: theBody,
      icon: theIcon
  }
  var n = new Notification(theTitle,options);
}
App.init();
</script>
<?php    
    Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
    jQuery("body").ajaxComplete(
        function(event, request, options) {
            if (request.responseText == "' . Yii::app()->components['user']->loginRequiredAjaxResponse . '") {
                window.location.href = "'.Yii::app()->createUrl('/correspondencia/site/login').'";
            }
        }
    );'
);
?>
</html>
