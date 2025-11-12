<?php
// require_once(__DIR__ . "/../models/Car.php");
// require_once(__DIR__ . "/../connection/connection.php");
// require_once(__DIR__ . "/../services/CarService.php");
// require_once(__DIR__ . "/../services/ResponseService.php");

require_once("../models/Car.php");
require_once("../connection/connection.php");
require_once("../services/CarServices.php");
require_once("../services/ResponseService.php");



function getCars(){
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $car = CarService::findCarByID($id);
        echo ResponseService::response(200, $car);
    } else {
        $cars = CarService::findAllCars();
        echo ResponseService::response(200, $cars);
    }
}

function insertCar(){
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["name"]) || !isset($data["color"]) || !isset($data["year"])) {
        echo ResponseService::response(500, "Enter all attributes");
        exit;
    }
    CarService::insertCar($data);
    echo ResponseService::response(200, "Car inserted successfully");
}

function updateCar(){
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["id"]) || !isset($data["column"]) || !isset($data["value"])) {
        echo ResponseService::response(500, "Missing parameters");
        exit;
    }
    CarService::updateCar($data["id"], $data["column"], $data["value"]);
    echo ResponseService::response(200, "Car updated successfully");
}

function deleteCar(){
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["id"])) {
        echo ResponseService::response(500, "ID is missing");
        exit;
    }
    CarService::deleteCar($data["id"]);
    echo ResponseService::response(200, "Car deleted successfully");
}


updateCar();
?>