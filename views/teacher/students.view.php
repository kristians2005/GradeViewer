<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-2xl font-bold">Class Students</h2>
                <div class="flex gap-2">
                    <a href="/teacher/classes" class="btn btn-ghost">Back to Classes</a>
                    <a href="/teacher/class/<?php echo $class_id; ?>/add-student" class="btn btn-primary">Add Student</a>
                </div>
            </div>

            <?php if (!empty($students)): ?>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Class Average</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td>
                                        <div class="font-bold"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></div>
                                        <?php if ($student['nick_name']): ?>
                                            <div class="text-sm opacity-70"><?php echo htmlspecialchars($student['nick_name']); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="badge <?php 
                                            $avg = $student['class_average'] ?? 0;
                                            echo $avg >= 7 ? 'badge-success' : 
                                                ($avg >= 5 ? 'badge-warning' : 'badge-error'); 
                                        ?> badge-lg">
                                            <?php echo number_format($avg, 2); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="/teacher/grades/<?php echo $student['id']; ?>/<?php echo $class_id; ?>" 
                                               class="btn btn-primary btn-sm">
                                                View Grades
                                            </a>
                                            <button class="btn btn-secondary btn-sm" 
                                                    onclick="showAddGradeModal(<?php echo $student['id']; ?>)">
                                                Add Grade
                                            </button>
                                            <form action="/teacher/class/<?php echo $class_id; ?>/remove-student/<?php echo $student['id']; ?>" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to remove this student from the class?');">
                                                <button type="submit" class="btn btn-error btn-sm">
                                                    Remove
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
                <div class="alert alert-info shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>No students in this class yet.</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Grade Modal -->
<dialog id="addGradeModal" class="modal">
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
                </label>
                <input type="number" name="grade" class="input input-bordered w-full" 
                       min="1" max="10" step="0.1" required>
            </div>

            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Date</span>
                </label>
                <input type="date" name="grade_date" class="input input-bordered w-full" 
                       value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('addGradeModal').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Grade</button>
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