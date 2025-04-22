<?php

require_once "models/Dashboard.php";


class DashboardController
{


    public function index()
    {

        $productCount = Dashboard::productCount();
        $LowStockProduct = count(Dashboard::lowStockProducts());
        $orders = Dashboard::orderCount();

        require "views/Dashboard.view.php";
    }



}