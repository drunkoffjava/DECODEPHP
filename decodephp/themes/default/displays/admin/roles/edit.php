<?php
$display->title = 'Edit Role';
$display->active_page = 'roles';

// Debug information
echo '<div style="margin: 20px; padding: 20px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px;">';
echo '<h3 style="color: #1f2937; font-weight: bold; margin-bottom: 10px;">Debug Information</h3>';

echo '<div style="margin-bottom: 10px;">';
echo '<strong>Current Path:</strong> ' . $_SERVER['REQUEST_URI'] . '<br>';
echo '<strong>Active Page:</strong> ' . $display->active_page . '<br>';
echo '<strong>Role ID:</strong> ' . ($display->params['id'] ?? 'Not set') . '<br>';
echo '</div>';

echo '<div style="margin-bottom: 10px;">';
echo '<strong>Display Object:</strong><br>';
echo '<pre style="background: #fff; padding: 10px; border-radius: 4px;">';
print_r($display);
echo '</pre>';
echo '</div>';

echo '<div style="margin-bottom: 10px;">';
echo '<strong>Route Params:</strong><br>';
echo '<pre style="background: #fff; padding: 10px; border-radius: 4px;">';
print_r($display->params);
echo '</pre>';
echo '</div>';

// Get role details with debug output
echo '<div style="margin-bottom: 10px;">';
echo '<strong>Role Data:</strong><br>';
$role = $display->get_role_details($display->params['id']);
echo '<pre style="background: #fff; padding: 10px; border-radius: 4px;">';
print_r($role);
echo '</pre>';
echo '</div>';

echo '</div>';
?>

<!-- Main Content -->
<div>
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="px-4 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">Edit Role: <?= ucfirst($role['name']) ?></h1>
            <a href="<?= BASE_PATH ?>/admin/roles" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                Back to Roles
            </a>
        </div>
    </header>

    <!-- Edit Form -->
    <div class="p-6 bg-gray-100">
        <div class="bg-white rounded-lg shadow max-w-3xl mx-auto">
            <form action="<?= BASE_PATH ?>/admin/roles/update/<?= $role['id'] ?>" method="POST" class="p-6">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Role Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="name" type="text" name="name" value="<?= $role['name'] ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Description
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                              id="description" name="description" rows="3"><?= $role['description'] ?></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Permissions
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php 
                        $role_permissions = array_column($display->get_role_permissions($role['id']), 'id');
                        foreach ($display->get_all_permissions() as $permission): 
                        ?>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                            <input type="checkbox" name="permissions[]" value="<?= $permission['id'] ?>" 
                                   <?= in_array($permission['id'], $role_permissions) ? 'checked' : '' ?>
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600"><?= $permission['name'] ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                        Update Role
                    </button>
                    <a href="<?= BASE_PATH ?>/admin/roles" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div> 