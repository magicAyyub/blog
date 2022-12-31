<?php

namespace App;

require_once('Model.php');

class Posts extends Model{

    protected $table_name = "posts";
    protected $field_id = "id";
    protected $field_title = "title";
    protected $join_table_name = "users";

    public function allCategories()
    {
        $database_class = $this->db;
        $field__title = $this->field_title;
        $posts = $database_class->selectOrder("categories","ORDER BY $field__title");

        return($posts);
    }
    public function post_empty(string $id)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $is_empty = $database_class->TableRow("$table","user_id = $id");
        if($is_empty > 0){
            return(true);
        }else{
            return(false);
        }
       
    }

    public function all_posts(?int $limit=null){
        $database_class = $this->db;
        $table = $this->table_name;
        if($limit == null){
            $rows = $database_class->selectOrder("$table","ORDER BY date_time DESC");
        }else{
         $rows = $database_class->selectOrder("$table","ORDER BY date_time DESC LIMIT $limit");
        }
        return($rows);
    }

    public function numberPost($id){
        $database_class = $this->db;
        $table = $this->table_name;
        $is_empty = $database_class->TableRow("$table","user_id = $id");
        return($is_empty);
    }
    public function exist_featured(){
        $database_class = $this->db;
        $table = $this->table_name;
        $is_empty = $database_class->TableRow("$table","is_featured = 1");
        return($is_empty);
    }

    public function post_featured()
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $row = $database_class->selectOne("$table","is_featured = 1");
        return($row);
    }

    public function update_is_featured(){
        $database_class = $this->db;
        $table = $this->table_name;
        $update = $database_class->updateField("$table","is_featured = 0");
        return $update;
    }

    public function oneCategory($id){
        $database_class = $this->db;
        $category = $database_class->selectOne("categories","id = $id");
        return($category);
    }

    public function postByCategory($id){
        $database_class = $this->db;
        $table = $this->table_name;
        $rows = $database_class->selectOrder("$table","WHERE category_id = $id ORDER BY date_time DESC");
        return($rows);
    }

    public function searchPost( string $search)
    {
        $database_class = $this->db;
        $table = $this->table_name;
        $search_key_words = explode(" ",$search);

        // count the number of words in the search keyword
        $key_word_number = count($search_key_words); 

        $key_word = "";

        for($i=1;$i<$key_word_number;$i++){  

            $key_word .= "OR title LIKE '%$search_key_words[$i]%'";
        }

        $rows = $database_class->selectAll("$table","title LIKE '%$search_key_words[0]%' $key_word  ORDER BY date_time DESC");
        return($rows);
    }

}

?>