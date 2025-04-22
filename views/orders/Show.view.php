<?php require_once "views/partials/header.view.php"; ?>

<div class="min-h-screen bg-base-200 py-20">
    <div class="max-w-4xl mx-auto px-4">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="card-title text-2xl">Order Details</h2>
                    <div class="badge badge-lg <?php echo match ($data['order']['status']) {
                        'pending' => 'badge-warning',
                        'completed' => 'badge-success',
                        'cancelled' => 'badge-error',
                        default => 'badge-ghost'
                    }; ?>">
                        <?php echo $data['order']['status']; ?>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Order Information -->
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-lg mb-4">Order Information</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Order ID:</span>
                                    <span class="font-medium">#<?php echo $data['order']['id']; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Created:</span>
                                    <span class="font-medium"><?php echo $data['order']['created_at']; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">User:</span>
                                    <span class="font-medium"><?php echo $data['order']['user_name']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-lg mb-4">Product Information</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Name:</span>
                                    <span class="font-medium"><?php echo $data['order']['product_name']; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-base-content/70">Quantity:</span>
                                    <span class="font-medium"><?php echo $data['order']['quantity']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="divider mt-6"></div>
                <div class="card-actions justify-end gap-3">
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                        <button onclick="updateStatus(<?php echo $data['order']['id']; ?>, 'completed')"
                            class="btn btn-success btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Complete Order
                        </button>
                        <button onclick="updateStatus(<?php echo $data['order']['id']; ?>, 'pending')"
                            class="btn btn-warning btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Set Pending
                        </button>
                        <button onclick="updateStatus(<?php echo $data['order']['id']; ?>, 'cancelled')"
                            class="btn btn-error btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel Order
                        </button>
                    <?php endif; ?>
                    <a href="/orders" class="btn btn-ghost btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
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