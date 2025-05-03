<?php

require_once "models/Dashboard.php";


class DashboardController
{


    public function index()
    {
        if (isset($_SESSION['logged_in'])) {
            header('Location: /home');
            return;
        }

        require "views/Dashboard.view.php";
    }



}