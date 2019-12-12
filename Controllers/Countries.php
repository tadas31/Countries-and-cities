<?php

class Countries extends Controller
{
    //gets all data that is needed to load page and calls appropriate view
    public function index() {

        $this->setResponse();   //response to user actions

        $searchValue = null;
        //if user used search gets search value
        if (isset($_GET['search']) || (is_array(func_get_arg(0)) && sizeof(func_get_arg(0)) > 1 ))
            $searchValue = isset($_GET['search']) ? $_GET['search'] : func_get_arg(0)[1];

        $countriesPerPage = 10;     //number of countries per page
        $page = func_get_arg(0) && is_numeric(func_get_arg(0)[0]) ? func_get_arg(0)[0] : 1;     //gets current page
        $pagesCount = CountriesModel::pagesCount($countriesPerPage, $searchValue);    //gets pages count
        //checks if page exists if not sets page number to 1
        if ($page > $pagesCount)
            $page = 1;

        $this->view->countriesInPage = CountriesModel::getCountriesInPage($page, $countriesPerPage, $searchValue);     //gets all countries in page
        $this->view->pagesCount = $pagesCount;
        $this->view->currentPage = $page;
        $this->view->searchValue = $searchValue;
        $this->view->name = "Countries";
        $this->view->path = $page;
        $this->view->render('CountriesView', false);

    }

    //saves country in database
    public function save() {
        //creates new object with data about country
        $countryToSave = new CountriesModel(null, $_GET['name'], $_GET['area'], $_GET['population'], $_GET['phoneCode'], null);

        $response = CountriesModel::save($countryToSave);   //saves country in data base

        //saves response in session variable
        if ($response){
            $_SESSION["response"] = $response ;
        }
        else {
            $_SESSION["response"] = "Country created" ;
        }
        header("LOCATION: /");      //sets location to main page and loads it
    }

    //updates country in database
    public function update() {
        $currentPage = func_get_arg(0)[0];  //gets current page

        //creates new object with data about country
        $countryToEdit = new CountriesModel( $_SESSION["editing"], $_GET['name'], $_GET['area'], $_GET['population'], $_GET['phoneCode'], null);

        $response = CountriesModel::update($countryToEdit);   //updates country in data base

        //saves response in session variable
        if ($response){
            $_SESSION["response"] = $response ;
        }
        else {
            $_SESSION["response"] = "Country updated" ;
        }

        unset($_SESSION["editing"]);    //deletes session variable indicating that record is being edited

        //location to page where object was being edited
        $location = sizeof(func_get_arg(0)) == 2 ? "/countries/index/".$currentPage."/".func_get_arg(0)[1] : "/countries/index/".$currentPage;

        header("LOCATION: ".$location);      //sets location and loads page
    }


}