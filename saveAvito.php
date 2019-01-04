<?php
 require_once 'login.php';  
 require_once 'getPhone.php';
   
 /*
     $a[0] = $this->kom;
        $a[1] = $this->ob;
        $a[2] = $this->floar;
        $a[3] = $this->allfloar;
        $a[4] = $this->link;
        $a[5] = $this->price;
        $a[6] = $this->prcDivMetr;
        $a[7] = $this->time;
        $a[8] = $this->address;
        $a[9] = $this->param;
        $a[10] = $this->oldPrice;
 */ 
 
 $a = json_decode($_POST['a']);
 
 $phone = new getPhone();
 $dbh = new PDO($dbcon, $login , $pass);
 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
 for($i=0; $i<count($a); $i++){
     $g= $a[$i];
 
     if($g[9]==2) { // новое объявление
         
         $imgPhone = $phone->getJsonPhone($g[4]);
         
         $stm = $dbh->prepare(
        'INSERT INTO memory(kom, ob, floar, allfloar, link, prcDivMetr, address, tel) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
         $stm->execute(array($g[0], $g[1], $g[2], $g[3], $g[4], $g[6], $g[8], $imgPhone));
      //   sleep(5); //поспать 1 секунду
        
     } else if ($g[9]==1) { //изменилась цена
        $stm = $dbh->prepare('UPDATE memory SET prcDivMetr = ? WHERE link=?');
        $stm->execute(array($g[6], $g[4]));
     } else if ($g[9]==4) { //удаленное объевление
        $stm = $dbh->prepare('UPDATE memory SET active = 2 WHERE link=?');
        $stm->execute(array($g[4]));
     }
     // в новом объявлении нужно сохранить номер телефона
 }
   
 echo "<b>Все сохранилось</b>";