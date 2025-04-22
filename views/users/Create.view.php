<?php require_once "views/partials/header.view.php"; ?>
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-3xl text-center font-bold mb-8">Create User</h1>

    <form action="/users/store" class="w-full flex justify-center" method="POST">

        <div class="card bg-base-300 w-[350px] p-6 shadow-lg">
            <div class="card-body gap-4">
                <input type="text" id="name" name="name"
                    class="input input-bordered w-full <?php echo isset($error['name']) ? 'input-error' : ''; ?>"
                    value="<?php echo $name ?? ''; ?>" required pattern="[a-zA-Z]{2,50}"
                    title="Ludzū ievadiet vārdu kurā nav skaitļi , un ir no 2-50 burti" placeholder="Name">

                <input type="email" id="email"
                    class="input input-bordered w-full <?php echo isset($error['email']) ? 'input-error' : ''; ?>"
                    name="email" required value="<?php echo $email ?? ''; ?>"
                    title="Jāievada epasts, kas ietver @ zīmi un .com" placeholder="Email">

                <input type="password"
                    class="input input-bordered w-full <?php echo isset($error['password']) ? 'input-error' : ''; ?>"
                    id="password" name="password" required minlength="8" value="<?php echo $password ?? ''; ?>"
                    placeholder="Password">

                <input type="password"
                    class="input input-bordered w-full <?php echo isset($error['password']) ? 'input-error' : ''; ?>"
                    name="password_confirmation" id="password_confirmation" required
                    value="<?php echo $password_confirmation ?? ''; ?>" placeholder="Confirm Password">

                <select id="roles" name="roles" class="select select-bordered w-full">
                    <option value="Worker">Worker</option>
                    <option value="Admin">Admin</option>
                </select>

                <?php if (isset($error)): ?>
                    <div class="text-error">
                        <ul>
                            <?php foreach ($error as $key => $value): ?>
                                <li class="text-sm italic"><?php echo $value; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary w-full">Create User</button>
            </div>
        </div>
</div>
</form>
</div>
<?php require_once "views/partials/footer.view.php"; ?>