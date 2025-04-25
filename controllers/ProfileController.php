<?php

// require_once "models/Dashboard.php";


class ProfileController
{


    public function index()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        require "views/profile/index.view.php";
    }



}