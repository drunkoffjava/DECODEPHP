<?php
$display->title = 'Documentation';
$display->active_page = 'docs';
?>

<div class="min-h-screen bg-gray-100 pt-16">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex gap-6">
            <!-- Left Sidebar Navigation -->
            <div class="w-64 flex-shrink-0">
                <div class="bg-white shadow rounded-lg p-4 sticky top-20">
                    <nav class="space-y-1">
                        <a href="#getting-started" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-50 text-gray-900">
                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Getting Started
                        </a>
                        <a href="#routing" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-50 text-gray-900">
                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            Routing
                        </a>
                        <a href="#display" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-50 text-gray-900">
                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Display System
                        </a>
                        <a href="#database" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-50 text-gray-900">
                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                            </svg>
                            Database
                        </a>
                        <a href="#auth" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-50 text-gray-900">
                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Authentication
                        </a>
                        <a href="#security" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-50 text-gray-900">
                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Security
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-8">
                        <!-- Header -->
                        <div class="mb-12">
                            <h1 class="text-4xl font-bold text-gray-900">DECODE Framework</h1>
                            <p class="mt-4 text-lg text-gray-600">A simple yet powerful PHP framework focused on convention over configuration.</p>
                        </div>

                        <!-- Getting Started Section -->
                        <section id="getting-started" class="mb-16">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Getting Started</h2>
                            <div class="prose max-w-none">
                                <h3 class="text-xl font-semibold mb-4">Installation</h3>
                                <ol class="list-decimal list-inside mb-6">
                                    <li class="mb-2">Clone the repository</li>
                                    <li class="mb-2">Configure your database in config/app.php</li>
                                    <li class="mb-2">Run install.php to set up the database</li>
                                </ol>

                                <h3 class="text-xl font-semibold mb-4">File Structure</h3>
                                <pre class="bg-gray-50 p-4 rounded-lg text-sm mb-6">
decodephp/
├── themes/
│   └── default/
│       └── displays/          # All your views go here
│           ├── home.php       # Homepage (/)
│           ├── admin/         # Admin pages (/admin/*)
│           ├── auth/          # Auth pages (/auth/*)
│           └── user/          # User pages (/user/*)
├── core/
│   ├── DecodeSystem.php      # Core functionality
│   └── encoder.php           # Display handling</pre>
                            </div>
                        </section>

                        <!-- Routing Section -->
                        <section id="routing" class="mb-16">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Routing</h2>
                            <div class="prose max-w-none">
                                <p class="mb-4">Routes are automatically handled based on your file structure. No configuration needed!</p>
                                
                                <h3 class="text-xl font-semibold mb-4">Examples</h3>
                                <ul class="list-disc list-inside mb-6">
                                    <li class="mb-2"><code>/</code> → displays/home.php</li>
                                    <li class="mb-2"><code>/admin</code> → displays/admin/index.php</li>
                                    <li class="mb-2"><code>/admin/users</code> → displays/admin/users/index.php</li>
                                    <li class="mb-2"><code>/user/settings</code> → displays/user/settings.php</li>
                                </ul>
                            </div>
                        </section>

                        <!-- Display System Section -->
                        <section id="display" class="mb-16">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Display System</h2>
                            <div class="prose max-w-none">
                                <p class="mb-4">The display system uses two main objects:</p>

                                <h3 class="text-xl font-semibold mb-4">$display Object</h3>
                                <pre class="bg-gray-50 p-4 rounded-lg text-sm mb-6">
// In your view files:
$display->title = 'Page Title';
$display->active_page = 'current-section';

// Get data for views
$users = $display->get_users();
$roles = $display->get_roles();</pre>

                                <h3 class="text-xl font-semibold mb-4">$dev Object</h3>
                                <pre class="bg-gray-50 p-4 rounded-lg text-sm mb-6">
// Core functionality
if ($dev->is_logged_in()) {
    $user = $dev->get_current_user();
}

// Database operations
$users = $dev->getfrom('users', '*');</pre>
                            </div>
                        </section>

                        <!-- Database Section -->
                        <section id="database" class="mb-16">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Database Operations</h2>
                            <div class="prose max-w-none">
                                <pre class="bg-gray-50 p-4 rounded-lg text-sm mb-6">
// Get data
$users = $dev->getfrom('users', '*', 'active = 1', 'username ASC');

// Insert data
$dev->saveto('users', [
    'username' => 'john',
    'email' => 'john@example.com'
]);

// Update data
$dev->update('users', 
    ['status' => 'active'], 
    'id = 1'
);

// Delete data
$dev->delete('users', 'id = 1');</pre>
                            </div>
                        </section>

                        <!-- Authentication Section -->
                        <section id="auth" class="mb-16">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Authentication</h2>
                            <div class="prose max-w-none">
                                <pre class="bg-gray-50 p-4 rounded-lg text-sm mb-6">
// Check authentication
if ($dev->is_logged_in()) {
    $user = $dev->get_current_user();
}

// Check roles
if ($dev->has_role('admin')) {
    // Admin only code
}

// Require authentication
$dev->require_login();

// Require specific role
$dev->require_role('admin');</pre>
                            </div>
                        </section>

                        <!-- Security Section -->
                        <section id="security" class="mb-16">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Security</h2>
                            <div class="prose max-w-none">
                                <ul class="list-disc list-inside mb-6">
                                    <li class="mb-2">Automatic XSS Protection</li>
                                    <li class="mb-2">SQL Injection Prevention</li>
                                    <li class="mb-2">CSRF Protection</li>
                                    <li class="mb-2">Session Security</li>
                                    <li class="mb-2">Input Sanitization</li>
                                </ul>

                                <pre class="bg-gray-50 p-4 rounded-lg text-sm mb-6">
// Clean input data
$clean = $dev->clean_input($_POST['data']);

// All database operations are automatically secured</pre>
                            </div>
                        </section>

                        <!-- Example Project Section -->
                        <section id="example" class="mb-16">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Example Project: InstaDecode</h2>
                            <div class="prose max-w-none">
                                <p class="mb-4">Let's build a simple Instagram clone to demonstrate how everything works together.</p>

                                <!-- Code Box Component -->
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <div class="bg-gray-100 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                                        <span class="font-mono text-sm text-gray-600">Database Structure</span>
                                        <button class="text-gray-500 hover:text-gray-700" onclick="copyCode('db-code')">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="p-4 bg-gray-50">
                                        <pre id="db-code" class="text-sm text-gray-800">CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    image_url VARCHAR(255),
    caption TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);</pre>
                                    </div>
                                </div>

                                <!-- File Structure -->
                                <div class="border border-gray-200 rounded-lg overflow-hidden mt-6">
                                    <div class="bg-gray-100 px-4 py-2 border-b border-gray-200">
                                        <span class="font-mono text-sm text-gray-600">Project Structure</span>
                                    </div>
                                    <div class="p-4 bg-gray-50">
                                        <pre class="text-sm text-gray-800">decodephp/themes/default/displays/
├── home.php                # Feed page
├── post/
│   ├── create.php         # New post form
│   ├── view.php           # Single post view
│   └── edit.php           # Edit post
└── profile/
    └── index.php          # User profile</pre>
                                    </div>
                                </div>

                                <!-- Example Code -->
                                <div class="border border-gray-200 rounded-lg overflow-hidden mt-6">
                                    <div class="bg-gray-100 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                                        <span class="font-mono text-sm text-gray-600">home.php - Feed Page</span>
                                        <button class="text-gray-500 hover:text-gray-700" onclick="copyCode('feed-code')">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="p-4 bg-gray-50">
                                        <pre id="feed-code" class="text-sm text-gray-800">$display->title = 'Feed';
$display->active_page = 'home';

// Get posts with user info and likes count
$posts = $dev->query("
    SELECT p.*, u.username, 
           COUNT(DISTINCT l.id) as likes_count,
           COUNT(DISTINCT c.id) as comments_count
    FROM posts p
    JOIN users u ON p.user_id = u.id
    LEFT JOIN likes l ON p.id = l.post_id
    LEFT JOIN comments c ON p.id = c.post_id
    GROUP BY p.id
    ORDER BY p.created_at DESC
");</pre>
                                    </div>
                                </div>

                                <!-- Add copy functionality -->
                                <script>
                                function copyCode(elementId) {
                                    const el = document.getElementById(elementId);
                                    const text = el.textContent;
                                    navigator.clipboard.writeText(text).then(() => {
                                        // Show feedback
                                        const button = el.parentElement.previousElementSibling.querySelector('button');
                                        const originalHTML = button.innerHTML;
                                        button.innerHTML = '<span class="text-green-500">Copied!</span>';
                                        setTimeout(() => {
                                            button.innerHTML = originalHTML;
                                        }, 2000);
                                    });
                                }
                                </script>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <!-- Right TOC -->
            <div class="w-64 flex-shrink-0">
                <div class="bg-white shadow rounded-lg p-4 sticky top-20">
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3">On This Page</h4>
                    <nav class="space-y-1 text-sm">
                        <a href="#installation" class="block text-gray-600 hover:text-gray-900">Installation</a>
                        <a href="#file-structure" class="block text-gray-600 hover:text-gray-900">File Structure</a>
                        <a href="#routing-examples" class="block text-gray-600 hover:text-gray-900">Routing Examples</a>
                        <a href="#special-routes" class="block text-gray-600 hover:text-gray-900">Special Routes</a>
                        <a href="#display-object" class="block text-gray-600 hover:text-gray-900">Display Object</a>
                        <a href="#dev-object" class="block text-gray-600 hover:text-gray-900">Dev Object</a>
                        <a href="#database-operations" class="block text-gray-600 hover:text-gray-900">Database Operations</a>
                        <a href="#auth-system" class="block text-gray-600 hover:text-gray-900">Auth System</a>
                        <a href="#security-features" class="block text-gray-600 hover:text-gray-900">Security Features</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Highlight current section in navigation
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (pageYOffset >= sectionTop - 60) {
            currentSection = section.getAttribute('id');
        }
    });

    document.querySelectorAll('nav a').forEach(link => {
        link.classList.remove('bg-gray-50', 'text-blue-600');
        if (link.getAttribute('href') === `#${currentSection}`) {
            link.classList.add('bg-gray-50', 'text-blue-600');
        }
    });
});
</script> 