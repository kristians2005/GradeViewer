<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-2xl font-bold">Add Student to Class</h2>
                <a href="/teacher/students/<?php echo $class_id; ?>" class="btn btn-ghost">Back to Students</a>
            </div>

            <?php if (!empty($available_students)): ?>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Nickname</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($available_students as $student): ?>
                                <tr>
                                    <td>
                                        <div class="font-bold">
                                            <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($student['nick_name']): ?>
                                            <div class="text-sm opacity-70">
                                                <?php echo htmlspecialchars($student['nick_name']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="/teacher/class/<?php echo $class_id; ?>/add-student-to-class" method="POST" class="inline">
                                            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Add to Class
                                            </button>
                                        </form>
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
                        <span>No available students to add to this class.</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?> 