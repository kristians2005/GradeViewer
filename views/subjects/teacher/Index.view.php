<?php require_once "views/partials/header.view.php"; ?>

<div class="min-h-screen bg-base-200">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Student Management</h1>
            <div class="flex gap-2">
                <a href="/subjects/students/create" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Add Student
                </a>
                <a href="/subjects/grades/create" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    New Grade
                </a>
            </div>
        </div>

        <!-- Students Table Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-null">
                    <table class="table table-zebra w-full ">
                        <thead>
                            <tr>
                                <th class="bg-base-200">Student Name</th>
                                <th class="bg-base-200">Average Grade</th>
                                <th class="bg-base-200 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($students) && !empty($students)): ?>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td class="font-medium">
                                            <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <progress class="progress progress-accent w-20"
                                                    value="<?= $student['average_grade'] * 10 ?>" max="100"></progress>
                                                <span><?= number_format($student['average_grade'], 2) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex justify-end gap-2">
                                                <a href="/subjects/grades/add?student_id=<?= $student['id'] ?>"
                                                    class="btn btn-success btn-sm tooltip" data-tip="Add Grade">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </a>
                                                <a href="/subjects/students/view?id=<?= $student['id'] ?>"
                                                    class="btn btn-info btn-sm tooltip" data-tip="View Grades">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <button class="btn btn-error btn-sm tooltip" data-tip="Remove Student">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4">No students found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Subjects Table Card -->
        <div class="card bg-base-100 shadow-xl mt-8">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Subjects</h2>
                    <a href="/subjects/create" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Subject
                    </a>
                </div>
                <div class="overflow-x-null">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th class="bg-base-200">Subject Name</th>
                                <th class="bg-base-200">Students</th>
                                <th class="bg-base-200">Average Grade</th>
                                <th class="bg-base-200 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($subjects) && !empty($subjects)): ?>
                                <?php foreach ($subjects as $subject): ?>
                                    <tr>
                                        <td class="font-medium">
                                            <?= htmlspecialchars($subject['name']) ?>
                                        </td>
                                        <td><?= $subject['student_count'] ?? 0 ?> students</td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <progress class="progress progress-accent w-20"
                                                    value="<?= ($subject['average_grade'] ?? 0) * 10 ?>" max="100"></progress>
                                                <span><?= number_format($subject['average_grade'] ?? 0, 2) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex justify-end gap-2">
                                                <a href="/subjects/grades/add?subject_id=<?= $subject['id'] ?>"
                                                    class="btn btn-success btn-sm tooltip" data-tip="Add Grade">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </a>
                                                <a href="/subjects/view?id=<?= $subject['id'] ?>"
                                                    class="btn btn-info btn-sm tooltip" data-tip="View Details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4">No subjects found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>