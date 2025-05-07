<?php require_once "views/partials/header.view.php"; ?>

<div class="w-full p-4">
    <h2 class="text-xl font-bold mb-4">Mani priekšmeti</h2>

    <div class="mt-4 space-y-4 bg-base-200 p-4 rounded-lg shadow-md">
        <?php if (isset($subjects) && count($subjects) > 0): ?>
            <?php foreach ($subjects as $subject): ?>
                <div class="flex items-center gap-4 p-4 border-b-2 border-base-100 hover:bg-gray-500/10 transition-colors">
                    <div class="w-[150px]">
                        <a href="/subjects/<?php echo $subject['id']; ?>"
                            class="btn btn-soft btn-primary btn-md whitespace-nowrap w-full">
                            <?php echo htmlspecialchars($subject['subject_name']); ?>
                        </a>
                    </div>

                    <progress class="progress progress-success flex-1 h-3"
                        value="<?php echo isset($subject['average_grade']) ? ($subject['average_grade'] * 10) : 0; ?>"
                        max="100">
                    </progress>

                    <div class="flex items-center gap-2 min-w-[100px]">
                        <div class="font-medium">
                            <?php echo isset($subject['average_grade']) ? number_format($subject['average_grade'], 1) : 'N/A'; ?>
                        </div>
                        <div class="text-sm text-gray-500">
                            (<?php echo isset($subject['grade_count']) ? $subject['grade_count'] : '0'; ?>)
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500">Nav atrasti priekšmeti</div>
        <?php endif; ?>
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?>