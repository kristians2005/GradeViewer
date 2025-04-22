<?php require_once "views/partials/header.view.php"; ?>

<div class="min-h-screen bg-base-200 py-20">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Inventory Details</h1>
            <a href="/inventory" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Inventory
            </a>
        </div>

        <!-- Details Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h2 class="card-title text-xl mb-4">Basic Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-base-content/70">ID:</div>
                            <div class="font-medium">#<?= $inventory['id'] ?></div>

                            <div class="text-base-content/70">Product Name:</div>
                            <div class="font-medium"><?= htmlspecialchars($inventory['product_name']) ?></div>

                            <div class="text-base-content/70">Product ID:</div>
                            <div class="font-medium">#<?= $inventory['product_id'] ?></div>
                        </div>
                    </div>

                    <!-- Inventory Status -->
                    <div class="space-y-4">
                        <h2 class="card-title text-xl mb-4">Stock Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-base-content/70">Quantity:</div>
                            <div class="font-medium"><?= number_format($inventory['quantity']) ?> units</div>

                            <div class="text-base-content/70">Location:</div>
                            <div>
                                <div class="badge badge-ghost">
                                    <?= htmlspecialchars($inventory['location']) ?>
                                </div>
                            </div>
                            <!-- 
                            <div class="text-base-content/70">Total Value:</div>
                            <div class="font-medium">
                                <?= number_format($inventory['quantity'] * $inventory['unit_price'], 2) ?> €
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <?php if (!empty($inventory['notes'])): ?>
                    <div class="mt-8">
                        <h2 class="card-title text-xl mb-4">Notes</h2>
                        <div class="bg-base-200 rounded-lg p-4">
                            <p class="whitespace-pre-line"><?= nl2br(htmlspecialchars($inventory['notes'])) ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="divider mt-8"></div>
                <div class="card-actions justify-end gap-2">
                    <a href="/inventory/edit/<?= $inventory['id'] ?>" class="btn btn-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Item
                    </a>
                    <form action="/inventory/destroy/<?= $inventory['id'] ?>" method="POST" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this inventory item?')">
                        <button type="submit" class="btn btn-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Item
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>