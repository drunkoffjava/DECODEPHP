# DECODE Framework Display Layer Documentation

## Overview
The Display Layer provides a simple, intuitive interface for frontend developers to access data and create user interfaces. The `$display` object is your primary tool for accessing data and rendering content.

## Basic Usage

### Accessing User Data
```php
// Get current user information
$display->username;        // Current user's username
$display->email;          // Current user's email
$display->role;           // Current user's role
$display->profile_pic;    // User's profile picture URL

// Check user status
$display->is_logged_in;   // Returns boolean
$display->is_admin;       // Check if user is admin
```

### Page Content
```php
// Basic page rendering
$display->title = "My Page";              // Set page title
$display->content("about");               // Load about.php display
$display->section("header", ["nav" => true]); // Load section with data
```

### Data Tables
```php
// Generate data tables with built-in pagination
$display->table("users", [
    'columns' => 'username, email, role',
    'filter' => 'active = 1',
    'sort' => 'username ASC',
    'per_page' => 20
]);
```

### Forms
```php
// Generate forms with validation
$display->form([
    'action' => '/submit',
    'method' => 'post',
    'fields' => [
        'username' => ['type' => 'text', 'required' => true],
        'email' => ['type' => 'email', 'required' => true],
        'role' => ['type' => 'select', 'options' => ['user', 'admin']]
    ]
]);
```

### Flash Messages
```php
// Display flash messages
$display->flash();  // Shows and clears any flash messages
```

## Components

### Navigation
```php
// Generate navigation menu
$display->nav([
    'home' => '/',
    'about' => '/about',
    'contact' => '/contact'
]);

// Breadcrumbs
$display->breadcrumbs();
```

### User Interface
```php
// Profile components
$display->avatar();           // User avatar with default fallback
$display->profile_card();     // Complete profile card component

// Notification components
$display->notifications();    // Display user notifications
$display->alert("Success!");  // Show alert message
```

### Admin Components
```php
// Admin-specific displays
$display->admin->dashboard();     // Admin dashboard
$display->admin->users();         // User management
$display->admin->settings();      // Site settings
$display->admin->stats();         // Site statistics
```

## Data Helpers

### Search and Filter
```php
// Search functionality
$display->search_form();          // Generate search form
$display->search_results();       // Display search results
```

### Pagination
```php
// Pagination controls
$display->pagination([
    'total' => 100,
    'per_page' => 20,
    'current' => 1
]);
```

### Media
```php
// Media handling
$display->image("profile.jpg", [
    'size' => 'thumbnail',
    'alt' => 'Profile Picture'
]);

$display->gallery("products");    // Image gallery
```

## Security Features

### CSRF Protection
```php
// Automatically included in forms
$display->csrf_token();          // Manual token generation
```

### Access Control
```php
// Content visibility control
$display->if_logged_in("Content for logged in users");
$display->if_admin("Admin only content");
$display->if_role("editor", "Editor content");
```

## Cache Integration
```php
// Cached content (automatically handled)
$display->cached_section("sidebar", 3600);  // Cache for 1 hour
$display->clear_cache("sidebar");           // Clear specific cache
```

## Theme Customization
```php
// Theme management
$display->theme("dark");         // Switch theme
$display->css("custom.css");     // Add custom CSS
$display->js("app.js");          // Add custom JavaScript
```


# User Dashboard Components

## Quick Stats Display
```php
$display->stats_card([
    'title' => 'Profile Completion',
    'value' => '85%',
    'icon' => 'user'
]);
```

## Activity Feed
```php
$display->activity_feed([
    'limit' => 10,
    'type' => 'user_activity'
]);
```

## Dashboard Widgets
```php
$display->widget('quick_actions');
$display->widget('notifications');
$display->widget('recent_logins');
```

# Layout Components

## Page Headers
```php
$display->header([
    'title' => 'Dashboard',
    'subtitle' => 'Welcome back',
    'actions' => ['new_post', 'settings']
]);
```

## Navigation
```php
$display->sidebar([
    'dashboard' => '/',
    'profile' => '/profile',
    'settings' => '/settings'
]);
```

## Quick Actions
```php
$display->actions([
    'new_post' => '/post/new',
    'edit_profile' => '/profile/edit'
]);
```

## Best Practices

1. **Automatic Data Loading**
   - The Display Layer automatically handles data loading
   - No need to manually query the database
   - Built-in caching for optimal performance

2. **Security**
   - XSS protection is automatic
   - CSRF tokens are automatically included
   - SQL injection protection is built-in

3. **Performance**
   - Use cached sections for static content
   - Let the system handle data pagination
   - Images are automatically optimized

4. **Responsive Design**
   - All components are mobile-friendly
   - Built-in responsive classes
   - Automatic image scaling 
