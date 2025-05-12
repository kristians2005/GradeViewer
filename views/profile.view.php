<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <div class="max-w-4xl mx-auto">
        <!-- Profile Header -->
        <div class="card bg-base-100 shadow-xl mb-6" data-aos="fade-up">
            <div class="card-body">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <!-- Profile Picture -->
                    <div class="relative group">
                        <div class="avatar">
                            <div class="w-32 h-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="<?php echo !empty($_SESSION['profile_picture']) ? htmlspecialchars($_SESSION['profile_picture']) : 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['first_name'] . '+' . $_SESSION['last_name']) . '&background=random'; ?>" 
                                     alt="Profile Picture" 
                                     id="profilePreview" />
                            </div>
                        </div>
                        <form action="/profile/update-picture" method="POST" enctype="multipart/form-data" class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <label class="btn btn-circle btn-primary btn-sm cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <input type="file" name="profile_picture" class="hidden" accept="image/*" onchange="previewImage(this)" />
                            </label>
                        </form>
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-3xl font-bold mb-2"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></h1>
                        <p class="text-base-content/70"><?php echo ucfirst($_SESSION['role'] ?? 'user'); ?></p>
                        <?php if (!empty($_SESSION['nick_name'])): ?>
                            <div class="badge badge-primary mt-2"><?php echo htmlspecialchars($_SESSION['nick_name']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Settings -->
        <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="100">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold mb-6">Profile Settings</h2>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Personal Information Form -->
                <form action="/profile/update-info" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">First Name</span>
                            </label>
                            <input type="text" name="first_name" value="<?php echo htmlspecialchars($_SESSION['first_name']); ?>" class="input input-bordered" required />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Last Name</span>
                            </label>
                            <input type="text" name="last_name" value="<?php echo htmlspecialchars($_SESSION['last_name']); ?>" class="input input-bordered" required />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nickname</span>
                            </label>
                            <input type="text" name="nick_name" value="<?php echo htmlspecialchars($_SESSION['nick_name'] ?? ''); ?>" class="input input-bordered" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" class="input input-bordered" disabled />
                        </div>
                    </div>

                    <div class="divider">Change Password</div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Current Password</span>
                            </label>
                            <input type="password" name="current_password" class="input input-bordered" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">New Password</span>
                            </label>
                            <input type="password" name="new_password" class="input input-bordered" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Confirm New Password</span>
                            </label>
                            <input type="password" name="confirm_password" class="input input-bordered" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="reset" class="btn btn-ghost">Reset</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
        
        // Auto-submit the form when a file is selected
        input.form.submit();
    }
}
</script>

<?php require_once "views/partials/footer.view.php"; ?> 