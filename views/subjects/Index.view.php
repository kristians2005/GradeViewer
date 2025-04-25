<?php require_once "views/partials/header.view.php"; ?>

<div class="w-full p-4">
<<<<<<< Updated upstream:views/subjects/Index.view.php


    <div class="mt-4 space-y-4 bg-base-200 p-4 rounded-lg shadow-md">
        <div class="flex items-center gap-4 border-b-2 pb-2 border-base-100">
            <div class="w-48">Valsts aizsardzības mācība</div>
            <progress class="progress progress-success flex-1" value="12" max="100"></progress>
            <div class="w-12 text-right">9.0</div>
        </div>

=======
    <h2 class="text-xl font-bold mb-4">Mani priekšmeti</h2>
    
    <div class="mt-4 space-y-4 bg-base-200 p-4 rounded-lg shadow-md">
        <?php if (isset($subjects) && count($subjects) > 0): ?>
            <?php foreach ($subjects as $subject): ?>
                <a href="/subjects/<?php echo $subject['id']; ?>">
                <div class="flex items-center gap-4 border-b-2 pb-2 border-base-100 hover:bg-gray-500">
                    <div class="w-48">
               
                            <?php echo htmlspecialchars($subject['subject_name']); ?>
                     
                    </div>
                    <?php if (isset($subject['average_grade']) && $subject['average_grade'] !== null): ?>
                        <progress class="progress progress-success flex-1 h-4" 
                                 value="<?php echo $subject['average_grade'] * 10; ?>" max="100"></progress>
                        <div class="w-12 text-right"><?php echo number_format($subject['average_grade'], 1); ?></div>
                        <div class="text-xs text-gray-500">(<?php echo $subject['grade_count']; ?> atzīmes)</div>
                    <?php else: ?>
                        <progress class="progress progress-success flex-1 h-4" value="0" max="100"></progress>
                        <div class="w-12 text-right">N/A</div>
                        <div class="text-xs text-gray-500">(0 atzīmes)</div>
                    <?php endif; ?>
                </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-4">Nav atrasti priekšmeti</div>
        <?php endif; ?>
>>>>>>> Stashed changes:views/subjects/student/Index.view.php
    </div>
</div>

<?php require_once "views/partials/footer.view.php"; ?> 