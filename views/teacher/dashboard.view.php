<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <!-- Teacher Info Card -->
    <div class="card bg-base-100 shadow-xl mb-6" data-aos="fade-up">
        <div class="card-body">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="card-title text-3xl font-bold mb-2">Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>!</h2>
                    <p class="text-base-content/70">Here's an overview of your teaching activity</p>
                </div>
                <div class="flex gap-2">
                    <a href="/profile" class="btn btn-outline btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        My Profile
                    </a>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="stats shadow bg-base-200">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-8 h-8 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="stat-title">Total Classes</div>
                    <div class="stat-value text-primary"><?php echo $teacher_info['total_classes'] ?? 0; ?></div>
                    <div class="stat-desc">Active teaching assignments</div>
                </div>
                
                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-8 h-8 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Total Students</div>
                    <div class="stat-value text-secondary"><?php echo $teacher_info['total_students'] ?? 0; ?></div>
                    <div class="stat-desc">Across all your classes</div>
                </div>
                
                <div class="stat">
                    <div class="stat-figure text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-8 h-8 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Grades Recorded</div>
                    <div class="stat-value text-accent"><?php echo $teacher_info['total_grades'] ?? 0; ?></div>
                    <div class="stat-desc">Last updated today</div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Classes Overview -->
    <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="200">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold mb-4">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Classes Overview
            </h2>

        

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($classes as $class): ?>
                <div class="card bg-base-200 hover:bg-base-300 transition-colors" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body">
                        <h3 class="card-title text-lg font-semibold">
                            <?php echo htmlspecialchars($class['class_name']); ?>
                        </h3>
                        <p class="text-sm opacity-75">
                            <?php echo $class['student_count']; ?> Students
                        </p>
                        <div class="card-actions justify-end mt-4">
                            <a href="/teacher/students/<?php echo $class['id']; ?>" class="btn btn-primary btn-sm">
                                Manage Students
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>

<!-- Include AOS library -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>

<!-- Add this before the closing body tag -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const classSearch = document.getElementById('classSearch');
        const sortClasses = document.getElementById('sortClasses');
        const classGrid = document.querySelector('.grid');
        const classCards = Array.from(classGrid.children);

        function filterAndSortClasses() {
            const searchTerm = classSearch.value.toLowerCase();
            const sortValue = sortClasses.value;

            // Filter classes
            const filteredCards = classCards.filter(card => {
                const className = card.querySelector('.card-title').textContent.toLowerCase();
                return className.includes(searchTerm);
            });

            // Sort classes
            filteredCards.sort((a, b) => {
                const nameA = a.querySelector('.card-title').textContent;
                const nameB = b.querySelector('.card-title').textContent;
                const studentsA = parseInt(a.querySelector('.text-sm').textContent);
                const studentsB = parseInt(b.querySelector('.text-sm').textContent);

                switch(sortValue) {
                    case 'name-asc':
                        return nameA.localeCompare(nameB);
                    case 'name-desc':
                        return nameB.localeCompare(nameA);
                    case 'students-asc':
                        return studentsA - studentsB;
                    case 'students-desc':
                        return studentsB - studentsA;
                    default:
                        return 0;
                }
            });

            // Update the grid
            classGrid.innerHTML = '';
            filteredCards.forEach(card => classGrid.appendChild(card));
        }

        // Add event listeners
        classSearch.addEventListener('input', filterAndSortClasses);
        sortClasses.addEventListener('change', filterAndSortClasses);
    });
</script>
</body>
</html> 