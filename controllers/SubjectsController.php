<?php


class SubjectsController
{


    public function index()
    {
        // if (isset($_SESSION)) {
        //     header('Location: /');
        //     return;
        // }

        require "views/subjects/index.view.php";
    }



}