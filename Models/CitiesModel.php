<?php

class CitiesModel extends Model
{
    protected static $tableName = 'cities';     //table name

    public $id;             //city id
    public $name;           //city name
    public $area;           //city area
    public $population;     //city population
    public $postal_code;    //city postal code
    public $country_id;     //country in which city is located
    public $created_at;     //country created at

    public function __construct($id, $name, $area, $population, $postal_code, $country_id, $created_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->area = $area;
        $this->population = $population;
        $this->postal_code = $postal_code;
        $this->country_id = $country_id;
        $this->created_at = $created_at;
    }


    //gets all cities which are located in specified country ($countryId)
    public static function findByCountryId($countryId) {
        $orderType = self::getSortingType();        //determines how data is sorted
        $dateFiltering = self::getDateFiltering();  //date filters values
        $cities = [];


        if ($dateFiltering != null)
            //query to get all cities filtered by date
            $response = self::query("SELECT * FROM cities WHERE country_id = '$countryId' AND created_at >= '$dateFiltering[0]' AND created_at <= '$dateFiltering[1]' ORDER BY name $orderType");
        else
            //query to get all cities
            $response = self::query("SELECT * FROM cities WHERE country_id = '$countryId' ORDER BY name $orderType");

        //checks if response is array
        if (is_array($response)) {
            //puts cities in list of cities
            foreach ($response as $city) {
                $cities[] = new CitiesModel($city['id'], $city['name'], $city['area'], $city['population'], $city['postal_code'], $city['country_id'], $city['created_at']);
            }
        }

        return $cities;
    }

    //gets all cities by specific page ($page), country id ($countryId)
    public static function getCitiesInPage($page, $citesPerPage, $countryId, $searchValue){
        $orderType = self::getSortingType();        //determines how data is sorted
        $dateFiltering = self::getDateFiltering();  //date filters values
        $cities = [];

        $offset = $page * $citesPerPage - $citesPerPage;    //shows from which record start reading data

        if ($dateFiltering != null)
            //query to get all cities in page filtered by date
            $response = self::query("SELECT * FROM cities WHERE country_id =  '$countryId' AND name LIKE '%$searchValue%' AND created_at >= '$dateFiltering[0]' AND created_at <= '$dateFiltering[1]' ORDER BY name $orderType LIMIT $citesPerPage OFFSET $offset");
        else
            //query to get all cities in page
            $response = self::query("SELECT * FROM cities WHERE country_id =  '$countryId' AND name LIKE '%$searchValue%' ORDER BY name $orderType LIMIT $citesPerPage OFFSET $offset");

        //checks if response is array
        if (is_array($response)) {
            //puts cities in list of cities
            foreach ($response as $city) {
                $cities[] = new CitiesModel($city['id'], $city['name'], $city['area'], $city['population'], $city['postal_code'], $city['country_id'], $city['created_at']);
            }
        }

        return $cities;
    }

    //returns amount of pages for cities in country ($countryId) according to allowed amount of cities per page ($citesPerPage)
    public static function pagesCount($citesPerPage, $countryId, $searchValue) {
        $dateFiltering = self::getDateFiltering();  //date filters values

        if ($dateFiltering != null)
            //counts all cities in country filtered by date
            $response = self::query("SELECT Count(*) FROM cities WHERE country_id = '$countryId' AND created_at >= '$dateFiltering[0]' AND created_at <= '$dateFiltering[1]' AND name LIKE '%$searchValue%'");
        else
            //counts all cities in country
            $response = self::query("SELECT Count(*) FROM cities WHERE country_id =  '$countryId' AND name LIKE '%$searchValue%'");

        if ($response[0][0] == 0 || !is_array($response))
            return 1;

        return ceil($response[0][0] / $citesPerPage);
    }

}