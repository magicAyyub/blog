<?php
namespace App;

require_once('Model.php');

class Category extends Model{
    protected $db;
    protected $table_name = "categories";
    protected $field_id = "id";
    protected $field_title = "title";
    protected $field_description = "description";
    protected $field = "category_id";
       
    public function categoriesByOrder()
    {
        $database_class = $this->db;
        $field__title = $this->field_title;
        $table = $this->table_name;
        $category = $database_class->selectOrder("$table","ORDER BY $field__title");
        return($category);
    }

    public function updateCategoryID($id)
    {
        $database_class = $this->db;
        $table = "posts";
        $field_to_update = $this->field;
        $updateID = $database_class->updateField($table,"$field_to_update = 5","$field_to_update = $id");
        return($updateID);
    }
}

