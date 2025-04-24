<?php require_once "views/partials/header.view.php"; ?>
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-3xl text-center font-bold mb-8">Register</h1>

    <form action="/registerUser" class="w-full flex justify-center" method="POST">
        <div class="grid bg-base-300 w-[350px] gap-4 p-6 rounded-lg shadow-lg">
            <input type="text" id="first_name" name="first_name"
                class="input input-bordered input-md <?php echo isset($error['first_name']) ? 'input-error' : ''; ?>"
                value="<?php echo $first_name ?? ''; ?>" required placeholder="first_name">

            <input type="text" id="last_name" name="last_name"
                class="input input-bordered input-md <?php echo isset($error['last_name']) ? 'input-error' : ''; ?>"
                value="<?php echo $last_name ?? ''; ?>" required placeholder="last_name">
            <input type="nick_name" id="nick_name"
                class="input input-bordered input-md <?php echo isset($error['nick_name']) ? 'input-error' : ''; ?>"
                name="nick_name" required value="<?php echo $nick_name ?? ''; ?>" placeholder="nick_name">

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