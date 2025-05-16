<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error shadow-lg mb-4" data-aos="fade-down">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
            <div class="flex-none">
                <button class="btn btn-sm btn-ghost" onclick="this.parentElement.parentElement.remove()">Dismiss</button>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card bg-base-100 shadow-xl" data-aos="fade-up">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h2 class="card-title text-3xl font-bold">Class Students</h2>
                    <p class="text-base-content/70">Manage students in your class</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="/teacher/classes" class="btn btn-ghost btn-sm sm:btn-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        Back to Classes
                    </a>
                    <a href="/teacher/class/<?php echo $class_id; ?>/subjects" class="btn btn-primary btn-sm sm:btn-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Manage Subjects
                    </a>
                    <a href="/teacher/class/<?php echo $class_id; ?>/add-student" class="btn btn-primary btn-sm sm:btn-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Add Student
                    </a>
                </div>
            </div>

            <?php if (!empty($students)): ?>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th class="bg-base-200">Student Name</th>
                                <th class="bg-base-200">Class Average</th>
                                <th class="bg-base-200 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12">
                                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($student['first_name'] . '+' . $student['last_name']) ?>&background=random" alt="Avatar" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></div>
                                                <?php if ($student['nick_name']): ?>
                                                    <div class="text-sm opacity-70"><?php echo htmlspecialchars($student['nick_name']); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <progress class="progress progress-accent w-20"
                                                value="<?= ($student['class_average'] ?? 0) * 10 ?>" max="100"></progress>
                                            <div class="badge <?php 
                                                $avg = $student['class_average'] ?? 0;
                                                echo $avg >= 7 ? 'badge-success' : 
                                                    ($avg >= 5 ? 'badge-warning' : 'badge-error'); 
                                            ?> badge-lg">
                                                <?php echo number_format($avg, 2); ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-end gap-2">
                                            <a href="/teacher/grades/<?php echo $student['id']; ?>/<?php echo $class_id; ?>" 
                                               class="btn btn-primary btn-sm tooltip" data-tip="View Grades">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="/teacher/student/<?php echo $student['id']; ?>/edit" 
                                               class="btn btn-info btn-sm tooltip" data-tip="Edit Student">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button class="btn btn-secondary btn-sm tooltip" 
                                                    data-tip="Add Grade"
                                                    onclick="showAddGradeModal(<?php echo $student['id']; ?>)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                            <form action="/teacher/class/<?php echo $class_id; ?>/remove-student/<?php echo $student['id']; ?>" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to remove this student from the class?');">
                                                <button type="submit" class="btn btn-error btn-sm tooltip" data-tip="Remove Student">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info shadow-lg" data-aos="fade-up">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">No students in this class yet</h3>
                            <div class="text-xs">Click the "Add Student" button to get started</div>
                        </div>
                    </div>
                    <div class="flex-none">
                        <a href="/teacher/class/<?php echo $class_id; ?>/add-student" class="btn btn-sm btn-primary">Add Now</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Grade Modal -->
<dialog id="addGradeModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Add New Grade</h3>
        <form action="/teacher/addGrade" method="POST">
            <input type="hidden" name="student_id" id="modalStudentId">
            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
            
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Subject</span>
                </label>
                <select name="subject_id" class="select select-bordered w-full" required>
                    <option value="">Select Subject</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?php echo $subject['id']; ?>">
                            <?php echo htmlspecialchars($subject['subject_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Grade</span>
                    <span class="label-text-alt">1-10 scale</span>
                </label>
                <input type="number" name="grade" class="input input-bordered w-full" 
                       min="1" max="10" step="0.1" required>
                <label class="label">
                    <span class="label-text-alt">Minimum: 1</span>
                    <span class="label-text-alt">Maximum: 10</span>
                </label>
            </div>

            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Date</span>
                </label>
                <input type="date" name="grade_date" class="input input-bordered w-full" 
                       value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('addGradeModal').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Grade
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
function showAddGradeModal(studentId) {
    document.getElementById('modalStudentId').value = studentId;
    document.getElementById('addGradeModal').showModal();
}
</script>

<?php require_once "views/partials/footer.view.php"; ?> 