<?php

class Model {

    public static $host = "127.0.0.1";                  //host name
    public static $dbName = "countries_and_cities";     //db name
    public static $username = "root";                   //username to login to database
    public static $password = "Root+123";               //password to login to database

    //connects to data base
    public static function connect() {
        $pdo = new PDO ("mysql:host=".self::$host.";dbname=".self::$dbName.";charset=utf8", self::$username, self::$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    //query to get data from database
    public static function query($query, $params = array()) {

        //checks if query contains drop table and select
        if (strpos( strtolower($query), "drop table") !== false && strpos( strtolower($query), "select") !== false)
            return null;

        //executes query
        $statements = self::connect()->prepare($query);
        try {
            $statements->execute($params);
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }

        //if it was select query returns data
        if(explode(' ', $query)[0] == 'SELECT') {
            return $statements->fetchAll();
        }

        return null;
    }

    //saves data ($data) in database
    public static function save($data) {

        $arrayOfColumns = array();  //array that saves columns to add to database
        $arrayOfValues = array();   //array that saves values of columns

        //puts data to appropriate arrays from $data variable
        foreach ($data as $key => $value) {
            if ($key != "id" && $key != "created_at") {
                array_push($arrayOfColumns, $key);
                array_push($arrayOfValues, $value);
            }
        }

        //builds string that holds all values of columns
        $values = "VALUES ( '" . implode("', '", $arrayOfValues ) ."' )";

        //query to save data in data base
        $response = self::query("INSERT INTO ".$data::$tableName." (".implode(", ",$arrayOfColumns).") ".$values);

        return $response;
    }

    //updates data ($data) in database
    public static function update($data) {

        //builds string that holds columns and new values for them
        $update = " ";
        foreach ($data as $key => $value){
            if ($key != "id" && $key != "created_at") {
                $update .= " $key = '$value',";
            }
        }

        //trims off last coma from string
        $update = rtrim($update, ",");

        //query to update data
        $response = self::query("UPDATE ".$data::$tableName." SET ".$update." WHERE id = '$data->id'");

        return $response;
    }

    //deletes record ($id) from database
    public static function delete($id, $table) {

        $response = self::query("DELETE FROM $table WHERE id = '$id'");  //query to delete data

        return $response;
    }

    //gets value of sorting session variable
    public static function getSortingType() {
        if (isset($_SESSION["sorting"])){
            return $_SESSION["sorting"];
        }

        return "ASC";
    }

    //gets values of date filtering session variables
    public static function getDateFiltering() {
        if (isset($_SESSION["startDate"]) && isset($_SESSION["endDate"])){
            return [0 => $_SESSION["startDate"], 1 => $_SESSION["endDate"]];
        }

        return null;
    }
}