<?php
// Modal component that can be included where needed
function render_modal($id, $title, $content) {
    ?>
    <div id="<?= $id ?>" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900"><?= $title ?></h3>
                <div class="mt-4">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?> 