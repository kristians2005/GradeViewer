<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <div class="card bg-base-100 shadow-xl" data-aos="fade-up">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h2 class="card-title text-3xl font-bold">Student Grades</h2>
                    <p class="text-base-content/70">Track and manage academic performance</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="/teacher/students/<?php echo $class_id; ?>" class="btn btn-ghost btn-sm sm:btn-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        Back to Students
                    </a>
                    <button class="btn btn-primary btn-sm sm:btn-md" onclick="document.getElementById('addGradeModal').showModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Grade
                    </button>
                </div>
            </div>

            <!-- Student Info Card -->
            <div class="bg-base-200 rounded-box p-4 mb-6" data-aos="fade-up" data-aos-delay="100">
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <div class="avatar">
                        <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($student_name ?? 'Student') ?>&background=random" alt="Student Avatar" />
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold"><?php echo htmlspecialchars($student_name ?? 'Student'); ?></h3>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <div class="badge badge-outline">Class: <?php echo htmlspecialchars($class_name ?? 'Unknown'); ?></div>
                            <div class="badge badge-primary">Average: <?php echo number_format($average_grade ?? 0, 2); ?></div>
                            <div class="badge badge-secondary">Total Grades: <?php echo count($grades ?? []); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($grades)): ?>
                <!-- Grade Analytics -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-lg font-semibold">Grade Distribution</h3>
                            <div id="gradesChart" data-grades="[<?php 
                                $gradeValues = array_column($grades, 'grade');
                                echo implode(',', $gradeValues);
                            ?>]" data-subjects="[<?php 
                                $subjectNames = array_map(function($grade) {
                                    return "'" . htmlspecialchars($grade['subject_name']) . "'";
                                }, $grades);
                                echo implode(',', $subjectNames);
                            ?>]"></div>
                        </div>
                    </div>
                    
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-lg font-semibold">Performance Metrics</h3>
                            <div class="stats shadow">
                                <div class="stat">
                                    <div class="stat-title">Highest Grade</div>
                                    <div class="stat-value text-success"><?php echo !empty($gradeValues) ? number_format(max($gradeValues), 2) : 'N/A'; ?></div>
                                    <div class="stat-desc">Top performance</div>
                                </div>
                                
                                <div class="stat">
                                    <div class="stat-title">Lowest Grade</div>
                                    <div class="stat-value text-error"><?php echo !empty($gradeValues) ? number_format(min($gradeValues), 2) : 'N/A'; ?></div>
                                    <div class="stat-desc">Area for improvement</div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <h4 class="font-semibold mb-2">Grade Trend</h4>
                                <div class="flex items-center">
                                    <progress class="progress progress-primary w-full" value="<?php echo ($average_grade ?? 0) * 10; ?>" max="100"></progress>
                                    <span class="ml-2 font-bold"><?php echo number_format($average_grade ?? 0, 2); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto" data-aos="fade-up" data-aos-delay="200">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th class="bg-base-200">Subject</th>
                                <th class="bg-base-200">Grade</th>
                                <th class="bg-base-200">Date</th>
                                <th class="bg-base-200 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($grades as $grade): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($grade['subject_name']); ?></td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <progress class="progress w-20 <?php 
                                                echo $grade['grade'] >= 7 ? 'progress-success' : 
                                                    ($grade['grade'] >= 5 ? 'progress-warning' : 'progress-error'); 
                                            ?>" value="<?php echo $grade['grade'] * 10; ?>" max="100"></progress>
                                            <div class="badge <?php 
                                                echo $grade['grade'] >= 7 ? 'badge-success' : 
                                                    ($grade['grade'] >= 5 ? 'badge-warning' : 'badge-error'); 
                                            ?> badge-lg">
                                                <?php echo number_format($grade['grade'], 2); ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo date('d.m.Y', strtotime($grade['grade_date'])); ?></td>
                                    <td>
                                        <div class="flex justify-end gap-2">
                                            <button class="btn btn-secondary btn-sm tooltip" 
                                                    data-tip="Edit Grade"
                                                    onclick="showEditGradeModal(<?php echo htmlspecialchars(json_encode($grade)); ?>)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-error btn-sm tooltip" 
                                                    data-tip="Delete Grade"
                                                    onclick="confirmDeleteGrade(<?php echo $grade['id']; ?>)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">No grades available yet</h3>
                            <div class="text-xs">Click the "Add Grade" button to record the first grade</div>
                        </div>
                    </div>
                    <div class="flex-none">
                        <button class="btn btn-sm btn-primary" onclick="document.getElementById('addGradeModal').showModal()">Add Now</button>
                    </div>
                </div>
                
                <!-- Empty state illustration -->
                <div class="flex flex-col items-center justify-center py-12" data-aos="fade-up" data-aos-delay="150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-4 text-base-content/50 text-center max-w-md">
                        Start tracking student performance by adding grades. You'll be able to see analytics, 
                        trends, and insights once you have recorded some grades.
                    </p>
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

<!-- Edit Grade Modal -->
<dialog id="editGradeModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Edit Grade</h3>
        <form action="/teacher/updateGrade" method="POST">
            <input type="hidden" name="grade_id" id="editGradeId">
            
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Grade</span>
                    <span class="label-text-alt">1-10 scale</span>
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
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('editGradeModal').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Grade
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Delete Confirmation Modal -->
<dialog id="deleteGradeModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Delete Grade</h3>
        <p class="py-4">Are you sure you want to delete this grade? This action cannot be undone.</p>
        <div class="modal-action">
            <button class="btn btn-ghost" onclick="document.getElementById('deleteGradeModal').close()">Cancel</button>
            <form action="/teacher/deleteGrade/<?php echo $grade['id']; ?>" method="POST" class="inline">
                <button type="submit" class="btn btn-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
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