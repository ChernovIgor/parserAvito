<?php
require_once 'login.php';

$bl = $_POST['bl'];
$dbh = new PDO($dbcon , $login , $pass);

$q='INSERT INTO blackList(link) VALUES (?)';
$stm = $dbh->prepare($q);
foreach ($bl as $value) {
   $stm->execute(array($value));
}
//Чтобы в удаленных не показывало сообщение
$q='UPDATE memory SET active = 2 WHERE link=?';
$stm = $dbh->prepare($q);

foreach ($bl as $value) {
   $stm->execute(array($value));
}
 
echo "Все сохранилось";

?>

