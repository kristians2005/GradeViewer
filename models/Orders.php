<?php


require_once __DIR__ . '/../dataBase.php'; // Points to root from models/


class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getLowStock()
    {
        $statement = $this->db->query("
            SELECT p.name, p.sku, i.quantity, i.location 
            FROM products p 
            JOIN inventory i ON p.id = i.product_id 
            WHERE i.quantity < 10
        ");
        return $statement->fetchAll();
    }

    public function getAllProducts()
    {
        $statement = $this->db->query("
            SELECT p.id, p.name, p.sku, p.description, p.price, p.category, 
                   i.quantity, i.location, i.updated_at 
            FROM products p 
            JOIN inventory i ON p.id = i.product_id
        ");
        return $statement->fetchAll();
    }

    public function getSoldUtilized()
    {
        $statement = $this->db->query("
            SELECT p.name, p.sku, i.quantity, i.updated_at 
            FROM products p 
            JOIN inventory i ON p.id = i.product_id 
            WHERE i.quantity < 10 
            AND i.updated_at > NOW() - INTERVAL 7 DAY
            ORDER BY i.updated_at DESC
        ");
        return $statement->fetchAll();
    }

    public function getProductById($productId)
    {
        $statement = $this->db->query("
            SELECT p.name, p.sku, p.description, p.price, p.category, 
                   i.quantity, i.location, i.updated_at 
            FROM products p 
            JOIN inventory i ON p.id = i.product_id 
            WHERE p.id = ?",
            [$productId]
        );
        $result = $statement->fetchAll();
        return $result[0] ?? null;
    }

    public function updateInventory($productId, $quantityChange)
    {
        $statement = $this->db->query("
            UPDATE inventory 
            SET quantity = GREATEST(quantity + ?, 0), 
                updated_at = NOW() 
            WHERE product_id = ?",
            [$quantityChange, $productId]
        );
        return $statement->rowCount() > 0;
    }

    public function createOrder($userId, $productId, $quantity)
    {
        $product = $this->getProductById($productId);
        if (!$product || $product['quantity'] < $quantity) {
            return false;
        }

        $statement = $this->db->query("
            INSERT INTO orders (user_id, product_id, quantity, status) 
            VALUES (?, ?, ?, 'pending')",
            [$userId ?: null, $productId, $quantity]
        );

        if ($statement->rowCount() > 0) {
            $this->updateInventory($productId, -$quantity);
            return true;
        }
        return false;
    }

    public function getAllOrders()
    {
        $statement = $this->db->query("
            SELECT o.id, u.name AS user_name, p.name AS product_name, o.quantity, o.status, o.created_at 
            FROM orders o 
            LEFT JOIN users u ON o.user_id = u.id 
            JOIN products p ON o.product_id = p.id
        ");
        return $statement->fetchAll();
    }

    public function getOrderById($id)
    {
        $statement = $this->db->query("
            SELECT o.id, o.quantity, o.status, o.created_at,
                   u.name AS user_name,
                   p.name AS product_name
            FROM orders o 
            LEFT JOIN users u ON o.user_id = u.id 
            JOIN products p ON o.product_id = p.id
            WHERE o.id = ?
        ", [$id]);
        return $statement->fetch();
    }

    public function updateOrderStatus($orderId, $status)
    {
        $allowedStatuses = ['pending', 'completed', 'cancelled'];
        if (!in_array($status, $allowedStatuses)) {
            return false;
        }

        $statement = $this->db->query("
            UPDATE orders 
            SET status = ? 
            WHERE id = ?
        ", [$status, $orderId]);

        return $statement->rowCount() > 0;
    }
}