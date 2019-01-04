<?php
require_once 'login.php';
require_once 'Model.php';
$param = 30000;
$city = 'salavat';
$url1 = 'https://www.avito.ru/' . $city . '/kvartiry/prodam/1-komnatnye?s=1&view=list';
$url2 = 'https://www.avito.ru/' . $city . '/kvartiry/prodam/2-komnatnye?s=1&view=list';
$url3 = 'https://www.avito.ru/' . $city . '/kvartiry/prodam/3-komnatnye?s=1&view=list';

$ptrn = array();
 // 1-ссылка 2-комнатность
$ptrn[0] = '/class="description-title-link"\s*id="\d*"\s*itemprop="url"\s*href="(\/' . $city . '\/kvartiry\/(\d*)-k_kvartira_\d*.*\d*_m_\d*_et._\d*)"/';
$ptrn[1] = '/<div class="param area">\s?(\d*.?\d*)\s?м²<\/div>/'; //площадь
$ptrn[2] = '/<p\s*itemprop\s*=\s*"price"\s*content="(\d*)">/'; // цена
$ptrn[3] = '/<div class="param address">\s*<div class="fader">\s([\d|\D|\s?]*)\s<\/div>/U'; //адрес
$ptrn[4] = '/<div\s*class\s*=\s*"\s*param\s*floor\s*"\s*>\s*(\d*)\/(\d*)\s*эт.\s*<\/div>/'; // этаж этажность
$ptrn[5] = '/<span class="date">\s*(\d*\s*\S*&nbsp;\d\d:\d\d)\s*<\/span>/'; //может быть U поставить

$m = new ModelAvito($login,$pass, $dbcon, $ptrn, $param);     
$m->getData($url1,3);
$m->getData($url2,3);
$m->getData($url3,2);  
    
$m->OutData();
$m->OutDelObject();
echo $m->Out();
// добавать удаленные объявления т е те которые имеют active 2
