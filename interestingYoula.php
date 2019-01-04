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
$itogArr = $youla->OutDataMail();

        // формарование таблички с письмом
      $str = ''; 
      for($i=0;$i<count($itogArr);$i++){
          $a = $itogArr[$i];
          
          $s='<tr>';
          for($j=0;$j<6;$j++) {
            if($j==2) {
                $s .= "<td><a href=\"{$a[$j]}\" target=\"_blank\">ссылка</a></td>";
            } else {
                $s .= "<td>{$a[$j]}</td>";
            }
          }
            $str .= $s . '</tr>'; 
      } 
$message =<<<EOT
      <html>
        <head>
            <meta charset="UTF-8">
        </head>
        <body>
            <table border="1" style="border-collapse=collapse">
                <tr>
                    <th>Ком</th>
                    <th>Об</th>
                    <th>ссылка</th>
                    <th>цена</th>
                    <th>метр</th>
                    <th>par</th>
                </tr>
                {$str}
            </table>
        </body>
      </html>
EOT;
        
                
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= "Content-type: text/html; charset=utf-8 \r\n";
        
/*    if ($str!=''){
     mail('chernowgoscha@yandex.ru','Tema' , $message,$headers);   
    }*/
      echo $message;
?>

