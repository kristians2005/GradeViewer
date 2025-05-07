<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-2xl font-bold">Your Classes</h2>
                <a href="/teacher/dashboard" class="btn btn-ghost">Back to Dashboard</a>
            </div>

            <?php if (!empty($classes)): ?>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Class Name</th>
                                <th>Students</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($classes as $class): ?>
                                <tr>
                                    <td>
                                        <div class="font-bold"><?php echo htmlspecialchars($class['class_name']); ?></div>
                                    </td>
                                    <td>
                                        <div class="badge badge-primary badge-lg"><?php echo $class['student_count']; ?> Students</div>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="/teacher/students/<?php echo $class['id']; ?>" class="btn btn-primary btn-sm">
                                                View Students
                                            </a>
                                            <a href="/teacher/grades/<?php echo $class['id']; ?>" class="btn btn-secondary btn-sm">
                                                Manage Grades
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>No classes assigned yet.</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?> 