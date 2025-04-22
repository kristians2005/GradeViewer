<?php require_once "views/partials/header.view.php"; ?>

<div class="min-h-screen bg-base-200 py-20">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Create New Order</h1>
            <a href="/orders" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Overview
            </a>
        </div>

        <!-- Alerts Section -->
        <?php if (isset($data['success']) || isset($data['error'])): ?>
            <div class="mb-8">
                <?php if (isset($data['success'])): ?>
                    <div class="alert alert-success shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?php echo htmlspecialchars($data['success']); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-error shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?php echo htmlspecialchars($data['error']); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Products Table Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-6">Available Products</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Available</th>
                                <th>Location</th>
                                <th>Order</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['products'] as $product): ?>
                                <tr>
                                    <td class="font-medium"><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['sku']); ?></td>
                                    <td><?php echo htmlspecialchars($product['description'] ?: 'No description'); ?></td>
                                    <td class="font-medium"><?php echo htmlspecialchars($product['price']); ?> EUR</td>
                                    <td>
                                        <div class="badge badge-ghost"><?php echo htmlspecialchars($product['category']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($product['location'] ?: 'Not specified'); ?></td>
                                    <td>
                                        <form method="POST" action="/orders/order" class="flex items-center gap-2">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <input type="number" name="quantity" min="1"
                                                max="<?php echo $product['quantity']; ?>" required
                                                class="input input-bordered input-sm w-20" placeholder="Qty">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Order
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="/products/show/<?php echo $product['id']; ?>" class="btn btn-ghost btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>