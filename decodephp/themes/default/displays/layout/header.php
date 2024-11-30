<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $display->title ?? 'DECODE Framework' ?></title>
    
    <!-- Meta tags -->
    <meta name="description" content="A powerful yet simple PHP framework designed for modern web development.">
    <meta name="keywords" content="PHP, Framework, Web Development, DECODE">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= BASE_PATH ?>/decodephp/themes/default/assets/images/favicon.ico">
    
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="<?= BASE_PATH ?>/decodephp/themes/default/assets/css/style.css" rel="stylesheet">
    
    <!-- Open Graph tags -->
    <meta property="og:title" content="<?= $display->title ?? 'DECODE Framework' ?>">
    <meta property="og:description" content="A powerful yet simple PHP framework designed for modern web development.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= SITE_URL ?>">
</head>
<body> 
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo (Always visible) -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?= BASE_PATH ?>/" class="logo-text text-2xl">
                        DECODE
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="<?= BASE_PATH ?>/" 
                       class="<?= $display->active_page === 'home' ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' ?> 
                       inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all">
                        Home
                    </a>
                    <a href="<?= BASE_PATH ?>/docs" 
                       class="<?= $display->active_page === 'docs' ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' ?> 
                       inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all">
                        Documentation
                    </a>
                </div>

                <!-- Right side -->
                <div class="flex items-center">
                    <?php if ($dev->is_logged_in()): ?>
                        <!-- User Dropdown -->
                        <div class="relative ml-3">
                            <button onclick="toggleDropdown('userMenu')" 
                                    class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <span class="mr-2"><?= $dev->get_current_user()['username'] ?></span>
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div id="userMenu" 
                                 class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5">
                                <?php if ($dev->has_role('admin')): ?>
                                    <a href="<?= BASE_PATH ?>/admin" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Admin Dashboard
                                    </a>
                                <?php endif; ?>
                                <a href="<?= BASE_PATH ?>/dashboard" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Dashboard
                                </a>
                                <a href="<?= BASE_PATH ?>/profile" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profile
                                </a>
                                <a href="<?= BASE_PATH ?>/dashboard/settings" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Settings
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a href="<?= BASE_PATH ?>/logout" 
                                   class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_PATH ?>/login" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                            Login
                        </a>
                        <a href="<?= BASE_PATH ?>/register" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium ml-3">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <script>
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');

        // Close dropdown when clicking outside
        document.addEventListener('click', function closeDropdown(e) {
            if (!e.target.closest('.relative')) {
                dropdown.classList.add('hidden');
                document.removeEventListener('click', closeDropdown);
            }
        });
    }
    </script>
</body> 