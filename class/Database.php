<?php

namespace App;

class Database
{
    /* -------------------------
        DATABASE CONNEXION DATA  
    ------------------------- */  

    private $host = "localhost";
    private $username = "root";
    private $password = "root";
    private $dbname = "blog_db";



    /* ------------------------
        CONNEXION TO DATABASE  
    ---------------------------*/ 

    private static $instance = null;
    private function connect()
    {
        if(self::$instance === null){
            $conn = new \PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8;",$this->username,$this->password);
            
            if($conn){
                return $conn;
            }else{
                die('connexion impossible !');
            }
        }   else{
                return self::$instance;
        }
    }




    /* --------------------
        ADD DATA TO TABLE  
    ----------------------- */    

    public function repeatChar(string $char, int $repeatNumber):string{
        $newString = '';
        for($i=0;$i<$repeatNumber;$i++){
            if ($i != ($repeatNumber-1)) {
                $newString.= "$char,";
            } else {
                $newString.= "$char";
            }
        }
        return $newString;

    }
    public function create(string $table,array $values = []):bool{

        // connexion
        $conn = $this->connect();

        // INTO part of INSERT
        $values_key = array_keys($values);  // [clé1, clé2, clé3...]
        $INTO = implode(',', $values_key);  // clé1, clé2, clé3... 
        
        // VALUES part of INSERT
        $VALUES = array_values($values);  // [valeur1, valeur2,...]

        $len_values = count($VALUES); // longueur du tableau (1,8,12...)   

        // INSERT query 
        $chars = $this->repeatChar("?",$len_values); // ?,?,?...
        $insert = $conn->prepare("INSERT INTO `$table`($INTO) VALUES($chars)");

        return $insert->execute($VALUES);
    }



    /* ----------------------------
        SELECT ALL DATA FROM TABLE  
    ------------------------------- */
    
    public function selectAll(string $table, string $where = ''):array
    {
        // connexion
        $conn = $this->connect();

        // select query
        if($where == ''){
            $select = $conn->prepare("SELECT * FROM $table");
            $select->execute(); 
        }else{
            $select = $conn->prepare("SELECT * FROM $table WHERE $where");
            $select->execute();
        }
        
        // fetch data 
        if($select){
            $tables_elements = $select->fetchAll(\PDO::FETCH_ASSOC);
            return $tables_elements;
        }else{
            exit('select n\'a pas marché');
        }
    }

    public function selectJoin(string $table1, string $table2, array $join_elements, string $ON, string $where = '', string $order = '')
    {

        // connexion
        $conn = $this->connect();

        // left part of ON in JOIN query
        $beforON = '';
        $len_values = count($join_elements); // longueur du tableau
        $i = 1;

        foreach($join_elements as $element){

            if($i != $len_values){
                $beforON .= "{$table1}.{$element}, ";
            } else{
                $beforON .= "{$table1}.{$element}";
            }
            $i+=1; 

        }   //  >>> posts.id, posts.title...

        // join query
        if($where == '' && $order == ''){
            $join =  $conn->prepare("SELECT $beforON FROM $table1 JOIN $table2 ON $ON");
            $join->execute();
        }elseif($where == '' && $order != ''){
            $join =  $conn->prepare("SELECT $beforON FROM $table1 JOIN $table2 ON $ON WHERE $where");
            $join->execute();
        }
        else{
            $join =  $conn->prepare("SELECT $beforON FROM $table1 JOIN $table2 ON $ON WHERE $where $order");
            $join->execute();
        }

        return $join;

    
    }
    

    /* ------------------------------
        SELECT ONE DATA FROM TABLE   
    --------------------------------- */
    
    public function selectOne(string $table, string $where1 = '', string $where2 = '')
    {
        // connexion
        $conn = $this->connect();

        // select query
        if($where1 == '' && $where2 == ''){
            $select = $conn->prepare("SELECT * FROM `$table`");
            $select->execute(); 
        }elseif($where2 == ''){
            $select = $conn->prepare("SELECT * FROM `$table` WHERE $where1");
            $select->execute();
        }else{
            $select = $conn->prepare("SELECT * FROM `$table` WHERE $where1 OR $where2");
            $select->execute();
        }
        
        if($select){
            $element = $select->fetch(\PDO::FETCH_ASSOC);
            return($element);
        }
    }


     /* ------------------------------
        SELECT A DATA FROM ONE FIELD   
    --------------------------------- */

    public function selectField(string $table, string $field, string $where1 = '', string $where2 = '')
    {
        // connexion
        $conn = $this->connect();
        
        // select query
        if($where1 == '' && $where2 == ''){
            $select = $conn->prepare("SELECT $field FROM `$table`");
            $select->execute(); 
        }elseif($where2 == ''){
            $select = $conn->prepare("SELECT $field FROM $table WHERE $where1");
            $select->execute();
        }else{
            $select = $conn->prepare("SELECT $field FROM $table WHERE $where1 OR $where2");
            $select->execute();
        }
        
        if($select){
            $element = $select->fetchAll(\PDO::FETCH_ASSOC);
            return($element);
        }
    }

    /* ------------------
        SELECT BY ORDER 
    --------------------- */
    public function selectOrder(string $table,  string $order = ''):array
    {
        // connexion
        $conn = $this->connect();

        // select query
        if($order == ''){
            $select = $conn->prepare("SELECT * FROM $table");
            $select->execute(); 
        }else{
            $select = $conn->prepare("SELECT * FROM $table $order");
            $select->execute(); 
        }
        
        // fetch data 
        if($select){
            $element = $select->fetchAll(\PDO::FETCH_ASSOC);
            return($element);
        }
    }


    /* -------------------------
        UPDATE DATA IN TABLE 
     --------------------------- */

    public function update(string $table, array $values = [], string $where = ''):object
    {

        // connexion
        $conn = $this->connect();

        // SET part of UPDATE query
        $SET = '';
        $SET_KEY = array_keys($values);
        $SET_VALUE = array_values($values);
        $len_values = count($values); // longueur du tableau
        $i = 1;

        foreach($SET_KEY as $key){

            if($i != $len_values){
                $SET .= "$key = ?, ";
            } else{
                $SET .= "$key = ?";
            }
            $i+=1; 

        }   //  >>> clé1 = ?, clé2 = ?,...

        // update query
        if($where == ''){
            $update = $conn->prepare("UPDATE `$table` SET $SET");
            $update->execute($SET_VALUE);
        }else{
            $update = $conn->prepare("UPDATE `$table` SET $SET WHERE $where");
            $update->execute($SET_VALUE);
        }

        return $update;
    }

    /* -------------------------
        UPDATE ONE FIELD IN TABLE 
     --------------------------- */

    public function updateField(string $table, string $SET, string $where = '' )
    {
         // connexion
         $conn = $this->connect();

         if($where == ''){
            $update = $conn->prepare("UPDATE `$table` SET $SET");
            $update->execute();
         }
         else{
            $update = $conn->prepare("UPDATE `$table` SET $SET WHERE $where");
            $update->execute();
         }

    }


    /* -----------------------
        DELETE DATA IN TABLE 
     ------------------------- */

     public function delete(string $table, string $where = ''):object
     {

        // connexion
        $conn = $this->connect();

        // suppression
        if($where == ''){
            $delete = $conn->prepare("DELETE FROM $table");
            $delete->execute();
        }else{
            $delete = $conn->prepare("DELETE FROM $table WHERE $where");
            $delete->execute();
        }
        return $delete;
     }


    /* ---------------------------------------- 
        CHECK IF DATA IS ALREADY IN DATABASE 
    ------------------------------------------- */

     public function alredyInDatabase(string $table, string $where1 = "", string $where2 = ""):bool
     {
        
        // connexion
        $conn = $this->connect();

        // vérification
        if($where2 == ""){
            $select = $conn->prepare("SELECT * FROM $table WHERE $where1");
            $select->execute();   
        }else{
            $select = $conn->prepare("SELECT * FROM $table WHERE $where1 OR $where2");
            $select->execute(); 
        }
        if($select->rowCount() > 0){
            return(true);
        }else{
            return(false);
        }
     }



     /* --------------------------- 
            COUNT ROWS IN A TABLE  
        --------------------------- */

     public function TableRow(string $table, string $where = ''):int
     {
        
        // connexion
        $conn = $this->connect();
        
        if($where == ''){
            $select = $conn->prepare("SELECT * FROM $table");
            $select->execute();  
        } else{
            $select = $conn->prepare("SELECT * FROM $table WHERE $where");
            $select->execute();  
        }

        if($select){
            return($select->rowCount());
        }
     }

     /* -------------------------- 
         SEARCH DATA IN DATABASE
     ---------------------------- */

            public function search(string $table, string $like, string $where = '',$order):array
            {
                // connexion
                $conn = $this->connect();
        
                // sélection
                if($where == '' && $order == ''){
                    $select = $conn->prepare("SELECT * FROM `$table` $like");
                    $select->execute(); 
                }elseif($where == '' && $order != ''){
                    $select = $conn->prepare("SELECT * FROM `$table` $like $order");
                    $select->execute();
                }elseif($where != '' && $order == ''){
                    $select = $conn->prepare("SELECT * FROM `$table` WHERE $where $like");
                    $select->execute();
                } else{
                    $select = $conn->prepare("SELECT * FROM `$table` WHERE $where $like $order");
                    $select->execute();
                }
                
                // tableau associatif 
                if($select){
                    $tables_elements = $select->fetchAll(\PDO::FETCH_ASSOC);
                    return $tables_elements;
                }else{
                    exit('select n\'a pas marché');
                }
            }
}
?>