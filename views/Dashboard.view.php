<?php require_once "views/partials/header.view.php"; ?>

<div class="w-full grid h-full grid-cols-2 p-5">
    <div class="mockup-code w-full h-min bg-base-300 p-4 rounded-lg shadow-md">
        <pre data-prefix="$"><code>welcome to klAss

        student:
            nickname: student
            password: 1Password.
        
        teacher:
            nickname: teacher
            password: 1Password.

        every user that is seeded has the same password.
        </code></pre>
    </div>

    <div class="flex justify-center items-center">
        <?php require_once "components/login.php"; ?>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>