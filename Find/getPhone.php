<?php
/*
 * Позволяет получить из авито номер телефона
 * и засунуть его в базу данных
 */
// сделать сохранение в базу данных телефона

class getPhone {
    private $link; // ссылка
    private $hKey; //хеш картинки 
    private $id; // id объекта
    private $img; //само изображение
    
    // получение id
    private function getId($link) {
        $maches = null;
        $ptrn = '/\d*$/';
        preg_match($ptrn, $link, $maches);
        return $maches[0];
    }

    //получение ключа
    private function getPkey($html) {
        $maches = null;
        $ptrn = '/data-pkey="(\S*)"/U';
        preg_match($ptrn, $html, $maches);
        return $maches[1];
    }
    
    // функция вывода отправки ключа и id  
   private function getIDAndKey() {
        $a = array();
        $id = $this->getId($this->link);
        $linkObject ='https://www.avito.ru/salavat/kvartiry/prodam?q=' . $id;
        $html = file_get_contents($linkObject);
        $pKey= $this->getPkey($html);
        $a['id'] = $id;
        $a['pkey'] = $pKey;
        return $a;
    }
    // функция получения хеша по ключу
    private function e($k,$id) {
        $matches = null;
        preg_match_all('/[0-9a-f]+/', $k, $matches);
        $match = $matches[0];
        $aa = ($id % 2 == 0 ? array_reverse($match) : $match);
        $a = implode($aa);
        $n = strlen($a);
        $i='';
        for($e=0; $e<$n; $e++){
            if ($e % 3 == 0) {
                $i .=  substr($a, $e, 1);
            }
        }
        return $i;
    }
    //public функции
    private function createUrlhKey(){
        return 'https://www.avito.ru/items/phone/' .  $this->id . '?pkey=' . $this->hKey .'&h=36&vsrc=s';
    }
    
    //получить и передать id и hKey объявлений
    private function gethKey() {
       $a = $this->getIDAndKey();
       
       $this->id = $a['id'];
       $this->hKey = $this->e($a['pkey'],$a['id']);
    }
    //получение картинки с номером телефона
    public function getJsonPhone($link) {
        $this->link = $link;
        
        $opts = array(
        'http'=>array(
            'method'=>"GET",
            'header'=>"Host: www.avito.ru\r\n" .
                "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0\r\n" .
                "Accept: */*\r\n" .
                "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3\r\n" .
                "Referer: https://www.avito.ru/salavat/kvartiry/prodam\r\n" .
                "origin: https://www.avito.ru\r\n" .
                "Connection: keep-alive\r\n" .
                "Pragma: no-cache\r\n" .
                "Cache-Control: no-cache\r\n" .
                "Cache-Control: no-cache\r\n" .
                "TE: Trailers\r\n"
        )
        );
        
        $context = stream_context_create($opts); //формерование заголовка запроса
        $this->gethKey();
        $url = $this->createUrlhKey();
        $ans =  file_get_contents($url, false, $context); //отправка запроса
        
        $q = json_decode($ans); //декодирование ответа
        $this->img = $q->image64;
        return $this->img;
    }
    
 
    
    
}
