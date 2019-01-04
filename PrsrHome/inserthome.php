<?php 
require_once '../login.php';

$dbh = new PDO($dbcon , $login , $pass);
$value = array();
$value[0] = $_POST['street'];
$value[1] = $_POST['nHome'];
$value[2] = $_POST['type'];
$value[3] = $_POST['year'];

$q='INSERT INTO homes (street, home, type, year) VALUES (?, ?, ?, ?)';
$stm = $dbh->prepare($q);
$stm->execute(array($value));
header("Location: BigData/rewriteClass/PrsrHome/insertHome.html");