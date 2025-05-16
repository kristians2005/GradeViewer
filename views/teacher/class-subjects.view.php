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

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-lg mb-4" data-aos="fade-down">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?php echo htmlspecialchars($_SESSION['success']); ?></span>
            </div>
            <div class="flex-none">
                <button class="btn btn-sm btn-ghost" onclick="this.parentElement.parentElement.remove()">Dismiss</button>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="card bg-base-100 shadow-xl" data-aos="fade-up">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h2 class="card-title text-3xl font-bold">Class Subjects</h2>
                    <p class="text-base-content/70">Manage subjects for <?php echo htmlspecialchars($class['class_name']); ?></p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="/teacher/students/<?php echo $class_id; ?>" class="btn btn-ghost btn-sm sm:btn-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        Back to Students
                    </a>
                    <button class="btn btn-primary btn-sm sm:btn-md" onclick="document.getElementById('addSubjectModal').showModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Subject
                    </button>
                </div>
            </div>

            <?php if (!empty($subjects)): ?>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th class="bg-base-200">Subject Name</th>
                                <th class="bg-base-200">Total Grades</th>
                                <th class="bg-base-200">Average Grade</th>
                                <th class="bg-base-200 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subjects as $subject): ?>
                                <tr>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral text-neutral-content rounded-full w-12">
                                                    <span class="text-xl"><?php echo substr($subject['subject_name'], 0, 1); ?></span>
                                                </div>
                                            </div>
                                            <div class="font-bold"><?php echo htmlspecialchars($subject['subject_name']); ?></div>
                                        </div>
                                    </td>
                                    <td><?php echo $subject['total_grades']; ?></td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <progress class="progress w-20 <?php 
                                                $avg = $subject['subject_average'] ?? 0;
                                                echo $avg >= 7 ? 'progress-success' : 
                                                    ($avg >= 5 ? 'progress-warning' : 'progress-error'); 
                                            ?>" value="<?php echo ($subject['subject_average'] ?? 0) * 10; ?>" max="100"></progress>
                                            <div class="badge <?php 
                                                $avg = $subject['subject_average'] ?? 0;
                                                echo $avg >= 7 ? 'badge-success' : 
                                                    ($avg >= 5 ? 'badge-warning' : 'badge-error'); 
                                            ?> badge-lg">
                                                <?php echo number_format($avg, 2); ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-end gap-2">
                                            <button class="btn btn-secondary btn-sm tooltip" 
                                                    data-tip="Edit Subject"
                                                    onclick="showEditSubjectModal(<?php echo htmlspecialchars(json_encode($subject)); ?>)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form action="/teacher/subject/<?php echo $subject['id']; ?>/delete" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this subject? All associated grades will also be deleted.');">
                                                <button type="submit" class="btn btn-error btn-sm tooltip" data-tip="Delete Subject">
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
                <div class="alert alert-info shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">No subjects added yet</h3>
                            <div class="text-xs">Click the "Add Subject" button to create your first subject</div>
                        </div>
                    </div>
                    <div class="flex-none">
                        <button class="btn btn-sm btn-primary" onclick="document.getElementById('addSubjectModal').showModal()">Add Now</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Subject Modal -->
<dialog id="addSubjectModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Add New Subject</h3>
        <form action="/teacher/subject/add" method="POST">
            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
            
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Subject Name</span>
                </label>
                <input type="text" name="subject_name" class="input input-bordered w-full" required>
            </div>

            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('addSubjectModal').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Subject
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Edit Subject Modal -->
<dialog id="editSubjectModal" class="modal modal-bottom sm:modal-middle">
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
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('editSubjectModal').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Subject
                </button>
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