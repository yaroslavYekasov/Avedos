<?php
$kasutaja='yaroslavyekasov';
$serverinimi='localhost';
$parool='123456';
$andmebaas='yaroslavyekasov';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');