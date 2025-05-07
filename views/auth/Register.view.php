<?php require_once "views/partials/header.view.php"; ?>
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-3xl text-center font-bold mb-8">Register</h1>

    <form action="/registerUser" class="w-full flex justify-center" method="POST">
        <div class="grid bg-base-300 w-[350px] gap-4 p-6 rounded-lg shadow-lg">
            <?php if (isset($error['general'])): ?>
                <div class="alert alert-error shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?php echo htmlspecialchars($error['general']); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">First Name</span>
                </label>
                <input type="text" id="first_name" name="first_name"
                    class="input input-bordered w-full <?php echo isset($error['first_name']) ? 'input-error' : ''; ?>"
                    value="<?php echo htmlspecialchars($first_name ?? ''); ?>" required>
                <?php if (isset($error['first_name'])): ?>
                    <label class="label">
                        <span class="label-text-alt text-error"><?php echo htmlspecialchars($error['first_name']); ?></span>
                    </label>
                <?php endif; ?>
            </div>

            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Last Name</span>
                </label>
                <input type="text" id="last_name" name="last_name"
                    class="input input-bordered w-full <?php echo isset($error['last_name']) ? 'input-error' : ''; ?>"
                    value="<?php echo htmlspecialchars($last_name ?? ''); ?>" required>
                <?php if (isset($error['last_name'])): ?>
                    <label class="label">
                        <span class="label-text-alt text-error"><?php echo htmlspecialchars($error['last_name']); ?></span>
                    </label>
                <?php endif; ?>
            </div>

            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nick Name</span>
                </label>
                <input type="text" id="nick_name" name="nick_name"
                    class="input input-bordered w-full <?php echo isset($error['nick_name']) ? 'input-error' : ''; ?>"
                    value="<?php echo htmlspecialchars($nick_name ?? ''); ?>" required>
                <?php if (isset($error['nick_name'])): ?>
                    <label class="label">
                        <span class="label-text-alt text-error"><?php echo htmlspecialchars($error['nick_name']); ?></span>
                    </label>
                <?php endif; ?>
            </div>

            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" id="password" name="password"
                    class="input input-bordered w-full <?php echo isset($error['password']) ? 'input-error' : ''; ?>"
                    required minlength="8">
                <?php if (isset($error['password'])): ?>
                    <label class="label">
                        <span class="label-text-alt text-error"><?php echo htmlspecialchars($error['password']); ?></span>
                    </label>
                <?php endif; ?>
            </div>

            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Confirm Password</span>
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="input input-bordered w-full <?php echo isset($error['password']) ? 'input-error' : ''; ?>"
                    required minlength="8">
            </div>

            <button type="submit" class="btn btn-primary w-full mt-4">Register</button>
            
            <div class="text-center mt-4">
                <p>Already have an account? <a href="/welcome" class="link link-primary">Login here</a></p>
            </div>
        </div>
    </form>
</div>
<?php require_once "views/partials/footer.view.php"; ?>