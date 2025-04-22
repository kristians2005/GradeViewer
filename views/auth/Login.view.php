<?php require_once "views/partials/header.view.php"; ?>
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-3xl text-center font-bold mb-8">Login</h1>

    <form action="/authenticate" class="w-full flex justify-center" method="POST">
        <div class="grid bg-base-300 w-[350px] gap-4 p-6 rounded-lg shadow-lg">
            <input type="email" id="email" name="email"
                class="input input-bordered input-md <?php echo isset($error['email']) ? 'input-error' : ''; ?>"
                value="<?php echo $email ?? ''; ?>" required title="Jāievada epasts, kas ietver @ zīmi"
                placeholder="Email">

            <input type="password" id="password" name="password"
                class="input input-bordered input-md <?php echo isset($error['password']) ? 'input-error' : ''; ?>"
                required placeholder="Password">

            <div>
                <?php if (isset($error)): ?>
                    <ul>
                        <?php foreach ($error as $key => $value): ?>
                            <li class="text-error text-sm italic"><?php echo $value; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary btn-md mt-2 w-full">Login</button>
        </div>
    </form>
</div>
<?php require_once "views/partials/footer.view.php"; ?>