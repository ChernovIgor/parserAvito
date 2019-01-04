<?php


abstract class Flat {
  protected $kom;
  protected $link;
  protected $price;
  protected $oldPrice;
  protected $param; // 0-норм, 1-упала цена, 2-новое, 3-чс, 4 - удалено
  protected $ob;
  protected $prcDivMetr;
  
 
  
  abstract public function get();
   
  public function getParam(){
      return $this->param;
  }
  //получение цены за метр
  public function getPrcDivMetr(){
     return $this->prcDivMetr;
  }
      
  //есть ли элемент в черном списке
  protected function ifInBl($dbh) {
      $stm = $dbh->prepare('SELECT link FROM blackList WHERE link=?'); //существует ли элемент
      $stm->execute(array($this->link));
      $l = $stm->fetch();
      if ($l==false) { 
          return false;   
      } else {
          $this->param = 3; // есть черном списоке
          return true; 
      }
    }
  
  // основная функция задание парамтра статуса объекту
    abstract public function setStatus($dbh);

}

class FlatAvito extends Flat {
    
    private $floar;
    private $allfloar;
    private $time;
    private $address;
    
       //задание параметров
    function __construct($kom, $ob, $floar, $allfloar,$link, $price, $time,$address) {
       $this->kom = $kom;
       $this->ob = $ob;
       $this->floar = $floar;
       $this->allfloar = $allfloar;
       $this->link = $link;
       $this->price = $price;
       $this->prcDivMetr = round((float)$this->price/(float)$this->ob);
       $this->time= $time;
       $this->address=$address;
       $this->param = 0; // 0-норм, 1-упала цена, 2-новое, 3-чс, 4- удалено
       $this->oldPrice = 0;
    }
    
       // вывод объекта в виде массива
    public function get(){
        $a = array();
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
        return $a;
    }
    
       public function setStatus($dbh) { 
   
        if($this->ifInBl($dbh)==false){ // элемент в чс?
        
            $stm = $dbh->prepare('SELECT link, prcDivMetr FROM memory WHERE link=?'); //существует ли элемент
            $stm->execute(array($this->link));
            $l = $stm->fetch();
            
            //
            
            //если объект существует active=0
            if ($l!=false) {
                 $stm = $dbh->prepare('UPDATE memory SET active = ? WHERE link=?;'); //существует ли элемент
                 $stm->execute(array(0, $this->link));
           
                if((float)$l[1]>((float)$this->prcDivMetr + 2.3)) { //замена
                    $this->oldPrice = $l[1];
                    $this->param = 1 ; //упала цена
                    }
                } else if($l==null) {
          
                    $this->param = 2; // новое объявленик
                }
            
        }
    } 
}

class FlatYoula extends Flat {
    function __construct($kom, $ob, $link, $price) {
        $this->kom = $kom;
        $this->ob = $ob;
        $this->link = $link;
        $this->price = $price;
        $this->prcDivMetr = round((float)$this->price/(float)$this->ob);
        $this->param = 0; // 0-норм, 1-упала цена, 2-новое, 3-чс
        $this->oldPrice = 0;
    }
    
    public function get(){
        $a = array();
        $a[0] = $this->kom;
        $a[1] = $this->ob;
        $a[2] = $this->link;
        $a[3] = $this->price;
        $a[4] = $this->prcDivMetr;
        $a[5] = $this->param;
        $a[6] = $this->oldPrice;
        return $a;
    }
    
       public function setStatus($dbh) { 
   
        if($this->ifInBl($dbh)==false){ // элемент в чс?
        
            $stm = $dbh->prepare('SELECT link, prcDivMetr FROM memory WHERE link=?'); //существует ли элемент
            $stm->execute(array($this->link));
            $l = $stm->fetch();
            
            //
            
            //если объект существует active=0
            if ($l!=false) {
                 $stm = $dbh->prepare('UPDATE memory SET active = ? WHERE link=?;'); //существует ли элемент
                 $stm->execute(array(2, $this->link));
           
                if((float)$l[1]>((float)$this->prcDivMetr + 2.3)) { //замена
                    $this->oldPrice = $l[1];
                    $this->param = 1 ; //упала цена
                    }
                } else if($l==null) {
          
                    $this->param = 2; // новое объявленик
                }
            
        }
    } 
}