<?php
$user = Yii::app()->getComponent('user');
$user->setFlash(
    'success',
    "<strong>Well done!</strong> You're successful in reading this."
);

?>

<div class="alert in fade alert-success">
	<strong>Atención! </strong>
	<p>
Acá va a adjuntar los documentos.
</p>
	</div>