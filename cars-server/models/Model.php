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
                        static::$table, $primary_key);

        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();               
    }



}



?>
