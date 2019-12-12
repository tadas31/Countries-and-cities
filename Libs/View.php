<?php

class View
{
    public function render($view, $isError) {
        require('Views/index.php');

        if ($isError) {
            require ('Views/'.$view.'.php');
        }
        else {
            require('Views/filters.php');
            require ('Views/'.$view.'.php');
        }
    }
}