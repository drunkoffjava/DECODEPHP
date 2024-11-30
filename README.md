
## Table of Contents
1. [Framework Overview](#overview)
2. [Installation](#installation)
3. [Core Concepts](#concepts)
4. [Quick Start](#quickstart)
5. [Directory Structure](#structure)
6. [Examples](#examples)

## Framework Overview <a name="overview"></a>

DECODE Framework is a lightweight PHP framework designed for rapid development with a focus on simplicity and convention over configuration. It uses a three-layer architecture that separates core functionality, business logic, and presentation.

### Key Features
- Automatic routing based on file structure
- Built-in security features
- Simple database operations
- Role-based authentication
- Clean template system
- Cache management
- API support

## Installation <a name="installation"></a>

1. Clone the repository:
```bash
git clone https://github.com/drunkoffjava/DECODEPHP.git
```

2. Configure your database in `config/database.php`:
```php
return [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'your_database',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8mb4'
];
```

3. Set your base path in `config/app.php`:
```php
define('BASE_PATH', '/your-project-path');
define('SITE_URL', 'http://your-domain.com');
```

## Core Concepts <a name="concepts"></a>

### Three-Layer Architecture

1. **DecodeSystem (Core Layer)**
   - Handles core functionality
   - Database operations
   - Security features
   - Authentication
   ```php
   // Example core functionality
   $dev->getfrom('users', '*', 'active = 1');
   $dev->saveto('posts', ['title' => 'New Post']);
   ```

2. **Encoder (Business Layer)**
   - Processes data for display
   - Handles business logic
   - Manages templates
   ```php
   // Example business logic
   $display->get_users();
   $display->process_upload('image');
   ```

3. **Display (Presentation Layer)**
   - Handles views and templates
   - User interface
   - Data presentation
   ```php
   // In your template files
   $display->title = 'Page Title';
   $display->show_users($users);
   ```

### Automatic Routing

Routes are automatically handled based on your file structure:

```
displays/
├── home.php           → /
├── about.php          → /about
├── admin/
│   ├── index.php      → /admin
│   └── users.php      → /admin/users
└── user/
    └── profile.php    → /user/profile
```

## Quick Start <a name="quickstart"></a>

### Creating a New Page

1. Create a new file in `displays/`:
```php
// displays/blog.php
<?php
$display->title = 'Blog';
$posts = $display->get_posts();
?>

<div class="container">
    <?php foreach($posts as $post): ?>
        <article>
            <h2><?= $post['title'] ?></h2>
            <p><?= $post['content'] ?></p>
        </article>
    <?php endforeach; ?>
</div>
```

2. Add the corresponding method in Encoder:
```php
function get_posts() {
    return $this->dev->getfrom('posts', '*', '', 'created_at DESC');
}
```

### Working with Database

```php
// Create
$id = $dev->saveto('users', [
    'username' => 'john',
    'email' => 'john@example.com'
]);

// Read
$users = $dev->getfrom('users', '*', 'active = 1');

// Update
$dev->update('users', 
    ['status' => 'active'], 
    'id = 1'
);

// Delete
$dev->delete('users', 'id = 1');
```

### Authentication

```php
// Check if user is logged in
if ($dev->is_logged_in()) {
    $user = $dev->get_current_user();
}

// Require authentication
$dev->require_login();

// Check roles
if ($dev->has_role('admin')) {
    // Admin only code
}
```

## Directory Structure <a name="structure"></a>

```
decodephp/
├── config/
│   ├── app.php
│   ├── database.php
│   └── security.php
├── core/
│   ├── DecodeSystem.php
│   ├── encoder.php
│   ├── Database.php
│   └── DecodeSecurity.php
├── themes/
│   └── default/
│       ├── assets/
│       │   ├── css/
│       │   └── js/
│       └── displays/
│           ├── home.php
│           ├── admin/
│           └── user/
└── vendor/
```

## Examples <a name="examples"></a>

### Creating an Admin Panel

```php
// displays/admin/dashboard.php
<?php
$display->title = 'Admin Dashboard';
$stats = $display->get_site_stats();
?>

<div class="dashboard">
    <div class="stats">
        <div>Users: <?= $stats['users'] ?></div>
        <div>Posts: <?= $stats['posts'] ?></div>
    </div>
</div>
```

### Building an API Endpoint

```php
// core/DecodeSystem.php
function api_users_list() {
    return [
        'users' => $this->getfrom('users', '*'),
        'total' => $this->count_users()
    ];
}
