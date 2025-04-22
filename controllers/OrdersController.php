<?php

require_once __DIR__ . '/../models/Orders.php';

class OrdersController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function index()
    {

        $data = [
            'low_stock' => $this->orderModel->getLowStock(),
            'all_products' => $this->orderModel->getAllProducts(),
            'sold_utilized' => $this->orderModel->getSoldUtilized(),
            'orders' => $this->orderModel->getAllOrders()
        ];

        require "views/orders/index.view.php";
    }

    // public function show($productId)
    // {
    //     $data = [
    //         'product' => $this->orderModel->getProductById($productId)
    //     ];

    //     require "views/orders/show.view.php";
    // }

    public function store()
    {
        if (isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $quantity = (int) ($_POST['quantity'] ?? 0);
            $userId = $_SESSION['user_id'] ?? 1;

            if ($productId && $quantity > 0) {
                $success = $this->orderModel->createOrder($userId, $productId, $quantity);
                if ($success) {
                    header("Location: /orders/order"); // Pāradresē uz order skatu
                    exit;
                } else {
                    $data['error'] = "Neizdevās veikt pirkumu. Pārbaudiet krājumus!";
                }
            } else {
                $data['error'] = "Nepareizi ievadīti dati.";
            }
        }
        require "views/orders/create.view.php";
    }

    public function order()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        $data = [
            'products' => $this->orderModel->getAllProducts(),
            'error' => null,
            'success' => null
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $quantity = (int) ($_POST['quantity'] ?? 0);
            $userId = $_SESSION['user_id'] ?? 1;

            if ($productId && $quantity > 0) {
                $success = $this->orderModel->createOrder($userId, $productId, $quantity);
                if ($success) {
                    $data['success'] = "Pasūtījums veiksmīgi izveidots!";
                } else {
                    $data['error'] = "Neizdevās veikt pasūtījumu. Pārbaudiet krājumus!";
                }
            } else {
                $data['error'] = "Nepareizi ievadīti dati.";
            }
        }

        require "views/orders/order.view.php";
    }

    public function show($id = null)
    {

        if (!$id) {
            $id = $_GET['id'] ?? null;
        }

        if (!$id) {
            header("Location: /orders");
            exit;
        }

        $data = [
            'order' => $this->orderModel->getOrderById($id)
        ];

        if (!$data['order']) {
            header("Location: /orders");
            exit;
        }

        require "views/orders/show.view.php";
    }

    public function updateStatus()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id']) || !isset($data['status'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }

        $success = $this->orderModel->updateOrderStatus($data['id'], $data['status']);

        echo json_encode(['success' => $success]);
    }
}