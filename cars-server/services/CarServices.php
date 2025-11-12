<?php
// require_once("../models/Car.php");
// require_once("../connection/connection.php");

require_once("../models/Car.php");
require_once("../connection/connection.php");

class CarService {

    public static function findCarByID(int $id) {
        global $connection;
        $car = Car::find($connection, $id);
        return $car ? $car->toArray() : [];
    }

    public static function findAllCars() {
        global $connection;
        $cars = Car::findAll($connection);
        return array_map(fn($car) => $car->toArray(), $cars);
    }

    public static function insertCar(array $data) {
        global $connection;
        Car::insert($connection, $data);
    }

    public static function updateCar(int $id, string $column, $value) {
        global $connection;
        $car = Car::find($connection, $id);
        if ($car) {
            $car->update($connection, $id, $column, $value);
        }
    }

    public static function deleteCar(int $id) {
        global $connection;
        $car = Car::find($connection, $id);
        if ($car) {
            $car->delete($connection);
        }
    }
}
?>