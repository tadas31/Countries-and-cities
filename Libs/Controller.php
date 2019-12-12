<?php

class Controller {


    public function __construct()
    {
        $this->view = new View();
    }

    //sets or removes field for editing
    public function setEditing() {
        $id = func_get_arg(0)[0];     //gets object's id

        //if no field is set for editing or different field is set sets new field
        if ( !isset($_SESSION["editing"]) || $id != $_SESSION["editing"]) {
            $_SESSION["editing"] = $id;
        }
        //if same field is being set cancels editing
        else {
            unset($_SESSION["editing"]) ;
        }

        $this->route(func_get_arg(0), 4);   //loads same page
    }

    //deletes records in database
    public function delete() {
        $id = func_get_arg(0)[0];   //gets object's id
        $tableName = explode('/', $_SERVER['REQUEST_URI'])[1];  //gets data base table's name

        $response = Model::delete($id, $tableName);  //deletes data

        //saves response in session variable
        if ($response){
            $_SESSION["response"] = $response ;
        }
        else {
            $_SESSION["response"] = "Record deleted" ;
        }

        $this->route(func_get_arg(0), 4);  //loads same page
    }

    //creates session variable that describes how data should be sorted
    public function setSorting() {

        $_SESSION["sorting"] = $_GET["sorting"];

        $this->route(func_get_arg(0), 3);  //loads same page
    }

    //checks and saves dates by which data will be filtered
    public function filterByDate() {
        $startDate = $_GET["startDate"];    //gets start date for filtering
        $endDate = $_GET["endDate"];        //gets end date for filtering

        //checks if end date is not smaller than start date
        //if smaller saves response ir session variable
        //else saves dates in session variables
        if ($endDate < $startDate){
            $_SESSION["response"] = "End date can't be smaller than start date";
        }
        else {
            $_SESSION['startDate'] = $startDate;
            $_SESSION['endDate'] = $endDate;
        }

        $this->route(func_get_arg(0), 3);   //loads same page
    }

    //deletes session variables that hold dates to filter by
    public function clearFilterByDate() {
        unset($_SESSION["startDate"]) ;
        unset($_SESSION["endDate"]) ;

        $this->route(func_get_arg(0), 3);   //loads same page
    }

    //according to input determines what page to load
    public function route($args, $index) {
        $tableName = explode('/', $_SERVER['REQUEST_URI'])[1];  //gets table name
        switch ($tableName) {
            case "countries" :
                $currentPage = $index == 3 ? $args[0] : $args[1];   //gets current page

                //location to page where action was performed
                $location = sizeof($args) ==  $index - 1 ? "/countries/index/".$currentPage."/".$args[$index - 2 ] : "/countries/index/".$currentPage;
                break;
            case "cities":
                $countryId = $index == 3 ? $args[0] : $args[1];     //gets country id
                $currentPage = $index == 3 ? $args[1] : $args[2];    //gets current page

                //location to page where action was performed
                $location = sizeof($args) == $index ? "/cities/index/".$countryId."/".$currentPage."/".$args[ $index - 1] : "/cities/index/".$countryId."/".$currentPage;
                break;
            default :
                $location = "";
                break;
        }
        header("LOCATION: ". $location);      //sets location and loads page
    }

    //sets response to users actions
    public function setResponse() {
        $this->view->response = null;
        if ( isset($_SESSION["response"]) ){
            $response = $_SESSION["response"];
            //checks if user entered input drop table
            if (strpos( strtolower($response), "duplicate entry") !== false) {
                $this->view->error = true;
                $this->view->response = "Country is already created";
            }
            else if (strpos( strtolower($response), "sql") !== false) {
                $this->view->error = true;
                $this->view->response = "Error occurred";
            }
            else if (strpos( strtolower($response), "end date") !== false) {
                $this->view->error = true;
                $this->view->response = $response;
            }
            else {
                $this->view->error = false;
                $this->view->response = $response;
            }
            unset($_SESSION["response"]) ;
        }
    }
}