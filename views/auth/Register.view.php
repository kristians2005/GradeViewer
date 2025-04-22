<?php require_once "views/partials/header.view.php"; ?>
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-3xl text-center font-bold mb-8">Register</h1>

    <form action="/registerUser" class="w-full flex justify-center" method="POST">
        <div class="grid bg-base-300 w-[350px] gap-4 p-6 rounded-lg shadow-lg">
            <input type="text" id="name" name="name"
                class="input input-bordered input-md <?php echo isset($error['name']) ? 'input-error' : ''; ?>"
                value="<?php echo $name ?? ''; ?>" required placeholder="Name">

            <input type="email" id="email"
                class="input input-bordered input-md <?php echo isset($error['email']) ? 'input-error' : ''; ?>"
                name="email" required value="<?php echo $email ?? ''; ?>" placeholder="Email">

            <input type="password"
                class="input input-bordered input-md <?php echo isset($error['password']) ? 'input-error' : ''; ?>"
                id="password" name="password" required value="<?php echo $password ?? ''; ?>" placeholder="Password">

            <input type="password"
                class="input input-bordered input-md <?php echo isset($error['password']) ? 'input-error' : ''; ?>"
                name="password_confirmation" id="password_confirmation" required
                value="<?php echo $password_confirmation ?? ''; ?>" placeholder="Confirm Password">

            <div>
                <?php if (isset($error)): ?>
                    <ul class="grid gap-3">
                        <?php foreach ($error as $key => $value): ?>
                            <li class="text-error text-sm italic"><?php echo $value; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary btn-md mt-2 w-full">Register</button>
        </div>
    </form>
</div>
<?php require_once "views/partials/footer.view.php"; ?>