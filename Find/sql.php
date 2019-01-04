<?php
/*
 * По адресу найти все данные об объевлении
 * Посмотреть какие объявления ушли и подчеркнуть из
 * 
 */
require_once 'login.php'; 

$dbh = new PDO($dbcon, $login , $pass);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stm = $dbh->prepare('SELECT address FROM memory WHERE address LIKE ? ');

$street = 'октябрьская';
$numHouse = '3';
$s = "%{$street}%{$numHouse}%";
$stm->execute(array($s));
$l = $stm->fetchAll();
print_r($l);

?>