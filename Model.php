<?php
require_once 'Flat.php';

abstract class Model {
    protected $ma = array(); //массив квартир
    protected $user; //логин к базе
    protected $pass; //пароль к базе
    protected $url; // к авито
    protected $dbh; // класс базы
    protected $ptrn; //массив паттернов
    protected $mIgor=array();
    
    const numPrcDivMetr=null;
    
  public function __construct($user,$pass, $dbcon, $ptrn,$param) {    
     $this->user = $user;
     $this->pass= $pass; 
     $this->url;
     $this->ptrn = $ptrn;
     $this->param= $param;
     
     // в каждом случае своя база
     $this->dbh= new PDO($dbcon, $user, $pass);
    }
    
   protected function condition($param, $a) {
        if ($a->getPrcDivMetr()<$param) {
            return true;
        } else {
            return false;
        }
         
    }
    
  //добавлеят массив Floats в поле класса (в случае машин он должен быть переопределенным
  abstract protected function addArrayFloats($matches);
  
  abstract protected function urlP($url,$p);
  
   //получение парс данных со страницы
    protected function getDataPage($page) {
       
       $urlPage = $this->urlP($this->url,$page);
       $n = count($this->ptrn);
       $matches = array();
       
       $html = file_get_contents($urlPage);
        
       for($i=0; $i<$n; $i++) { //извлекает элементы
            $matches[$i] = array(); 
            preg_match_all($this->ptrn[$i], $html, $matches[$i]);
       }
      
       $this->addArrayFloats($matches);//добавляет их в массив
    }
  // цикл парсинга страниц
    public function getData($url, $countPage) {
         $this->url = $url ;
         
        for($i=1;$i<=$countPage;$i++) {
            $this->getDataPage($i);
        }
    }
    
    //вывод данных в формате json
    public function OutData() {
          
        $n=count($this->ma);
        
        for($i=0; $i<$n;$i++) {
                
          
          if ($this->condition($this->param, $this->ma[$i])==true)
           {
                array_push($this->mIgor,$this->ma[$i]->get());
           }
        }
    }
    //выводит только измененные объекты
    public function OutChangeData() {
        
        $n=count($this->ma);
        
        for($i=0; $i<$n;$i++) {
                  $p = $this->ma[$i]->getParam();
          if ($this->condition($this->param, $this->ma[$i])==true && $this->ParamChange($p))
           {
                array_push($this->mIgor,$this->ma[$i]->get());
           }
        }
    }
    //вывод страницы
    public function out() {
       $this->sort($this->numPrcDivMetr); //сортировка
       return json_encode($this->mIgor);
    }
    

    // сортировка удаленных объявлений //6 столбец
    private function sort($numCollumn) {
        
        $n = count($this->mIgor);
        
        for($i=$n-1; 0<$i; $i--) {
            for($j=0; $j<$i; $j++){//$k-$i-1
               $a = $this->mIgor[$j]; $b = $this->mIgor[$j+1];
            // $trs=  $this->numCollumn;
                if ($a[$numCollumn]>$b[$numCollumn]) {
                    
                   $c = $this->mIgor[$j];
                   $this->mIgor[$j] = $this->mIgor[$j+1];
                   $this->mIgor[$j+1] = $c;
                }
            }
        }
    } 
    
    // Вывод удаленных объектов
    abstract public function OutDelObject();
    
   
    
   
    
    
    public function OutDataMail() {
        
        $this->sortirovka();
        
       $n=count($this->ma);
       $m=array();
        
       for($i=0; $i<$n;$i++) {
            
            
        if($this->interesting($this->ma[$i])==true)
           {
             array_push($m, $this->ma[$i]->get());
           }
        }
        
        return $m;
    }
}

 class ModelAvito extends Model {
     //получение массива парсированных данных
  
    protected $numPrcDivMetr = 6;
     protected function addArrayFloats($matches) {
               // $kom, $ob, $floar, $allfloar,$link, $price, $time, $address
     $m0 = $matches[0]; //kom
     $m1 = $matches[1]; //ob,
     $m2 = $matches[2]; //floar link
     $m3 = $matches[3]; //
     $m4 = $matches[4]; //
     $m5 = $matches[5]; //         
     
     //получение элементов
     $n = min(count($m0[0]), count($m1[0]), count($m2[0]), count($m3[0]), count($m4[0]), count($m5[0]));
       
     for($i=0;$i<$n;$i++){
           
        $link = 'https://avito.ru' . (string)$m0[1][$i];
        $kom = $m0[2][$i];  
        $ob = $m1[1][$i];
        $price = $m2[1][$i];
        $address = $m3[1][$i];
        $floar = $m4[1][$i];
        $allfloar = $m4[2][$i];
        $time = $m5[1][$i];
           
        $a=new FlatAvito($kom,$ob,$floar,$allfloar,$link,$price,$time,$address);
        $a->setStatus($this->dbh);
        array_push($this->ma, $a);         
     }
     }
     protected function urlP($url,$p){
         return $url . '&p=' . $p; 
     }
     
      public function OutDelObject() {
        $sql = 'SELECT kom, ob, floar, Allfloar, link, prcDivMetr, address, tel FROM memory WHERE active=1';
        
        foreach ($this->dbh->query($sql) as $row) {
            $a = array();
            $a[0] = $row['kom'];
            $a[1] = $row['ob'];
            $a[2] = $row['floar'];
            $a[3] = $row['Allfloar'];
            $a[4] = $row['link'];
            $a[5] = round((float)$row['ob'] * (float)$row['prcDivMetr']);
            $a[6] = $row['prcDivMetr'];
            $a[7] = "<img   src=\"{$row['tel']}\" height=\"20\" width=\"80\">";
            $a[8] = $row['address'];
            $a[9] = 4;
            $a[10] = 0;
            array_push($this->mIgor, $a);   
        }
        $this->dbh->exec("UPDATE memory SET active = 1 WHERE active=0;");
    }
 }
 
 class ModelYoula extends Model {
     protected  $numPrcDivMetr = 4;  
     
     protected function addArrayFloats($matches) {
        $m0 = $matches[0];
        $m1 = $matches[1];
        $m2 = $matches[2];
       
                //$kom, $ob, $link, $price
        $n = min(count($m0[0]), count($m1[0]), count($m2[0]));
        
        for($i=0;$i<$n;$i++){  
            $link = 'https://youla.ru' . (string)$m1[1][$i];
            $kom = $m0[1][$i];  
            $ob = $m0[3][$i];
            $price = $m2[1][$i];
                   //$kom, $ob, $link, $price
           
            $a=new FlatYoula($kom,$ob, $link, $price);
            $a->setStatus($this->dbh);
            array_push($this->ma, $a);         
        }
    }
        
     
     
     protected function urlP($url,$p){
         return $url . '&page=' . $p; 
     }
     
     public function OutDelObject() {
         return 0;
     }
     
     }
