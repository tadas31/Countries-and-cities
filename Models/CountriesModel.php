<?php

class CountriesModel extends Model
{
    protected static $tableName = 'countries';      //table name

    public $id;             //country id
    public $name;           //country name
    public $area;           //country area
    public $population;     //country population
    public $phone_code;     //country phone code
    public $created_at;     //country created at


    public function __construct($id, $name, $area, $population, $phone_code, $created_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->area = $area;
        $this->population = $population;
        $this->phone_code = $phone_code;
        $this->created_at = $created_at;
    }

    //gets all countries from data base
    public static function all() {
        $orderType = self::getSortingType();        //determines how data is sorted
        $dateFiltering = self::getDateFiltering();  //date filters values
        $countries = [];

        if ($dateFiltering != null)
            //query to get all countries filtered by date
            $response = self::query("SELECT * FROM countries ORDER BY name $orderType WHERE created_at >= '$dateFiltering[0]' AND created_at <= '$dateFiltering[1]' ");
        else
            //query to get all countries
            $response = self::query("SELECT * FROM countries ORDER BY name $orderType");

        //checks if response is array
        if (is_array($response)) {
            //puts countries in list of countries
            foreach ($response as $country) {
                $countries[] = new CountriesModel($country['id'], $country['name'], $country['area'], $country['population'], $country['phone_code'], $country['created_at']);
            }
        }

        return $countries;
    }

    //gets all countries in specified page ($page)
    public static function getCountriesInPage($page, $countriesPerPage, $searchValue) {
        $orderType = self::getSortingType();        //determines how data is sorted
        $dateFiltering = self::getDateFiltering();  //date filters values
        $countries = [];

        $offset = $page * $countriesPerPage - $countriesPerPage;    //shows from which record start reading data

        if ($dateFiltering != null)
            //query to get all countries in page filtered by date
            $response = self::query("SELECT * FROM countries WHERE name LIKE '%$searchValue%' AND created_at >= '$dateFiltering[0]' AND created_at <= '$dateFiltering[1]' ORDER BY name $orderType LIMIT $countriesPerPage OFFSET $offset");
        else
            //query to get all countries in page
            $response = self::query("SELECT * FROM countries WHERE name LIKE '%$searchValue%' ORDER BY name $orderType LIMIT $countriesPerPage OFFSET $offset");

        //checks if response is array
        if (is_array($response)) {
            //puts countries in list of countries
            foreach ($response as $country) {
                $countries[] = new CountriesModel($country['id'], $country['name'], $country['area'], $country['population'], $country['phone_code'], $country['created_at']);
            }
        }

        return $countries;
    }

    //returns amount of pages according to allowed amount of countries per page ($countriesPerPage)
    public static function pagesCount($countriesPerPage, $searchValue) {
        $dateFiltering = self::getDateFiltering();   //date filters values

        if ($dateFiltering != null)
            //counts all elements in db table filtered by date
            $response = self::query("SELECT Count(*) FROM countries WHERE created_at >= '$dateFiltering[0]' AND created_at <= '$dateFiltering[1]' AND name LIKE '%$searchValue%'");
        else
            //counts all elements in db table
            $response = self::query("SELECT Count(*) FROM countries WHERE name LIKE '%$searchValue%'");

        //checks if response is array
        if (is_array($response))
            return ceil($response[0][0] / $countriesPerPage);
        else
            return 1;

    }

    //checks if country ($countryId) exists in data base
    public static function countryName($countryId) {

        $response = self::query("SELECT name FROM countries WHERE id = '$countryId'");     //query to get country form db

        if ($response)
            return $response[0][0];

        return null;
    }
}