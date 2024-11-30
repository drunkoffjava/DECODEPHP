<?php include __DIR__ . '/header.php'; ?>

<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <?php include __DIR__ . '/admin_sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <?= $display->content ?? 'No content provided' ?>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?> 