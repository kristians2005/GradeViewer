<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-2xl font-bold">Student Grades</h2>
                <div class="flex gap-2">
                    <a href="/teacher/students/<?php echo $class_id; ?>" class="btn btn-ghost">Back to Students</a>
                    <button class="btn btn-primary" onclick="document.getElementById('addGradeModal').showModal()">Add Grade</button>
                </div>
            </div>

            <?php if (!empty($grades)): ?>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Grade</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($grades as $grade): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($grade['subject_name']); ?></td>
                                    <td>
                                        <div class="badge <?php 
                                            echo $grade['grade'] >= 7 ? 'badge-success' : 
                                                ($grade['grade'] >= 5 ? 'badge-warning' : 'badge-error'); 
                                        ?> badge-lg">
                                            <?php echo number_format($grade['grade'], 2); ?>
                                        </div>
                                    </td>
                                    <td><?php echo date('d.m.Y', strtotime($grade['grade_date'])); ?></td>
                                    <td>
                                        <div class="flex gap-2">
                                            <button class="btn btn-secondary btn-sm" 
                                                    onclick="showEditGradeModal(<?php echo htmlspecialchars(json_encode($grade)); ?>)">
                                                Edit
                                            </button>
                                            <button class="btn btn-error btn-sm" 
                                                    onclick="confirmDeleteGrade(<?php echo $grade['id']; ?>)">
                                                Delete
                                            </button>
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
                        <span>No grades available yet.</span>
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
            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
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

<!-- Edit Grade Modal -->
<dialog id="editGradeModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Edit Grade</h3>
        <form action="/teacher/updateGrade" method="POST">
            <input type="hidden" name="grade_id" id="editGradeId">
            
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Grade</span>
                </label>
                <input type="number" name="grade" id="editGrade" class="input input-bordered w-full" 
                       min="1" max="10" step="0.1" required>
            </div>

            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Date</span>
                </label>
                <input type="date" name="grade_date" id="editGradeDate" class="input input-bordered w-full" required>
            </div>

            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('editGradeModal').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Grade</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Delete Confirmation Modal -->
<dialog id="deleteGradeModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Delete Grade</h3>
        <p class="py-4">Are you sure you want to delete this grade? This action cannot be undone.</p>
        <div class="modal-action">
            <button class="btn" onclick="document.getElementById('deleteGradeModal').close()">Cancel</button>
            <form action="/teacher/deleteGrade" method="POST" class="inline">
                <input type="hidden" name="grade_id" id="deleteGradeId">
                <button type="submit" class="btn btn-error">Delete</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
function showEditGradeModal(grade) {
    document.getElementById('editGradeId').value = grade.id;
    document.getElementById('editGrade').value = grade.grade;
    document.getElementById('editGradeDate').value = grade.grade_date;
    document.getElementById('editGradeModal').showModal();
}

function confirmDeleteGrade(gradeId) {
    document.getElementById('deleteGradeId').value = gradeId;
    document.getElementById('deleteGradeModal').showModal();
}
</script>

<?php require_once "views/partials/footer.view.php"; ?> 