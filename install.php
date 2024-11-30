<?php
/**
 * ██████╗ ███████╗ ██████╗ ██████╗ ██████╗ ███████╗
 * ██╔══██╗██╔════╝██╔════╝██╔═══██╗██╔══██╗██╔════╝
 * ██║  ██║█████╗  ██║     ██║   ██║██║  ██║█████╗  
 * ██║  ██║██╔══╝  ██║     ██║   ██║██║  ██║██╔══╝  
 * ██████╔╝███████╗╚██████╗╚██████╔╝██████╔╝███████╗
 * ╚═════╝ ╚══════╝ ╚═════╝ ╚═════╝ ╚═════╝ ╚══════╝
 *                                                    
 * DECODE Framework - Installation Script
 * 
 * @package  DECODE Framework
 * @author   Drunkoffjava
 * @version  1.0.0
 * @license  MIT License
 */

// Check if running in CLI
if (php_sapi_name() !== 'cli') {
    die('This script can only be run from the command line.');
}

// Helper functions
function output($message, $type = 'info') {
    $colors = [
        'info' => "\033[0;36m",    // Cyan
        'success' => "\033[0;32m",  // Green
        'error' => "\033[0;31m",    // Red
        'prompt' => "\033[0;33m",   // Yellow
        'reset' => "\033[0m"        // Reset
    ];
    
    echo $colors[$type] . $message . $colors['reset'] . PHP_EOL;
}

function prompt($message) {
    output($message, 'prompt');
    return trim(fgets(STDIN));
}

// Add this function at the top after the helper functions
function showBanner() {
    $banner = "
\033[0;36m██████╗ ███████╗ ██████╗ ██████╗ ██████╗ ███████╗
██╔══██╗██╔════╝██╔════╝██╔═══██╗██╔══██╗██╔════╝
██║  ██║█████╗  ██║     ██║   ██║██║  ██║█████╗  
██║  ██║██╔══╝  ██║     ██║   ██║██║  ██║██╔══╝  
██████╔╝███████╗╚██████╗╚██████╔╝██████╔╝███████╗
╚═════╝ ╚══════╝ ╚═════╝ ╚═════╝ ╚═════╝ ╚══════╝\033[0m

\033[1;33mDECODE Framework - Installation Script
@package  DECODE Framework
@author   Drunkoffjava
@version  1.0.0
@license  MIT License\033[0m
";
    echo $banner . PHP_EOL;
}

// Replace the existing welcome message with:
echo PHP_EOL;
showBanner();
output("=====================================");
echo PHP_EOL;

// Database Configuration
output("Step 1: Database Configuration");
output("---------------------------");
$dbConfig = [
    'host' => prompt("Database Host (default: localhost):") ?: 'localhost',
    'database' => prompt("Database Name:"),
    'username' => prompt("Database Username:"),
    'password' => prompt("Database Password:")
];

// Test database connection
try {
    $dsn = "mysql:host={$dbConfig['host']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbConfig['database']}`");
    $pdo->exec("USE `{$dbConfig['database']}`");
    
    output("Database connection successful!", 'success');
} catch (PDOException $e) {
    output("Database connection failed: " . $e->getMessage(), 'error');
    exit(1);
}

echo PHP_EOL;
output("Step 2: Admin User Setup");
output("----------------------");
$adminUser = [
    'username' => prompt("Admin Username:"),
    'email' => prompt("Admin Email:"),
    'password' => prompt("Admin Password:")
];

// Create necessary tables
output("Creating database tables...");
$tables = [
    "users" => "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(20) DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ",
    "roles" => "
        CREATE TABLE IF NOT EXISTS roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) UNIQUE NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ",
    "permissions" => "
        CREATE TABLE IF NOT EXISTS permissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) UNIQUE NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ",
    "role_permissions" => "
        CREATE TABLE IF NOT EXISTS role_permissions (
            role_id INT,
            permission_id INT,
            PRIMARY KEY (role_id, permission_id)
        )
    "
];

foreach ($tables as $table => $sql) {
    try {
        $pdo->exec($sql);
        output("Created table: $table", 'success');
    } catch (PDOException $e) {
        output("Failed to create table $table: " . $e->getMessage(), 'error');
        exit(1);
    }
}

// Create admin user
try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')");
    $stmt->execute([
        $adminUser['username'],
        $adminUser['email'],
        password_hash($adminUser['password'], PASSWORD_DEFAULT)
    ]);
    output("Admin user created successfully!", 'success');
} catch (PDOException $e) {
    output("Failed to create admin user: " . $e->getMessage(), 'error');
    exit(1);
}

// Create config files
echo PHP_EOL;
output("Step 3: Creating Configuration Files");
output("--------------------------------");

// Create config directory if it doesn't exist
$configDir = __DIR__ . '/config';
if (!is_dir($configDir)) {
    if (mkdir($configDir, 0755, true)) {
        output("Created config directory", 'success');
    } else {
        output("Failed to create config directory", 'error');
        exit(1);
    }
}

// Create decodephp directory structure
$dirs = [
    '/decodephp/themes/default/displays',
    '/decodephp/themes/default/assets/css',
    '/decodephp/themes/default/assets/js',
    '/decodephp/core',
    '/config'
];

foreach ($dirs as $dir) {
    $path = __DIR__ . $dir;
    if (!is_dir($path)) {
        if (mkdir($path, 0755, true)) {
            output("Created directory: $dir", 'success');
        } else {
            output("Failed to create directory: $dir", 'error');
            exit(1);
        }
    }
}

// Database config
$dbConfigContent = "<?php\nreturn " . var_export([
    'driver' => 'mysql',
    'host' => $dbConfig['host'],
    'database' => $dbConfig['database'],
    'username' => $dbConfig['username'],
    'password' => $dbConfig['password'],
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
], true) . ";";

// Create app config
$appConfigContent = "<?php
define('BASE_PATH', '" . dirname($_SERVER['PHP_SELF']) . "');
define('SITE_URL', 'http://' . \$_SERVER['HTTP_HOST'] . BASE_PATH);
";

// Write config files
file_put_contents($configDir . '/database.php', $dbConfigContent);
file_put_contents($configDir . '/app.php', $appConfigContent);
output("Configuration files created!", 'success');

echo PHP_EOL;
output("Installation Complete! 🎉", 'success');
output("You can now log in with:");
output("Username: " . $adminUser['username']);
output("Password: " . str_repeat('*', strlen($adminUser['password'])));
echo PHP_EOL;
output("Thank you for choosing DECODE Framework!"); 