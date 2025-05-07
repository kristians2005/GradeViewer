<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <!-- Student Info Card -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold mb-4">Student Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="stat bg-base-200 rounded-box">
                    <div class="stat-title">Full Name</div>
                    <div class="stat-value text-lg"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></div>
                </div>
                <?php if (isset($student_info) && $student_info): ?>
                    <div class="stat bg-base-200 rounded-box">
                        <div class="stat-title">Class</div>
                        <div class="stat-value text-lg"><?php echo htmlspecialchars($student_info['class_name'] ?? 'Not assigned'); ?></div>
                    </div>
                    <div class="stat bg-base-200 rounded-box">
                        <div class="stat-title">Class Teacher</div>
                        <div class="stat-value text-lg">
                            <?php 
                            if (isset($student_info['teacher_first_name']) && isset($student_info['teacher_last_name'])) {
                                echo htmlspecialchars($student_info['teacher_first_name'] . ' ' . $student_info['teacher_last_name']);
                            } else {
                                echo 'Not assigned';
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Grades Overview -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-2xl font-bold">Grades Overview</h2>
                <?php if (isset($grades) && !empty($grades)): ?>
                    <div class="form-control w-full max-w-xs">
                        <label class="label">
                            <span class="label-text">Filter by Subject</span>
                        </label>
                        <select class="select select-bordered w-full" id="subjectFilter" onchange="filterSubjects(this.value)">
                            <option value="all">All Subjects</option>
                            <?php
                            $subjects = array_unique(array_column($grades, 'subject_name'));
                            foreach ($subjects as $subject) {
                                echo '<option value="' . htmlspecialchars($subject) . '">' . htmlspecialchars($subject) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (isset($grades) && !empty($grades)): ?>
                <?php
                // Group grades by subject
                $subjectGrades = [];
                foreach ($grades as $grade) {
                    $subjectName = $grade['subject_name'];
                    if (!isset($subjectGrades[$subjectName])) {
                        $subjectGrades[$subjectName] = [];
                    }
                    $subjectGrades[$subjectName][] = $grade;
                }
                ?>

                <div class="grid grid-cols-1 gap-6" id="gradesContainer">
                    <?php foreach ($subjectGrades as $subjectName => $subjectGradeList): ?>
                        <div class="card bg-base-200 subject-card" data-subject="<?php echo htmlspecialchars($subjectName); ?>">
                            <div class="card-body">
                                <h3 class="card-title text-xl mb-4"><?php echo htmlspecialchars($subjectName); ?></h3>
                                
                                <!-- Calculate average for this subject -->
                                <?php
                                $sum = 0;
                                foreach ($subjectGradeList as $grade) {
                                    $sum += $grade['grade'];
                                }
                                $average = count($subjectGradeList) > 0 ? $sum / count($subjectGradeList) : 0;
                                ?>

                                <div class="stats shadow mb-4">
                                    <div class="stat">
                                        <div class="stat-title">Subject Average</div>
                                        <div class="stat-value text-primary"><?php echo number_format($average, 2); ?></div>
                                    </div>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="table table-zebra w-full">
                                        <thead>
                                            <tr>
                                                <th>Grade</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($subjectGradeList as $grade): ?>
                                                <tr>
                                                    <td>
                                                        <div class="badge <?php 
                                                            echo $grade['grade'] >= 7 ? 'badge-success' : 
                                                                ($grade['grade'] >= 5 ? 'badge-warning' : 'badge-error'); 
                                                        ?> badge-lg">
                                                            <?php echo number_format($grade['grade'], 2); ?>
                                                        </div>
                                                    </td>
                                                    <td><?php echo date('d.m.Y', strtotime($grade['grade_date'])); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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

<script>
function filterSubjects(subject) {
    const cards = document.querySelectorAll('.subject-card');
    cards.forEach(card => {
        if (subject === 'all' || card.dataset.subject === subject) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

<?php require_once "views/partials/footer.view.php"; ?> 