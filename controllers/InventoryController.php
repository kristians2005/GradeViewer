<?php

require "models/Inventory.php";
require_once "models/Product.php";

class InventoryController
{
    public function index()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        $inventory = Inventory::all();
        $productsArray = Product::all();
        $products = [];
        foreach ($productsArray as $product) {
            $products[$product['id']] = $product;
        }

        require "views/inventory/index.view.php";
    }

    public function show($id)
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        $inventory = Inventory::find($id);

        if (!$inventory) {
            die("Inventory item not found.");
        }

        $product = Product::find($inventory['product_id']);
        $inventory['product_name'] = $product ? $product['name'] : 'Unknown Product';

        require "views/inventory/show.view.php";
    }


    public function create()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        $products = Product::all();
        require "views/inventory/create.view.php";
    }

    public function store()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "product_id" => $_POST["product_id"],
                "quantity" => $_POST["quantity"],
                "location" => $_POST["location"]
            ];

            if (Inventory::create($data)) {
                header("Location: /inventory");
            } else {
                die("Error saving inventory.");
            }
        }
    }


    public function edit($id)
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        $products = Product::all();

        $item = Inventory::find($id);
        if (!$item) {
            die("Inventory item not found.");
        }
        require "views/inventory/edit.view.php";
    }

    public function update($id)
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "quantity" => $_POST["quantity"],
                "location" => $_POST["location"]
            ];

            //var_dump(Inventory::update($id, $data));

            if (Inventory::update($id, $data)) {
                header("Location: /inventory");
            } else {
                header("Location: /inventory");
            }
        }
    }

    public function destroy($id)
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        Inventory::destroy($id);
        header("Location: /inventory");
    }
}
