<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <div class="card bg-base-100 shadow-xl" data-aos="fade-up">
        <div class="card-body">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Add Students to Class</h1>
                    <p class="text-base-content/70">Select students to add to your class</p>
                </div>
                <a href="/teacher/students/<?php echo $class_id; ?>" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Students
                </a>
            </div>

            <!-- Filter Section -->
            <div class="flex flex-col md:flex-row gap-4 mb-6" data-aos="fade-up" data-aos-delay="100">
                <div class="form-control flex-1">
                    <div class="input-group">
                        <input type="text" id="studentSearch" placeholder="Search students by name..." class="input input-bordered w-full" />
                        <button class="btn btn-square">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="form-control">
                    <select id="sortStudents" class="select select-bordered">
                        <option value="name-asc">Name (A-Z)</option>
                        <option value="name-desc">Name (Z-A)</option>
                        <option value="nickname-asc">Nickname (A-Z)</option>
                        <option value="nickname-desc">Nickname (Z-A)</option>
                    </select>
                </div>
            </div>

            <?php if (!empty($available_students)): ?>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Nickname</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <?php foreach ($available_students as $student): ?>
                        <tr class="student-row">
                            <td class="student-name"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                            <td class="student-nickname"><?php echo htmlspecialchars($student['nick_name']); ?></td>
                            <td>
                                <form action="/teacher/class/<?php echo $class_id; ?>/add-student-to-class" method="POST" class="inline">
                                    <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
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
                    <span>No available students found.</span>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const studentSearch = document.getElementById('studentSearch');
        const sortStudents = document.getElementById('sortStudents');
        const studentTableBody = document.getElementById('studentTableBody');
        const studentRows = Array.from(studentTableBody.getElementsByClassName('student-row'));

        function filterAndSortStudents() {
            const searchTerm = studentSearch.value.toLowerCase();
            const sortValue = sortStudents.value;

            // Filter students
            const filteredRows = studentRows.filter(row => {
                const name = row.querySelector('.student-name').textContent.toLowerCase();
                const nickname = row.querySelector('.student-nickname').textContent.toLowerCase();
                return name.includes(searchTerm) || nickname.includes(searchTerm);
            });

            // Sort students
            filteredRows.sort((a, b) => {
                const nameA = a.querySelector('.student-name').textContent;
                const nameB = b.querySelector('.student-name').textContent;
                const nicknameA = a.querySelector('.student-nickname').textContent;
                const nicknameB = b.querySelector('.student-nickname').textContent;

                switch(sortValue) {
                    case 'name-asc':
                        return nameA.localeCompare(nameB);
                    case 'name-desc':
                        return nameB.localeCompare(nameA);
                    case 'nickname-asc':
                        return nicknameA.localeCompare(nicknameB);
                    case 'nickname-desc':
                        return nicknameB.localeCompare(nicknameA);
                    default:
                        return 0;
                }
            });

            // Update the table
            studentTableBody.innerHTML = '';
            filteredRows.forEach(row => studentTableBody.appendChild(row));
        }

        // Add event listeners
        studentSearch.addEventListener('input', filterAndSortStudents);
        sortStudents.addEventListener('change', filterAndSortStudents);
    });
</script>

<?php require_once "views/partials/footer.view.php"; ?> 