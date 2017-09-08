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
    <?php Yii::app()->clientScript->registerCssFile('/correspondencia/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css'); ?>
    <!-- Font Awesome -->
    <?php Yii::app()->clientScript->registerCssFile('/correspondencia/gentelella/vendors/font-awesome/css/font-awesome.min.css'); ?>
    <!-- NProgress -->
    <?php Yii::app()->clientScript->registerCssFile('/correspondencia/gentelella/vendors/nprogress/nprogress.css'); ?>

    <?php Yii::app()->clientScript->registerScriptFile('/correspondencia/static/js/app.js'); ?>
    <!-- iCheck -->
    <?php Yii::app()->clientScript->registerCssFile('/correspondencia/gentelella/vendors/iCheck/skins/flat/green.css'); ?>
    <!-- Custom Theme Style -->
    <?php if(!Yii::app()->user->isGuest){ ?>
    <?php Yii::app()->clientScript->registerCssFile('/correspondencia/gentelella/build/css/custom.min.css'); ?>
    <?php } ?>
    <!--[if lt IE 8]>
        <?php Yii::app()->clientScript->registerScriptFile('/correspondencia/static/js/respond.js'); ?>
    <![endif]-->
    <?php Yii::app()->clientScript->registerCssFile('/correspondencia/static/vis/dist/vis-network.min.css'); ?>
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
    .hand
    {
        cursor: pointer;
    }
    .espacio
    {
        padding-left : 800px
    }
    .inicial {
        text-transform: capitalize;
    }
    textarea
    {
        resize:none;
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
        'editorOptions' => array(
            'plugins' => 'basicstyles,toolbar,enterkey,entities,floatingspace,wysiwygarea,indentlist,link,list,dialog,dialogui,button,indent,fakeobjects'
        )
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
                     <!--<div class="navbar nav_title" style="border: 0;">
                        <h6 class="site_title"><i class="fa fa-user"></i> <span>Correspondencia!</span></h6>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>-->
                    <br>
                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                      <div class="profile_pic">
                        <!--<img src="/correspondencia/images/user.png" alt="..." class="img-circle profile_img">-->
                        <?php $image = CHtml::image(Yii::app()->request->baseUrl.'/images/user.png','this is alt tag of image',
                            array('width'=>'80','height'=>'80','title'=>'Usuario')); 
                        echo CHtml::link($image); ?>
                      </div>
                      <div class="profile_info">
                        <span><?php if(!Yii::app()->user->isGuest){echo Yii::app()->user->usuario;?>,</span>
                        <h2><?php echo Usuario::model()->nombres(Yii::app()->user->usuario); } ?></h2>
                      </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <!-- sidebar menu -->
                    <br>
                    <br>
                    <br>
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>Menú</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-edit"></i> Recepción <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li>
                                            <?php echo CHtml::link('Recepcionar', $this->createUrl("/recepcion/form"), array('class'=>'form_control') );?>
                                        </li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-cube"></i> Beneficios <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="general_elements.html">Elementos Generales</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-desktop"></i> Sim Arl <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="general_elements.html">Elementos Generales</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-table"></i> Prevención <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="tables.html">Tablas</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-bar-chart-o"></i> Instructivos <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="chartjs.html">Uso correspondencia</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-clone"></i> Imagine <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li>
                                            <?php echo CHtml::link('Punteo', $this->createUrl("/cartasFisicas/admin"), array('class'=>'form_control') );?>
                                        </li>
                                        <li>
                                            <?php echo CHtml::link('Bandeja Imagine', $this->createUrl("/cartasFisicas/impresion"), array('class'=>'form_control') );?>
                                        </li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-bug"></i> Trabajador <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="projects.html">Proyectos</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-windows"></i> Administración <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><?php echo CHtml::link('Flujos', $this->createUrl("/flujo/create"), array('class'=>'form_control') );?></li>
                                        <li><?php echo CHtml::link('Plantillas', $this->createUrl("/plantillasCartas/admin"), array('class'=>'form_control') );?></li>
                                        <li><?php echo CHtml::link('Roles', $this->createUrl("/roles/admin"), array('class'=>'form_control') );?></li>
                                        <li><?php echo CHtml::link('Tipologías', $this->createUrl("/controlFlujo/createTipologia"), array('class'=>'form_control') );?></li>
                                        <li><?php echo CHtml::link('Usuarios', $this->createUrl("/usuario/admin"), array('class'=>'form_control') );?></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>Gestión</h3>
                            <ul class="nav side-menu">                
                                <li><a href="<?=Yii::app()->getHomeUrl()?>/trazabilidad/pendientes"><i class="fa fa-sitemap"></i> Bandeja de pendientes</a></li>
                            </ul>
                        </div>
                    </div>
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
                                    <!--<img class="profile-img" src="/correspondencia/images/bolivar.png" width="90" alt="">-->
                                    <img class="profile-img" src="/correspondencia/images/alfa2.png" width="45" alt="">
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
                            <div class="x_panel">
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
<script src="/correspondencia/gentelella/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/correspondencia/gentelella/vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<!--<script src="/correspondencia/gentelella/vendors/Chart.js/dist/Chart.min.js"></script>-->
<!-- gauge.js -->
<script src="/correspondencia/gentelella/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<!-- <script src="/correspondencia/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>-->
<!-- iCheck -->
<script src="/correspondencia/gentelella/vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="/correspondencia/gentelella/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="/correspondencia/gentelella/vendors/Flot/jquery.flot.js"></script>

<script src="/correspondencia/gentelella/vendors/Flot/jquery.flot.pie.js"></script>

<script src="/correspondencia/gentelella/vendors/Flot/jquery.flot.time.js"></script>

<script src="/correspondencia/gentelella/vendors/Flot/jquery.flot.stack.js"></script>

<script src="/correspondencia/gentelella/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="/correspondencia/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>

<script src="/correspondencia/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>

<script src="/correspondencia/gentelella/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="/correspondencia/gentelella/vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="/correspondencia/gentelella/vendors/jqvmap/dist/jquery.vmap.js"></script>

<script src="/correspondencia/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

<script src="/correspondencia/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<?php Yii::app()->clientScript->registerScriptFile('/correspondencia/static/js/moment.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/correspondencia/static/vis/dist/vis.js'); ?>
<!--<script src="/correspondencia/static/js/jquery.datetimepicker.js"></script>-->
<!--<script src="/correspondencia/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>-->
<!-- Custom Theme Scripts -->
<script src="/correspondencia/gentelella/build/js/custom.js"></script>
<script>
$( document ).ready(function() {
    $('#consulta_autocomplete').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
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
    $("#modal-consulta").modal("show");
});
$("#consulta_data").click(function(){
    var data = $("#consulta_autocomplete").val();
    if(data != ""){
        <?php echo CHtml::ajax(
        array(
              'type' => 'POST',
              'data' => array('data' => 'js:data'),
              'url' => $this->createUrl("recepcion/valida"),
              'success' => 'function(res){
                if(res){
                    $("#consulta_autocomplete").val("");
                    location.href="http:/correspondencia/index.php/trazabilidad/index?na="+res;
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
