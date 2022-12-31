<?php
namespace App;

require_once('Database.php');

abstract class Model{
    protected $db;
    protected $table_name = null;
    protected $field_id = null;
    protected $field_name = null;
    protected $field_email = null; 
    protected $field_title = null;
    protected $join_table_name = null;
    protected $field = null;
    

    public function __construct()
    {
        $this->db = new Database();
    }

    public function add(array $data)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $insert = $database_class->create("$table",$data);
        return($insert);
    }

    public function update( array $values, ?string $id = '?')
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $field__id = $this->field_id;
        $update = $database_class->update("$table",$values, "$field__id = $id LIMIT 1");
        return $update;
    }

    public function delete(string $id)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $field__id = $this->field_id;
        $delete = $database_class->delete("$table","$field__id = $id");
        return $delete;
    }

    public function findOne(string $id)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $field__id = $this->field_id;
        $row = $database_class->selectOne("$table","$field__id = $id");
        return($row);
    }


    public function findOrder(string $by){
        $database_class = $this->db;
        $table = $this->table_name;
        $rows = $database_class->selectOrder("$table","ORDER BY $by");
        return($rows);
    }

    public function findJoin(array $data, string $id)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $joinTable = $this->join_table_name;

        $join = $database_class->selectJoin("$table","$joinTable",$data,"{$table}.user_id = {$joinTable}.id","{$table}.user_id=$id","ORDER BY {$table}.id DESC");
        return $join;
        
    }
     
    public function dataAlreadyExist(string $username, string $email)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $field__email = $this->field_email;
        $field__name = $this->field_name;
        $is_in_table = $database_class->alredyInDatabase("$table","$field__name = '$username'","$field__email = '$email'");
        return($is_in_table);
    }
}