<?php require_once "views/partials/header.view.php"; ?>

<div class="container mx-auto p-4">
    <div class="card bg-base-100 shadow-xl" data-aos="fade-up">
        <div class="card-body">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Edit Student Information</h1>
                    <p class="text-base-content/70">Update student details</p>
                </div>
                <a href="/teacher/students/<?php echo $class_id; ?>" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Students
                </a>
            </div>

            <form action="/teacher/student/<?php echo $student['id']; ?>/update" method="POST" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">First Name</span>
                        </label>
                        <input type="text" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" class="input input-bordered" required />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Last Name</span>
                        </label>
                        <input type="text" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" class="input input-bordered" required />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nickname</span>
                        </label>
                        <input type="text" name="nick_name" value="<?php echo htmlspecialchars($student['nick_name']); ?>" class="input input-bordered" />
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>