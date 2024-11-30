<?php
$display->title = 'System Settings';
$display->active_page = 'settings';

// Get current settings
$site_settings = $display->get_settings();
$email_settings = $display->get_email_settings();
$security_settings = $display->get_security_settings();
$cache_size = $display->get_cache_size();
?>

<!-- Main Content -->
<div>
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="px-4 py-6">
            <h1 class="text-2xl font-semibold text-gray-800">System Settings</h1>
        </div>
    </header>

    <!-- Success Messages -->
    <?php if (isset($_SESSION['settings_updated'])): ?>
        <div class="mx-6 mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            Settings updated successfully!
        </div>
        <?php unset($_SESSION['settings_updated']); ?>
    <?php endif; ?>

    <!-- Settings Content -->
    <div class="p-6 bg-gray-100">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Site Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Site Settings</h3>
                </div>
                <form action="<?= BASE_PATH ?>/admin/settings" method="POST" class="p-6 space-y-4">
                    <input type="hidden" name="action" value="settings/update">
                    <input type="hidden" name="section" value="site">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Site Name</label>
                        <input type="text" name="site_name" value="<?= $site_settings['site_name'] ?? 'DECODE Framework' ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Site Description</label>
                        <textarea name="site_description" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"><?= $site_settings['site_description'] ?? 'A powerful yet simple PHP framework' ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Maintenance Mode</label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="maintenance_mode" <?= ($site_settings['maintenance_mode'] ?? false) ? 'checked' : '' ?>
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Enable Maintenance Mode</span>
                            </label>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Save Site Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Email Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Email Settings</h3>
                </div>
                <form action="<?= BASE_PATH ?>/admin/settings" method="POST" class="p-6 space-y-4">
                    <input type="hidden" name="action" value="settings/update">
                    <input type="hidden" name="section" value="email">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">SMTP Host</label>
                        <input type="text" name="smtp_host" value="<?= $email_settings['smtp_host'] ?? '' ?>" placeholder="smtp.example.com"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">SMTP Port</label>
                        <input type="number" name="smtp_port" value="<?= $email_settings['smtp_port'] ?? '587' ?>" placeholder="587"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">SMTP Username</label>
                        <input type="text" name="smtp_username" value="<?= $email_settings['smtp_username'] ?? '' ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">SMTP Password</label>
                        <input type="password" name="smtp_password" value="<?= $email_settings['smtp_password'] ?? '' ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Save Email Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Cache Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Cache Settings</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cache Status</label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="enable_cache" <?= ($site_settings['enable_cache'] ?? true) ? 'checked' : '' ?>
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Enable System Cache</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cache Size</label>
                        <p class="text-sm text-gray-500 mt-1">Current cache size: <?= $cache_size ?> MB</p>
                    </div>
                    <div class="pt-4 flex space-x-4">
                        <form action="<?= BASE_PATH ?>/admin/settings" method="POST" class="inline">
                            <input type="hidden" name="action" value="settings/cache/clear">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Clear Cache
                            </button>
                        </form>
                        <form action="<?= BASE_PATH ?>/admin/settings" method="POST" class="inline">
                            <input type="hidden" name="action" value="settings/cache/rebuild">
                            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                                Rebuild Cache
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Security Settings</h3>
                </div>
                <form action="<?= BASE_PATH ?>/admin/settings" method="POST" class="p-6 space-y-4">
                    <input type="hidden" name="action" value="settings/update">
                    <input type="hidden" name="section" value="security">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Login Attempts</label>
                        <input type="number" name="max_login_attempts" value="<?= $security_settings['max_login_attempts'] ?? 5 ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Maximum failed login attempts before lockout</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Session Timeout</label>
                        <input type="number" name="session_timeout" value="<?= $security_settings['session_timeout'] ?? 30 ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Minutes before session expires</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Security Features</label>
                        <div class="mt-2 space-y-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="enable_2fa" <?= ($security_settings['enable_2fa'] ?? false) ? 'checked' : '' ?>
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Enable Two-Factor Authentication</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="force_ssl" <?= ($security_settings['force_ssl'] ?? true) ? 'checked' : '' ?>
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Force SSL</span>
                            </label>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Save Security Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Add success message handling
<?php if (isset($_SESSION['settings_updated'])): ?>
    alert('Settings updated successfully!');
    <?php unset($_SESSION['settings_updated']); ?>
<?php endif; ?>
</script> 