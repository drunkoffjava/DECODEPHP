<?php
$display->title = 'Roles & Permissions';
$display->active_page = 'roles';
$roles = $display->get_roles();
$all_permissions = $display->get_all_permissions();
?>

<!-- Main Content -->
<div>
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="px-4 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">Roles & Permissions</h1>
            <button onclick="toggleModal('addRoleModal')" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Create New Role
            </button>
        </div>
    </header>

    <!-- Roles Table -->
    <div class="p-6 bg-gray-100">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($roles as $role): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $role['name'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $role['description'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= in_array($role['name'], ['admin', 'user']) ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= in_array($role['name'], ['admin', 'user']) ? 'System Role' : 'Custom Role' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?php 
                                $permissions = $display->get_role_permissions($role['id']);
                                foreach ($permissions as $perm): ?>
                                    <span class="inline-block px-2 py-1 mr-1 mb-1 text-xs bg-gray-100 rounded">
                                        <?= $perm['name'] ?>
                                    </span>
                                <?php endforeach; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <?php if (!in_array($role['name'], ['admin', 'user'])): ?>
                                    <button onclick="editRole(<?= htmlspecialchars(json_encode($role)) ?>)" 
                                            class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                    <button onclick="confirmDelete(<?= $role['id'] ?>)" 
                                            class="text-red-600 hover:text-red-900">Delete</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div id="addRoleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-semibold text-gray-900">Create New Role</h3>
                <button onclick="toggleModal('addRoleModal')" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form id="addRoleForm" class="mt-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Role Name</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="name" type="text" name="name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="description" name="description" rows="2"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Permissions</label>
                    <div class="mt-2 space-y-2 max-h-48 overflow-y-auto p-2 border rounded">
                        <?php foreach ($all_permissions as $perm): ?>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="permissions[]" value="<?= $perm['id'] ?>" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700"><?= $perm['name'] ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="toggleModal('addRoleModal')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 focus:outline-none">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none">
                        Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleModal(modalId) {
    document.getElementById(modalId).classList.toggle('hidden');
}

// Handle form submission for new role
document.getElementById('addRoleForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch(`<?= BASE_PATH ?>/admin/roles/create`, {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            window.location.reload();
        } else {
            alert('Failed to create role');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred');
    }
});

function editRole(role) {
    // Fill form with role data
    document.getElementById('edit_role_id').value = role.id;
    document.getElementById('edit_name').value = role.name;
    document.getElementById('edit_description').value = role.description;
    
    // Show modal
    toggleModal('editRoleModal');
}

function confirmDelete(roleId) {
    if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        window.location.href = `<?= BASE_PATH ?>/admin/roles/delete/${roleId}`;
    }
}
</script> 