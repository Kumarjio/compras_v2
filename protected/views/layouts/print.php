<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<?php Yii::app()->clientScript->registerCssFile('/css/efectividad.css'); ?>
  	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/fileuploader.css'); ?>

	<title>Solicitud de compra</title>
</head>

<body>

<div class="container" id="page">

	<?php echo $content; ?>

	<div class="clear"></div>
	
</div><!-- page -->

</body>
</html>
