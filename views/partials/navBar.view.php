<div class="navbar bg-base-100 shadow-lg fixed z-50">
    <div class="navbar-start">
        <a href="/" class="btn btn-ghost text-xl items-center"> <img src="views\partials\logo.png" class="w-[30px]"
                alt="Stashly">
            Grade Viewer</a>
    </div>
    <div class="navbar-center">
        <?php if (Validator::Role('teacher')): ?>
            <a href="/inventory" class="btn btn-ghost">Inventory</a>
            <a href="/products" class="btn btn-ghost">Products</a>
            <a href="/users" class="btn btn-ghost">Admin</a>
        <?php endif; ?>

    </div>
    <div class="navbar-end">
        <?php if (isset($_SESSION['logged_in'])): ?>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="flex items-center gap-4 cursor-pointer">
                    <span class="text-base btn btn-ghost font-medium flex items-center gap-2">
                        <?php echo htmlspecialchars($_SESSION['user_name']) ?>
                        <div
                            class="badge badge-xs <?php echo $_SESSION['user_role'] === 'Worker' ? 'badge-primary' : 'badge-warning' ?>">
                            <?php echo $_SESSION['user_role'] ?>
                        </div>
                    </span>
                </div>
                <ul tabindex="0" class="dropdown-content bg-base-200 z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <!-- <li><a href="/profile">Profile</a></li> -->
                    <li><a href="/logout">Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="/register" class="btn btn-ghost">Register</a>
            <a href="/login" class="btn btn-ghost">Login</a>
        <?php endif; ?>
    </div>
</div>