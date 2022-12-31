<?php

namespace App;

require_once('Model.php');

class Users extends Model{
    protected $table_name = "users";
    protected $field_id = "id";
    protected $field_name = "username";
    protected $field_email = "email"; 
    protected $field = "thumbnail";
      
    public function loginPassword( string $username, string $email)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $field__email = $this->field_email;
        $field__name = $this->field_name;
        $signin = $database_class->selectOne("$table","$field__name = '$username'","$field__email = '$email'");
        return($signin);
    } 
    

    public function findAll(string $id)
    {
        $database_class = $this->db;
        $field__id = $this->field_id;
        $table = $this->table_name;
        $users = $database_class->selectAll("$table","NOT $field__id = $id");
        return($users);
    }

    public function numberUser(string $id)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $field__id = $this->field_id;
        $is_empty = $database_class->TableRow("$table","NOT $field__id = $id");
        return($is_empty);
    }

    public function thumbnail_delete($id)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $thumbnail_to_delete = $this->field;
        $delete = $database_class->selectField($table,$thumbnail_to_delete,"user_id=$id");  
        return($delete);
    }

}



