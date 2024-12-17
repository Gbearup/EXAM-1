<?php

class DB{
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=db10";
    protected $pdo;
    protected $table;

    function __construct($table){
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,'root','');
    }

    /**
     * 撈出全部資料
     * 1. 整張資料表
     * 2. 有條件
     * 3. 其他SQL功能
     */
    function all(...$arg){
        $sql="SELECT * FROM $this->table ";
        if(!empty($arg[0])){
            if(is_array($arg[0])){

                $where=$this->a2s($arg[0]);
                $sql=$sql . " WHERE ". join(" && ",$where);
            }else{
                //$sql=$sql.$arg[0];  先取出 $sql 的現有值，然後將 $arg[0] 的值與 $sql 的現有值進行串接，最後，將串接後的結果重新賦值給 $sql。這樣，$sql 變數的值就會是原來的 $sql 加上 $arg[0] 的內容。
                /**這是一種簡化的寫法，稱為「串接賦值運算符」(concatenation assignment operator)。. 是 PHP 中的串接運算符，用於將兩個字符串連接起來。.= 則是 . 的賦值版本，它的作用是將右邊的值直接附加到左邊的變數上。*/
                $sql .= $arg[0];

            }
        }

        if(!empty($arg[1])){
            $sql=$sql . $arg[1];
        }

        return $this->fetchAll($sql);
    }

    function find($id){
        $sql="SELECT * FROM $this->table ";

        if(is_array($id)){
            $where=$this->a2s($id);
            $sql=$sql . " WHERE ". join(" && ",$where);
        }else{
            $sql .= " WHERE `id`='$id' ";
        }
        return $this->fetchOne($sql);
    }

    function save($array){

        if(isset($array['id'])){
            //update
            //update table set `欄位1`='值1',`欄位2`='值2' where `id`='值' 
            $id=$array['id'];
            unset($array['id']);
            $set=$this->a2s($array);
            $sql ="UPDATE $this->table SET ".join(',',$set)." where `id`='$id'";
                
        }else{
            //insert
            $cols=array_keys($array);
            $sql="INSERT INTO $this->table (`".join("`,`",$cols)."`) VALUES('".join("','",$array)."')";
        }
        
        //echo $sql;
        return $this->pdo->exec($sql);
    }
    
    function del($id){
        $sql="DELETE FROM $this->table ";

        if(is_array($id)){
            $where=$this->a2s($id);
            $sql=$sql . " WHERE ". join(" && ",$where);
        }else{
            $sql .= " WHERE `id`='$id' ";
        }

        //echo $sql;  
        return $this->pdo->exec($sql);
    }

    
    /**
     * 把陣列轉成條件字串陣列
     */
    function a2s($array){
        $tmp=[];
        foreach($array as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        return $tmp;
    }

    function max($col,$where=[]){
        return $this->math('max',$col,$where);
    }
    function sum($col,$where=[]){
        return $this->math('sum',$col,$where);
    }
    function min($col,$where=[]){
        return $this->math('min',$col,$where);
    }
    function avg($col,$where=[]){
        return $this->avg('avg',$col,$where);
    }
    function count($where=[]){
        return $this->math('count','*',$where);
    }

    /**
     * 取得單筆資料
     */
    protected function fetchOne($sql){
        //echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * 取得多筆資料
     */
    protected function fetchAll($sql){
        //echo $sql;
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * 方便使用各個聚合函式
     */
    
     protected function math($math,$col='id',$where=[]){
        $sql="SELECT $math($col) FROM $this->table";

        if(!empty($where)){
            $tmp=$this->a2s($where);
            $sql=$sql . " WHERE " . join(" && ", $tmp);
        }

        return $this->pdo->query($sql)->fetchColumn();
    }

}

function q($sql){
    $pdo=new PDO("mysql:host=localhost;charset=utf8;dbname=db10",'root','');
    return $pdo->query($sql)->fetchAll();
}

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function to($url){
    header("location:".$url);
}


$Title=new DB('titles');
$Ad=new DB('ads');
$Image=new DB('images');
$Mvim=new DB('mvims');
$News=new DB('news');
$Admin=new DB('admin');
$Menu=new DB('menus');
$Total=new DB('total');
$Bottom=new DB('bottom');