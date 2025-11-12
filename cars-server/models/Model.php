<?php
abstract class Model{

    protected static string $table;
    //protected static string $primary_key = "id";

    public static function find(mysqli $connection, string $id, string $primary_key = "id"){
        $sql = sprintf("SELECT * from %s WHERE %s = ?",
                       static::$table,
                       $primary_key);
                       //static::$primary_key);

        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();               

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }
    
        public static function findAll(mysqli $connection){
        //implement this
    }

    public static function delete(mysqli $connection, string $id, string $primary_key = "id"){
        $sql = sprintf("DELETE FROM %s WHERE %s = ? ",
                        static::$table, 
                        $primary_key);

        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();              
    }

    public static function insert(mysqli $connection, array $attributes){
        $columns = array_keys($attributes);
        $values = array_values($attributes);
        
        $placeholders = rtrim(str_repeat('?, ', count($values)), ', ');
        $types = '';
        
        foreach ($attributes as $value) { 
            if(gettype($value) == "integer"){ 
                $types .= "i"; 
            
            }elseif(gettype($value) == "double"){ 
                $types .= "d"; 
            
            }else{ 
                $types .= "s";
            } 
        }
    
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::$table,
            implode(', ', $columns),
            $placeholders
        );
    
        $query = $connection->prepare($sql);
        $query->bind_param($types, ...$values);
        $query->execute();
    }

}



?>
