<?php
require_once 'getPhone.php';
require_once 'login.php';
$s = 'https://www.avito.ru/salavat/kvartiry/1-k_kvartira_39_m_89_et._1202594659';
$p = new getPhone();
$q = $p->getJsonPhone($s);
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>
         (Это title) Пример страницы на HTML5
      </title>
       
   </head>
   <body>
       <?php echo  strlen($q); ?>
     <img src="<?php echo $q ?>">
   </body>
</html>