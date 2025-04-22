<?php require_once "views/partials/header.view.php"; ?>

<div class="min-h-screen bg-base-200 py-20">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Order Management</h1>
            <div class="flex gap-4">
                <a href="/orders/order" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Order
                </a>
                <a href="/reports/orders" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Generate Report
                </a>
            </div>
        </div>

        <!-- Product Overview Section -->
        <div class="card bg-base-100 shadow-xl mb-8">
            <div class="card-body">
                <h2 class="card-title mb-4">Product Overview</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Location</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['all_products'] as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo htmlspecialchars($item['sku']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($item['location'] ?: 'Not specified'); ?></td>
                                    <td><?php echo htmlspecialchars($item['updated_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Status Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Low Stock Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Low Stock Products
                    </h2>
                    <?php if (empty($data['low_stock'])): ?>
                        <p class="text-gray-500 italic">No products with low stock</p>
                    <?php else: ?>
                        <ul class="menu bg-base-100">
                            <?php foreach ($data['low_stock'] as $item): ?>
                                <li class="text-warning">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                    (SKU: <?php echo htmlspecialchars($item['sku']); ?>) -
                                    Stock: <?php echo htmlspecialchars($item['quantity']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Recent Activity (7 Days)
                    </h2>
                    <?php if (empty($data['sold_utilized'])): ?>
                        <p class="text-gray-500 italic">No recent activity</p>
                    <?php else: ?>
                        <ul class="menu bg-base-100">
                            <?php foreach ($data['sold_utilized'] as $item): ?>
                                <li class="flex flex-col py-2">
                                    <span class="font-medium">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                        (SKU: <?php echo htmlspecialchars($item['sku']); ?>)
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        Stock: <?php echo htmlspecialchars($item['quantity']); ?> |
                                        Updated: <?php echo htmlspecialchars($item['updated_at']); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Orders Table Section -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-6">All Orders</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                                    <th>Admin Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['orders'] as $order): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                                    <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                    <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                    <td>
                                        <div class="badge <?php echo match ($order['status']) {
                                            'pending' => 'badge-warning',
                                            'completed' => 'badge-success',
                                            'cancelled' => 'badge-error',
                                            default => 'badge-ghost'
                                        }; ?>">
                                            <?php echo htmlspecialchars($order['status']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                                    <td>
                                        <a href="/orders/show?id=<?php echo $order['id']; ?>"
                                            class="btn btn-sm btn-info">View</a>
                                    </td>
                                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                                        <td class="flex gap-2">
                                            <button onclick="updateStatus(<?php echo $order['id']; ?>, 'pending')"
                                                class="btn btn-sm btn-warning">Pending</button>
                                            <button onclick="updateStatus(<?php echo $order['id']; ?>, 'completed')"
                                                class="btn btn-sm btn-success">Complete</button>
                                            <button onclick="updateStatus(<?php echo $order['id']; ?>, 'cancelled')"
                                                class="btn btn-sm btn-error">Cancel</button>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStatus(orderId, status) {
        fetch('/orders/updateStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': '<?php echo $_SESSION["token"] ?? ""; ?>'
            },
            body: JSON.stringify({ id: orderId, status: status })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to update status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating status.');
            });
    }
</script>

<?php require_once "views/partials/footer.view.php"; ?>