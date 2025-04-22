<?php require_once "views/partials/header.view.php"; ?>

<style>
    .dashboard-container {
        padding-top: 80px;
        background-color: #111827;
        /* dark gray background */
    }

    .dashboard-card {
        transition: all 0.2s ease;
        border: 1px solid rgba(255, 255, 255, 0.05);
        /* background: rgba(17, 24, 39, 0.8); */
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .stat-value {
        background: linear-gradient(135deg, currentColor 0%, color-mix(in srgb, currentColor 80%, #000) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-gradient {
        background: linear-gradient(to bottom right, #2563eb, #1d4ed8);
    }
</style>

<div class="pt-20 bg-base-100 min-h-screen">
    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-2xl font-semibold text-white mb-1">Inventory Dashboard</h1>
            <p class="text-gray-400">Overview of your inventory management system</p>
        </div>

        <!-- Quick Insights Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Total Products Card -->
            <div class="dashboard-card bg-base-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-900/30 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Total</span>
                </div>
                <h3 class="text-lg font-medium text-gray-300 mb-2">Products</h3>
                <div class="flex items-baseline">
                    <span class="text-3xl font-bold text-blue-400 stat-value"><?php echo $productCount; ?></span>
                    <span class="ml-2 text-sm text-gray-500">items</span>
                </div>
            </div>

            <!-- Low Stock Items Card -->
            <div class="dashboard-card bg-base-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-amber-900/30 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Alert</span>
                </div>
                <h3 class="text-lg font-medium text-gray-300 mb-2">Low Stock</h3>
                <div class="flex items-baseline">
                    <span class="text-3xl font-bold text-amber-400 stat-value"><?php echo $LowStockProduct ?></span>
                    <span class="ml-2 text-sm text-gray-500">items</span>
                </div>
            </div>

            <!-- Recent Orders Card -->
            <div class="dashboard-card bg-base-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-emerald-900/30 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Recent</span>
                </div>
                <h3 class="text-lg font-medium text-gray-300 mb-2">Orders</h3>
                <div class="flex items-baseline">
                    <span class="text-3xl font-bold text-emerald-400 stat-value"><?php echo $orders ?></span>
                    <span class="ml-2 text-sm text-gray-500">this week</span>
                </div>
            </div>
        </div>
        </td>
        </tr>
        </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>