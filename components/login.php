<form action="/login" class="w-full flex justify-center" method="POST">
    <div class="grid bg-base-300 w-[350px] gap-4 p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl text-center font-bold m-2">Login</h1>
        <input type="text" id="nick_name" name="nick_name"
            class="input input-bordered input-md <?php echo isset($error['nick_name']) ? 'input-error' : ''; ?>"
            value="<?php echo $name ?? ''; ?>" required placeholder="Nick name">

        <input type="password" id="password" name="password"
            class="input input-bordered input-md <?php echo isset($error['password']) ? 'input-error' : ''; ?>" required
            placeholder="Password">

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