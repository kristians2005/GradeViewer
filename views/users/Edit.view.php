<?php require_once "views/partials/header.view.php"; ?>

<div class="min-h-screen bg-base-200 py-20">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Edit User</h1>
            <a href="/users" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Users
            </a>
        </div>

        <!-- Edit Form Card -->
        <div class="card bg-base-100 shadow-xl max-w-2xl mx-auto">
            <div class="card-body">
                <form action="/users/update?id=<?= $user['id'] ?>" method="POST" class="space-y-6">
                    <!-- Basic Information Section -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold">Basic Information</h2>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Name</span>
                                <span class="label-text-alt text-base-content/70">2-50 characters, letters only</span>
                            </label>
                            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>"
                                class="input input-bordered w-full" required pattern="[a-zA-Z]{2,50}"
                                placeholder="Enter user's name">
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Email</span>
                                <span class="label-text-alt text-base-content/70">Valid email address</span>
                            </label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                                class="input input-bordered w-full" required placeholder="user@example.com">
                        </div>
                    </div>

                    <!-- Role Section -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold">User Role</h2>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Role</span>
                                <span class="label-text-alt text-base-content/70">Select user access level</span>
                            </label>
                            <select id="roles" name="roles" class="select select-bordered w-full" required>
                                <option value="Worker" <?= $user['roles'] === 'Worker' ? 'selected' : '' ?>>Worker</option>
                                <option value="Admin" <?= $user['roles'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="divider"></div>
                    <div class="flex justify-end gap-2">
                        <a href="/users" class="btn btn-ghost">
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
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>