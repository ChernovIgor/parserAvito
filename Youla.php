<?php
require_once 'login.php';
require_once 'Model.php';

$url1= 'https://youla.ru/salavat/nedvijimost/prodaja-kvartiri?attributes[komnat_v_kvartire][0]=10654&attributes[realty_obshaya_ploshad][from]=10&attributes[realty_obshaya_ploshad][to]=2000&attributes[sort_field]=price';
$url2 = 'https://youla.ru/salavat/nedvijimost/prodaja-kvartiri?attributes[komnat_v_kvartire][0]=10655&attributes[realty_obshaya_ploshad][from]=10&attributes[realty_obshaya_ploshad][to]=2000&attributes[sort_field]=price';
$url3 = 'https://youla.ru/salavat/nedvijimost/prodaja-kvartiri?attributes[komnat_v_kvartire][0]=10656&attributes[realty_obshaya_ploshad][from]=10&attributes[realty_obshaya_ploshad][to]=2000&attributes[sort_field]=price';
$p = 4;
$param = 30000;
$ptrn = array();

$ptrn[0] ='/title="Квартира,\s*(\d*)\s*\S*,\s*(от)*\s*(\d+\.?\d*)/';
$ptrn[1] = '/href="(\/salavat\/nedvijimost\/prodaja-kvartiri\/\S*)"/U'; //link
$ptrn[2] = '/price&quot;:(\d*)00/'; // price

$youla= new ModelYoula($login,$pass, $dbcon, $ptrn, $param);
//$youla->getData($url,$p);
$youla->getData($url1,$p);
$youla->getData($url2,$p);
$youla->getData($url3,$p);
$youla->OutData();
echo $youla->Out();