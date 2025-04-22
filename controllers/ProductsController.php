<?php

require_once "models/Product.php";

class ProductsController
{
    public function index()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        $products = Product::all();
        require "views/products/index.view.php";
    }

    public function show($id)
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        $product = Product::find($id);
        if (!$product) {
            die("Product not found.");
        }
        require "views/products/show.view.php";
    }

    public function create()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        require "views/products/create.view.php";
    }

    public function store()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "name" => $_POST["name"],
                "description" => $_POST["description"],
                "sku" => $_POST["sku"],
                "price" => $_POST["price"],
                "category" => $_POST["category"]
            ];

            if (Product::create($data)) {
                header("Location: /products");
            } else {
                die("Error saving product.");
            }
        }
    }

    public function edit($id)
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        $product = Product::find($id);
        if (!$product) {
            die("Product not found.");
        }
        require "views/products/edit.view.php";
    }


    public function update($id)
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "name" => $_POST["name"],
                "description" => $_POST["description"],
                "sku" => $_POST["sku"],
                "price" => $_POST["price"],
                "category" => $_POST["category"]
            ];

            if (Product::update($id, $data)) {
                header("Location: /products");
            } else {
                die("Error updating product.");
            }
        }
    }

    public function destroy($id)
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        Product::destroy($id);
        header("Location: /products");
    }
}
