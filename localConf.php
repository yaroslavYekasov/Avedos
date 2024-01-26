<?php
$kasutaja='Admin';
$serverinimi='localhost';
$parool='123123';
$andmebaas='avedos';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');