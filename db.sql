CREATE DATABASE inv_sistema;


USE inv_sistema;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    roles ENUM('Worker', 'Admin') NOT NULL,
    password TEXT NOT NULL
);


CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    sku VARCHAR(100) UNIQUE NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    location VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT, -- Changed to allow NULL
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


INSERT INTO users (name, email, roles, password) VALUES
('John Admin', 'admin@example.com', 'Admin', '$2y$10$example_hashed_password1'),
('Jane Worker', 'worker@example.com', 'Worker', '$2y$10$example_hashed_password2'),
('Mike Staff', 'staff@example.com', 'Worker', '$2y$10$example_hashed_password3'),
('admin', 'admin@admin.com', 'Admin', 'admin123'),
('worker', 'worker@worker.com', 'Worker', 'worker123');


INSERT INTO products (name, description, sku, price, category) VALUES
('Laptop Dell XPS 13', '13-inch laptop with Intel i7', 'LAP-DELL-001', 1299.99, 'Electronics'),
('Office Chair', 'Ergonomic office chair', 'FUR-CHAIR-001', 199.99, 'Furniture'),
('Wireless Mouse', 'Bluetooth wireless mouse', 'ACC-MOUSE-001', 29.99, 'Accessories'),
('Monitor 27"', '27-inch 4K LED Monitor', 'MON-LED-001', 349.99, 'Electronics'),
('USB-C Cable', '2m USB-C charging cable', 'CAB-USBC-001', 19.99, 'Accessories');


INSERT INTO inventory (product_id, quantity, location) VALUES
(1, 15, 'Warehouse A'),
(2, 25, 'Warehouse B'),
(3, 50, 'Warehouse A'),
(4, 10, 'Warehouse A'),
(5, 100, 'Warehouse C');


INSERT INTO orders (user_id, product_id, quantity, status) VALUES
(1, 1, 2, 'completed'),
(2, 3, 5, 'pending'),
(3, 2, 1, 'completed'),
(2, 4, 2, 'cancelled'),
(1, 5, 10, 'pending');



