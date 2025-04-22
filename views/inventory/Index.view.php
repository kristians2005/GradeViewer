<?php require_once "views/partials/header.view.php"; ?>

<div class="min-h-screen bg-base-200 py-20">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Inventory Management</h1>
            <div class="flex gap-2">
                <a href="/inventory/create" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Item
                </a>
                <a href="/products" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    Products
                </a>
                <a href="/" class="btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Inventory Table Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th class="bg-base-200">ID</th>
                                <th class="bg-base-200">Product</th>
                                <th class="bg-base-200">Unit Price</th>
                                <th class="bg-base-200">Quantity</th>
                                <th class="bg-base-200">Total Value</th>
                                <th class="bg-base-200">Location</th>
                                <th class="bg-base-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inventory as $item): ?>
                                <tr>
                                    <td><?= $item["id"] ?></td>
                                    <td class="font-medium">
                                        <?= htmlspecialchars($products[$item["product_id"]]['name'] ?? 'Unknown Product') ?>
                                    </td>
                                    <td class="">
                                        <?= number_format($products[$item["product_id"]]['price'] ?? 0, 2) ?> €
                                    </td>
                                    <td class="">
                                        <?= number_format($item["quantity"]) ?>
                                    </td>
                                    <td class=" font-medium">
                                        <?= number_format($products[$item["product_id"]]['price'] * $item["quantity"] ?? 0, 2) ?>
                                        €
                                    </td>
                                    <td>
                                        <div class="badge badge-ghost">
                                            <?= htmlspecialchars($item["location"]) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="/inventory/show/<?= $item['id'] ?>" class="btn btn-info btn-sm tooltip"
                                                data-tip="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="/inventory/edit/<?= $item['id'] ?>"
                                                class="btn btn-warning btn-sm tooltip" data-tip="Edit Item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="/inventory/destroy/<?= $item['id'] ?>" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this inventory item?')">
                                                <button type="submit" class="btn btn-error btn-sm tooltip"
                                                    data-tip="Delete Item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
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