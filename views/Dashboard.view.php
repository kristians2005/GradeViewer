<?php require_once "views/partials/header.view.php"; ?>

<div class="w-full grid h-full grid-cols-2">
    <div>
        <div class="flex flex-col justify-center items-center p-8">
            <h1 class="text-4xl font-bold mb-4">Academic Portal</h1>
            <div class="text-lg text-gray-700 text-center max-w-lg">
                <p class="mb-3">
                    Welcome to your comprehensive academic performance management system.
                </p>
                <p class="mb-4">
                    Access your grades, track your progress, and monitor your academic achievements
                    through our secure platform.
                </p>
                <p class="text-gray-600 text-base">
                    Please authenticate to access your academic records.
                </p>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center">
        <?php require_once "components/login.php"; ?>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>