<?php
 require_once 'login.php';  

    
 $a = json_decode($_POST['a']);
 
 $dbh = new PDO($dbcon, $login , $pass);
 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 for($i=0;$i<count($a);$i++){
     $g= $a[$i];
 
     if ($g[5]==2) {
        $stm = $dbh->prepare('INSERT INTO memory(kom, ob, link, prcDivMetr, active) VALUES (?, ?, ?, ?, ?)');
        $stm->execute(array($g[0],$g[1],$g[2], $g[4], 2)); // ссылка, цена за метр 
     } else if ($g[5]==1) {
        $stm = $dbh->prepare('UPDATE memory SET prcDivMetr = ? WHERE link=?');
        $stm->execute(array($g[4], $g[2]));
     }
 }
 
 echo "Все сохранилось";
