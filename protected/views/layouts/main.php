<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSS Global Compulsory-->
    <?php Yii::app()->clientScript->registerCssFile('/static/plugins/bootstrap/css/bootstrap.min.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile('/static/plugins/bootstrap/css/bootstrap.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile('/static/css/style.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile('/static/css/headers/header1.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile('/static/css/responsive.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile('/static/css/meny.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile('/static/css/jquery.datetimepicker.css'); ?>

    <!-- CSS Implementing Plugins -->    
    <?php Yii::app()->clientScript->registerCssFile('/static/plugins/font-awesome/css/font-awesome.css'); ?>
    <!-- CSS Style Page -->    
    <?php Yii::app()->clientScript->registerCssFile('/static/css/pages/page_log_reg_v1.css'); ?>  
    <!-- CSS Theme -->    
   <?php Yii::app()->clientScript->registerCssFile('/static/css/themes/blue.css'); ?>
   <?php Yii::app()->clientScript->registerCssFile('/static/css/themes/headers/header1-blue.css'); ?>

   <?php Yii::app()->clientScript->registerScriptFile('/static/js/meny.js'); ?>
   <?php Yii::app()->clientScript->registerScriptFile('/static/js/app.js'); ?>
   <?php Yii::app()->clientScript->registerScriptFile('/static/js/jquery.datetimepicker.js'); ?>
   <?php Yii::app()->clientScript->registerScriptFile('/static/js/bootstrap.js'); ?>

    <!--[if lt IE 9]>
        <?php Yii::app()->clientScript->registerScriptFile('/static/js/respond.js'); ?>
    <![endif]-->
 

</head> 


<body>

<!--=== Meny ===-->
<div class="meny">
    <button onclick="mymodal.close()" class="btn-u btn-u-md btn-u-red pull-right margin-bottom-40"><i class="icon-cloud-download"></i> Cerrar</button>

    <div id="meny-content">

        
    </div>
</div>
<!--=== Meny ===-->
 
<div id="content">

<!--=== Top ===-->    
<div class="top">
    <div class="container">         
      
    </div>      
</div><!--/top-->
<!--=== End Top ===-->    
<!--=== Header ===-->    
<div class="header">
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">
                    <img src="/images/logo-clinica-sandiego.png"  />
                </a>
            </div>
            <?php if(!Yii::app()->user->isGuest): ?>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav navbar-right">
                   
<!--                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                            Informes
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php // echo $this->createUrl("informeViajes/todos");?>">Todos los viajes</a></li>
                        </ul>
                    </li>-->
                   
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                            Configuracion
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $this->createUrl("/citas/disponibilidad/admin");?>">Disponibilidad</a></li>
                            <li><a href="<?php echo $this->createUrl("/administracion/documentos/admin");?>">Documentos</a></li>
                            <li><a href="<?php echo $this->createUrl("/paciente/paciente/admin");?>">Paciente</a></li>
                            
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                            <?php echo Yii::app()->user->name; ?>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $this->createUrl('/site/logout'); ?>">Logout</a></li>
                            
                        </ul>
                    </li>                    
                </ul>
                <div class="search-open">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button class="btn-u" type="button">Go</button>
                        </span>
                    </div><!-- /input-group -->
                </div>                
            </div><!-- /navbar-collapse -->
            <?php endif ?>
        </div>    
    </div>    
</div><!--/header-->

<!--=== End Header ===-->    

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-40">
    <div class="container">
        <h1 class="pull-left"><?php echo $this->pageTitle;?></h1>
        <ul class="pull-right breadcrumb">

            <?php if(isset($this->breadcrumbs)):?>
                <?php $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
                    'links'=>$this->breadcrumbs,
                )); ?><!-- breadcrumbs -->
            <?php endif?>
        </ul>
    </div><!--/container-->

</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->



<!--=== Content Part ===-->
<div class="container">	
    <?php echo $content; ?>	
</div><!--/container-->		
<!--=== End Content Part ===-->

</div>
<script>
    var mymodal = viajes.MyModal.create({
        element: document.querySelector( '.meny' )
    });
    mymodal.configure();
    App.init();
</script>

<?php
        /*
         * if ajax call and session has expired, then redirect to user/login
         */
        
            Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
            jQuery("body").ajaxComplete(
                function(event, request, options) {
                    if (request.responseText == "' . Yii::app()->components['user']->loginRequiredAjaxResponse . '") {
                        window.location.href = "'.Yii::app()->createUrl('/site/login').'";
                    }
                }
            );
        ');
 ?>

</body>

</html>
