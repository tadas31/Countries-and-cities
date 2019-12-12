<?php


class Bootstrap
{
    public function __construct(){

        $notFound = false;      //if changes to true page does not exist

        if (isset($_GET['path'])) {

            $tokens = explode('/', rtrim($_GET['path'], '/'));      //explodes url to tokens
            $controllerName = ucfirst(array_shift($tokens));                 //gets controller's name and removes it from tokens array

            //checks if controller exists
            if (file_exists('Controllers/'.$controllerName.'.php')){
                $controller = new $controllerName();

                //checks if there are more tokens
                if (!empty($tokens)) {
                    $method = array_shift($tokens);     //sets first token as method name

                    //checks if method exists
                    if (method_exists($controller, $method)) {
                        $controller->{$method}($tokens);   //executes method setting all leftover tokens as inputs
                    }
                    else {
                        $notFound = true;
                    }
                }

                //checks if controller has index method
                else if (method_exists($controller, 'index')){
                    $controller->{'index'}($tokens);   //executes index method
                }

                else {
                    $notFound = true;
                }
            }
            else {
                $notFound = true;
            }
        }

        //if there are no input loads main page
        else {
            $controller = new Countries();
            $controller->{'index'}(1);      //executes index method
        }

        //executes if page is not found shows 404 error
        if ($notFound){
            $controller = new PageNotFound();
            $controller->index();       //executes index method
        }
    }
   
}