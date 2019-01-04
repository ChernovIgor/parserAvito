<?php
 require_once '../login.php';

 $numPage = $_GET['page']; //получение страницы

 $countRow = 10; //вывод по countRow страниц
 $firstRow = ($numPage - 1) * ($countRow + 1) ;
 $lastRow = $firstRow + $countRow;

 $query = 'SELECT  kom, ob, prcDivMetr, floar, Allfloar, address, tel FROM memory WHERE tel IS NOT NULL';

 $dbh= new PDO($dbcon, $login, $pass);
 //включить проверку от ошибок
 
 //'SELECT * FROM memory LIMIT '
/* for($i=1; $i<5;$i++) {
   $firstRow = ($i - 1) * ($countRow+1) ;
   $lastRow = $firstRow + $countRow  ;
   echo $firstRow; echo " "; echo $lastRow; echo "<br>";
 } */

?>
