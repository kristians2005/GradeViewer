<?php require_once "views/partials/header.view.php"; ?>

<div class="min-h-screen bg-base-200 py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Edit Product</h1>
            <a href="/products" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Products
            </a>
        </div>

        <!-- Edit Form Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="/products/update/<?= $product['id'] ?>" method="POST" class="space-y-6">
                    <!-- Basic Information Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Product Name</span>
                            </label>
                            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required
                                class="input input-bordered w-full" placeholder="Enter product name">
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">SKU</span>
                            </label>
                            <input type="text" name="sku" value="<?= htmlspecialchars($product['sku']) ?>" required
                                class="input input-bordered w-full" placeholder="Enter SKU">
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Description</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered w-full h-32"
                            placeholder="Enter product description"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>

                    <!-- Price and Category Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Price (€)</span>
                            </label>
                            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required
                                class="input input-bordered w-full" placeholder="0.00">
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Category</span>
                            </label>
                            <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>"
                                required class="input input-bordered w-full" placeholder="Enter category">
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="divider"></div>
                    <div class="flex justify-end gap-2">
                        <a href="/products" class="btn btn-ghost">
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
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>