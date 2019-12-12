<?php

class Cities extends Controller
{
    //gets all data that is needed to load page and calls appropriate view
    public function index()
    {
        //checks if any variables have been passed
        if (func_get_arg(0)) {

            $countryId = func_get_arg(0)[0];    //gets country id
            $countryName = CountriesModel::countryName($countryId);     //gets country name
            //if country does not exists shows 404 error
            if ( $countryName == null ) {
                $controller = new PageNotFound();
                $controller->index();
                return;
            }

            $this->setResponse();  //response to user actions

            $searchValue = null;
            //if user used search gets search value
            if (isset($_GET['search']) || sizeof(func_get_arg(0)) > 2 )
                $searchValue = isset($_GET['search']) ? $_GET['search'] : func_get_arg(0)[2];

            $citesPerPage = 10;     //number of cities per page
            $page = sizeof(func_get_arg(0)) > 1 && is_numeric(func_get_arg(0)[1]) ?  func_get_arg(0)[1] : 1;   //gets current page
            $pagesCount = CitiesModel::pagesCount($citesPerPage, $countryId, $searchValue);     //gets pages count
            //checks if page exists if not sets page number to 1
            if ($page > $pagesCount)
                $page = 1;

            $this->view->citiesInPage = CitiesModel::getCitiesInPage($page, $citesPerPage, $countryId, $searchValue);     //gets all cities in page
            $this->view->pagesCount = $pagesCount;
            $this->view->currentPage = $page;
            $this->view->countryId = $countryId;
            $this->view->searchValue = $searchValue;
            $this->view->name = "Cities";
            $this->view->path = $countryId."/".$page;
            $this->view->countryName = $countryName;
            $this->view->render('CitiesView', false);

        }
        //if there are no input shows 404 error
        else {
            $controller = new PageNotFound();
            $controller->index();
            return;
        }
    }

    //saves city in data base
    public function save() {
        $countryId = func_get_arg(0)[0];    //gets country id

        //creates new object with data about city
        $cityToSave = new CitiesModel(null, $_GET['name'], $_GET['area'], $_GET['population'], $_GET['postalCode'], $countryId, null);

        $response = CitiesModel::save($cityToSave);   //saves city in data base

        //saves response in session variable
        if ($response){
            $_SESSION["response"] = $response ;
        }
        else {
            $_SESSION["response"] = "City created" ;
        }

        header("LOCATION: /cities/index/".$countryId);      //sets location to first page of country cities and loads it
    }

    //updates city in data base
    public function update() {
        $countryId = func_get_arg(0)[0];    //gets country id
        $currentPage = func_get_arg(0)[1];  //gets current page

        //creates new object with data about city
        $cityToEdit = new CitiesModel($_SESSION["editing"], $_GET['name'], $_GET['area'], $_GET['population'], $_GET['postalCode'], $countryId, null);

        $response = CitiesModel::update($cityToEdit);   //updates city in data base

        //saves response in session variable
        if ($response){
            $_SESSION["response"] = $response ;
        }
        else {
            $_SESSION["response"] = "City updated" ;
        }

        unset($_SESSION["editing"]);    //deletes session variable indicating that record is being edited

        //location to page where object was being edited
        $location = sizeof(func_get_arg(0)) == 3 ? "/cities/index/".$countryId."/".$currentPage."/".func_get_arg(0)[2] : "/cities/index/".$countryId."/".$currentPage;

        header("LOCATION: ".$location);     //sets location and loads page
    }
}