<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error shadow-lg mb-4">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-lg mb-4">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?php echo htmlspecialchars($_SESSION['success']); ?></span>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-2xl font-bold">Manage Subjects</h2>
                <div class="flex gap-2">
                    <a href="/teacher/dashboard" class="btn btn-ghost">Back to Dashboard</a>
                    <button class="btn btn-primary" onclick="document.getElementById('addSubjectModal').showModal()">Add Subject</button>
                </div>
            </div>

            <?php if (!empty($subjects)): ?>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Total Grades</th>
                                <th>Average Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subjects as $subject): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                    <td><?php echo $subject['total_grades']; ?></td>
                                    <td>
                                        <div class="badge <?php 
                                            $avg = $subject['subject_average'] ?? 0;
                                            echo $avg >= 7 ? 'badge-success' : 
                                                ($avg >= 5 ? 'badge-warning' : 'badge-error'); 
                                        ?> badge-lg">
                                            <?php echo number_format($avg, 2); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <button class="btn btn-secondary btn-sm" 
                                                    onclick="showEditSubjectModal(<?php echo htmlspecialchars(json_encode($subject)); ?>)">
                                                Edit
                                            </button>
                                            <form action="/teacher/subject/<?php echo $subject['id']; ?>/delete" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this subject?');">
                                                <button type="submit" class="btn btn-error btn-sm">
                                                    Delete
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
                        <span>No subjects added yet.</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Subject Modal -->
<dialog id="addSubjectModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Add New Subject</h3>
        <form action="/teacher/subject/add" method="POST">
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Subject Name</span>
                </label>
                <input type="text" name="subject_name" class="input input-bordered w-full" required>
            </div>

            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('addSubjectModal').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Subject</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Edit Subject Modal -->
<dialog id="editSubjectModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Edit Subject</h3>
        <form action="/teacher/subject/update" method="POST">
            <input type="hidden" name="subject_id" id="editSubjectId">
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Subject Name</span>
                </label>
                <input type="text" name="subject_name" id="editSubjectName" class="input input-bordered w-full" required>
            </div>

            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('editSubjectModal').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Subject</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
function showEditSubjectModal(subject) {
    document.getElementById('editSubjectId').value = subject.id;
    document.getElementById('editSubjectName').value = subject.subject_name;
    document.getElementById('editSubjectModal').showModal();
}
</script>

<?php require_once "views/partials/footer.view.php"; ?> 