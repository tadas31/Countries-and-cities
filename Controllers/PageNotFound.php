<?php

class PageNotFound extends Controller
{
    public function index(){
        $this->view->name = "404 error";
        $this->view->render('PageNotFoundView', true);
    }

}