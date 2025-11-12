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
        $sql = sprintf("SELECT * FROM %s", static::$table);

        $query = $connection->prepare($sql);
        $query->execute();               
        $result = $query->get_result();

        $car_objects = [];
        while ($data = $result->fetch_assoc()) {
            $car_objects[] = new static($data);
        }
        return $car_objects;
    }

    public function delete(mysqli $connection,int $id, string $primary_key = "id"){
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

    public static function update(mysqli $connection, int $id, $column, $value, string $primary_key = "id"){
        $sql = sprintf("UPDATE %s SET %s = ? WHERE %s = ?",
                static::$table,
                $column,
                $primary_key);
        
        $type="";

        if(gettype($value) == "integer"){ 
            $type = "i"; 

        }elseif(gettype($value) == "double"){ 
            $type = "d"; 

        }else{ 
            $type = "s";
        }

        $type .= "i";

        $query = $connection->prepare($sql);
        $query->bind_param($type, $value, $id);
        $query->execute();

    }
}

?>
