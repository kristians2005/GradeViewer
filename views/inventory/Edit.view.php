<?php require_once "views/partials/header.view.php"; ?>

<div class="min-h-screen bg-base-200 py-20">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Edit Inventory Item</h1>
            <a href="/inventory" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Inventory
            </a>
        </div>

        <!-- Edit Form Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="/inventory/update/<?= $item['id'] ?>" method="POST" class="space-y-6 max-w-2xl mx-auto">
                    <!-- Product Selection -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Product</span>
                            <span class="label-text-alt text-base-content/70">Choose a product from inventory</span>
                        </label>
                        <select name="product_id" required class="select select-bordered w-full">
                            <option value="">Select a product</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['id'] ?>" <?= $product['id'] === $item['product_id'] ? "selected" : "" ?>>
                                    <?= htmlspecialchars($product['name']) ?>
                                    (SKU: <?= htmlspecialchars($product['sku']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Quantity and Location -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Quantity</span>
                                <span class="label-text-alt text-base-content/70">Number of items</span>
                            </label>
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" required min="0"
                                class="input input-bordered w-full" placeholder="Enter quantity">
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Location</span>
                                <span class="label-text-alt text-base-content/70">Storage location</span>
                            </label>
                            <input type="text" name="location" value="<?= htmlspecialchars($item['location']) ?>"
                                required class="input input-bordered w-full" placeholder="Enter storage location">
                        </div>
                    </div>


                    <!-- Form Actions -->
                    <div class="divider"></div>
                    <div class="flex justify-end gap-2">
                        <a href="/inventory" class="btn btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Update Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>