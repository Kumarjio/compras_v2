<?php
//echo phpinfo();
$na = "123";
$path = "/vol2/img04/arp/".date("Ymd")."/".$na;

exec("mkdir -p /vol2/img04/arp/12/01/10/25 ", $resp, $salida);
echo 'Propietario script actual: ' . get_current_user();
print_r($resp);
print_r($salida);
echo "hola mundo";


?>
