<?php

/*
 * Автоматическое добавление телефонов
 */
 require_once 'login.php';  
 require_once 'getPhone.php';
 
 $phone = new getPhone();
 $dbh = new PDO($dbcon, $login , $pass);
 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 $q = 'SELECT link FROM memory WHERE tel IS NULL AND active!=2';

foreach ($dbh->query($q) as $row) {
  $imgPhone =  $phone->getJsonPhone($row['link']);
  $stm = $dbh->prepare('UPDATE memory SET tel = ? WHERE link=?');
  $stm->execute(array($imgPhone, $row['link']));
  sleep(20);
} 