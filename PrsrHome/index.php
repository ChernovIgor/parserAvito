<?php
/*
 * новой планировки
   1 комн. — 33-47кв.м. (очень редко 29 кв.м.)
   2 комн. — 48-58 кв.м.
   3 комн. — 64-73 кв.м.
   4 комн. — 77-86 кв.м.
 * 
 * ленинградки
 *  1 комн. - 32-36 кв.м.
    2 комн. - 45-49 кв.м.
    3 комн. - 60-68 кв.м.
    4 комн. - 78-85 кв.м.

 */

// запрос на серию постройки 
       $ptrn = '/<dt>Серия, тип постройки<\/dt>\s*<dd>([\d|\D]*)<\/dd>/U';
       $p = 'http://localhost/PAvito/BigData/rewriteClass/PrsrHome/houses1.json';
 $a = json_decode(file_get_contents($p)); // преобразование
 $b = $a->rows;
// $c = $b[0];
//print_r($c['address']); 
 //$b->address
//print_r($b[0]);
 foreach ($b as $value) {
     $ptrn1 = '/[ул|б-р|пр-кт]. (\S*), д. (\S*\s?\S*),/';
     preg_match($ptrn1 ,$value->address,$m);
     echo "{$value->rownumber}  {$value->address}  <b>ул.</b> $m[1]  <b>Дом</b> $m[2] <br>";
  
 }
//for($i=0;)
// echo "<br>Адрес {$b->address} <br>Год {$b->year} <br> Этажность {$b->floors} <br> Ссылка {$b->url} <br> ";
 
