<dialog id="addSubjectModal" class="modal">
    <div class="modal-box">
        <h3 class="text-lg font-bold mb-4">Add Subject</h3>

        <form action="/subjects/assign" method="POST" class="space-y-4 ">
            <div class="grid gap-4 overflow-y-auto max-h-[40vh]">
                <?php if (isset($allSubjects) && !empty($allSubjects)): ?>
                    <?php foreach ($allSubjects as $subject): ?>
                        <div class="flex items-center gap-4 p-3 border border-base-300 rounded-lg hover:bg-base-200">
                            <label class="flex items-center gap-3 cursor-pointer w-full">
                                <input type="checkbox" name="subjects[]" value="<?= $subject['id'] ?>"
                                    class="checkbox checkbox-primary">
                                <span class="font-medium"><?= htmlspecialchars($subject['subject_name']) ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-500">No subjects available</p>
                <?php endif; ?>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Add Selected Subjects</button>
                <button type="button" class="btn" onclick="addSubjectModal.close()">Cancel</button>
            </div>
        </form>
    </div>
</dialog>