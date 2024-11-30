<?php
/**
 * ██████╗ ███████╗ ██████╗ ██████╗ ██████╗ ███████╗
 * ██╔══██╗██╔════╝██╔════╝██╔═══██╗██╔══██╗██╔════╝
 * ██║  ██║█████╗  ██║     ██║   ██║██║  ██║█████╗  
 * ██║  ██║██╔══╝  ██║     ██║   ██║██║  ██║██╔══╝  
 * ██████╔╝███████╗╚██████╗╚██████╔╝██████╔╝███████╗
 * ╚═════╝ ╚══════╝ ╚═════╝ ╚═════╝ ╚═════╝ ╚══════╝
 *                                                    
 * DECODE Framework - Core System
 * 
 * @package  DECODE Framework
 * @author   Drunkoffjava
 * @version  1.0.0
 * @license  MIT License
 */
class DecodeSystem {
    private static $instance = null;
    private $db;
    private $data = [];
    private $queryCache = [];
    private static $connectionPool = [];
    private static $maxConnections = 10;
    private $route_params = [];
    
    // Core Setup
    function __construct() {
        $this->db = Database::getInstance();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Database Core
    function getfrom($table, $columns = '*', $filter = '', $sort = '') {
        $sql = "SELECT {$columns} FROM {$table}";
        if ($filter) $sql .= " WHERE {$filter}";
        if ($sort) $sql .= " ORDER BY {$sort}";
        
        return $this->db->select($sql);
    }
    
    function saveto($table, $data) {
        return $this->db->insert($table, $data);
    }
    
    function update($table, $data, $where) {
        return $this->db->update($table, $data, $where);
    }
    
    function delete($table, $where) {
        return $this->db->delete($table, $where);
    }

    // Query Builder
    function query($type, $table, $data = null, $where = null) {
        switch(strtoupper($type)) {
            case 'SELECT': return $this->getfrom($table, $data, $where);
            case 'INSERT': return $this->saveto($table, $data);
            case 'UPDATE': return $this->update($table, $data, $where);
            case 'DELETE': return $this->delete($table, $where);
        }
    }

    // Magic Methods
    function __set($name, $value) {
        // Handle property setting
        $this->update('users', [$name => $value], "id = " . ($_SESSION['user_id'] ?? 0));
    }

    // Data Storage
    function store($key, $value) {
        $this->data[$key] = $value;
    }
    
    function retrieve($key) {
        return $this->data[$key] ?? null;
    }

    // Basic Validation
    function validate($data, $rules) {
        foreach ($rules as $field => $rule) {
            if (!isset($data[$field])) return false;
            // Add validation logic
        }
        return true;
    }

    // Error Handling
    function error($message) {
        $this->store('error', $message);
        return false;
    }
    
    function success($message) {
        $this->store('success', $message);
        return true;
    }

    // Search functionality
    function search($table, $columns, $term, $options = []) {
        // Default options
        $options = array_merge([
            'exact' => false,
            'limit' => 10,
            'page' => 1,
            'sort' => '',
            'filter' => ''
        ], $options);

        // Build search conditions
        $conditions = [];
        foreach ((array)$columns as $col) {
            if ($options['exact']) {
                $conditions[] = "{$col} = '{$term}'";
            } else {
                $conditions[] = "{$col} LIKE '%{$term}%'";
            }
        }

        // Combine with additional filters
        $where = '(' . implode(' OR ', $conditions) . ')';
        if ($options['filter']) {
            $where .= ' AND (' . $options['filter'] . ')';
        }

        // Add pagination
        $start = ($options['page'] - 1) * $options['limit'];
        $sql = "SELECT * FROM {$table} WHERE {$where}";
        
        // Add sorting
        if ($options['sort']) {
            $sql .= " ORDER BY {$options['sort']}";
        }
        
        $sql .= " LIMIT {$start}, {$options['limit']}";

        return $this->db->select($sql);
    }

    // Authentication Methods
    function is_logged_in() {
        return isset($_SESSION['user_id']);
    }

    function require_login() {
        if (!$this->is_logged_in()) {
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }
    }

    function get_current_user() {
        return $this->is_logged_in() ? 
            $this->getfrom('users', '*', "id = {$_SESSION['user_id']}")[0] : null;
    }

    function login($username, $password) {
        $user = $this->getfrom('users', '*', "username = '{$username}'")[0] ?? null;
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_time'] = time();
            return true;
        }
        return false;
    }

    function logout() {
        session_destroy();
        // Clear all session data
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        
        // Redirect to home page after logout
        header('Location: ' . BASE_PATH . '/');
        exit;
    }

    // Role Management
    function has_role($role) {
        if (!$this->is_logged_in()) return false;
        $user = $this->get_current_user();
        return $user['role'] === $role;
    }

    function require_role($role) {
        if (!$this->has_role($role)) {
            header('Location: /unauthorized');
            exit;
        }
    }

    // Clean Input
    function clean_input($data) {
        if (is_array($data)) {
            return array_map([$this, 'clean_input'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    // Add these methods to DecodeSystem class

    function get_admin_stats() {
        return [
            'total_users' => $this->count_users(),
            'server_status' => $this->check_server_status(),
            'cpu_load' => $this->get_cpu_load(),
            'memory_usage' => $this->get_memory_usage()
        ];
    }

    function count_users() {
        $result = $this->getfrom('users', 'COUNT(*) as count');
        return $result[0]['count'] ?? 0;
    }

    function check_server_status() {
        return [
            'status' => 'Operational',
            'uptime' => $this->get_server_uptime(),
            'last_check' => date('Y-m-d H:i:s')
        ];
    }

    function get_cpu_load() {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return [
                'load' => round($load[0] * 100),
                'status' => $load[0] < 0.8 ? 'Normal' : 'High'
            ];
        }
        return ['load' => 0, 'status' => 'Unknown'];
    }

    function get_memory_usage() {
        $memory_total = memory_get_peak_usage(true);
        $memory_used = memory_get_usage(true);
        return [
            'used' => round($memory_used / 1024 / 1024, 2),
            'total' => round($memory_total / 1024 / 1024, 2),
            'percentage' => round(($memory_used / $memory_total) * 100, 2)
        ];
    }

    function get_recent_activity($limit = 10) {
        $sql = "SELECT 
                    a.*, 
                    u.username 
                FROM activity_logs a 
                LEFT JOIN users u ON a.user_id = u.id 
                ORDER BY a.created_at DESC 
                LIMIT {$limit}";
                
        return $this->db->select($sql);
    }

    function log_activity($user_id, $action, $details = '') {
        return $this->saveto('activity_logs', [
            'user_id' => $user_id,
            'action' => $action,
            'description' => $details,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    function get_server_uptime() {
        if (PHP_OS === 'Linux') {
            $uptime = shell_exec('uptime -p');
            return $uptime ? trim($uptime) : 'Unknown';
        }
        return 'Unknown';
    }

    // Add these methods to DecodeSystem class

    function get_role_permissions($role_id) {
        $sql = "SELECT p.* 
                FROM permissions p 
                JOIN role_permissions rp ON p.id = rp.permission_id 
                WHERE rp.role_id = ?";
                
        return $this->db->select($sql, [(int)$role_id]);
    }

    function get_all_permissions() {
        return $this->getfrom('permissions', '*', '', 'name ASC');
    }

    function get_role($role_id) {
        $roles = $this->getfrom('roles', '*', "id = {$role_id}");
        return $roles[0] ?? null;
    }

    function get_roles() {
        return $this->getfrom('roles', '*', '', 'name ASC');
    }

    function add_role($data) {
        $role_id = $this->saveto('roles', [
            'name' => $data['name'],
            'description' => $data['description'] ?? ''
        ]);

        if ($role_id && isset($data['permissions'])) {
            foreach ($data['permissions'] as $permission_id) {
                $this->saveto('role_permissions', [
                    'role_id' => $role_id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        return $role_id;
    }

    // Add these methods to DecodeSystem class
    function create_role($data) {
        // Create the role
        $role_id = $this->saveto('roles', [
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        // Add permissions if provided
        if ($role_id && isset($data['permissions'])) {
            foreach ($data['permissions'] as $permission_id) {
                $this->saveto('role_permissions', [
                    'role_id' => $role_id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        return $role_id;
    }

    function update_role($role_id, $data) {
        // Update role details
        $this->update('roles', [
            'name' => $data['name'],
            'description' => $data['description']
        ], "id = $role_id");

        // Update permissions
        if (isset($data['permissions'])) {
            // Remove existing permissions
            $this->delete('role_permissions', "role_id = $role_id");
            
            // Add new permissions
            foreach ($data['permissions'] as $permission_id) {
                $this->saveto('role_permissions', [
                    'role_id' => $role_id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        return true;
    }

    function delete_role($role_id) {
        // Don't allow deletion of system roles
        $role = $this->getfrom('roles', '*', "id = $role_id")[0] ?? null;
        if (!$role || in_array($role['name'], ['admin', 'user'])) {
            return false;
        }

        // Delete role and its permissions
        $this->delete('role_permissions', "role_id = $role_id");
        return $this->delete('roles', "id = $role_id");
    }

    function get_role_details($role_id) {
        $role = $this->getfrom('roles', '*', "id = $role_id")[0] ?? null;
        if ($role) {
            $role['permissions'] = $this->get_role_permissions($role_id);
        }
        return $role;
    }

    // Add these methods to DecodeSystem class

    function get_settings() {
        $settings = $this->getfrom('settings', '*');
        $result = [];
        
        // Convert to key-value array
        foreach ($settings as $setting) {
            $result[$setting['key']] = $setting['value'];
        }
        
        return $result;
    }

    function update_settings($data) {
        foreach ($data as $key => $value) {
            $this->update('settings', ['value' => $value], "`key` = '$key'");
        }
        return true;
    }

    function clear_cache() {
        return $this->delete('cache', '1=1');  // Clear all cache entries
    }

    function rebuild_cache() {
        $this->clear_cache();
        // Add any cache rebuilding logic here
        return true;
    }

    function get_email_settings() {
        return [
            'smtp_host' => $this->get_setting('smtp_host'),
            'smtp_port' => $this->get_setting('smtp_port'),
            'smtp_username' => $this->get_setting('smtp_username'),
            'smtp_password' => $this->get_setting('smtp_password')
        ];
    }

    function get_security_settings() {
        return [
            'max_login_attempts' => $this->get_setting('max_login_attempts', 5),
            'session_timeout' => $this->get_setting('session_timeout', 30),
            'enable_2fa' => $this->get_setting('enable_2fa', false),
            'force_ssl' => $this->get_setting('force_ssl', true)
        ];
    }

    function get_setting($key, $default = null) {
        $setting = $this->getfrom('settings', '*', "`key` = '$key'");
        return $setting ? $setting[0]['value'] : $default;
    }

    function get_cache_size() {
        $result = $this->db->select("SELECT SUM(LENGTH(value)) as size FROM cache")[0];
        return round($result['size'] / 1024 / 1024, 2); // Convert to MB
    }

    // Add these methods to handle settings updates
    function handle_settings_update($data) {
        $section = $_POST['section'] ?? '';
        unset($_POST['section']); // Remove section from data before processing
        
        switch ($section) {
            case 'site':
                return $this->update_site_settings($_POST);
            case 'email':
                return $this->update_email_settings($_POST);
            case 'security':
                return $this->update_security_settings($_POST);
            default:
                return false;
        }
    }

    function update_site_settings($data) {
        // Convert checkbox value to boolean
        $data['maintenance_mode'] = isset($data['maintenance_mode']) ? '1' : '0';
        
        foreach ($data as $key => $value) {
            // Check if setting exists first
            $existing = $this->getfrom('settings', '*', "`key` = '$key'");
            
            if ($existing) {
                // Update existing setting
                $this->update('settings', [
                    'value' => $value
                ], "`key` = '$key'");
            } else {
                // Insert new setting
                $this->saveto('settings', [
                    'key' => $key,
                    'value' => $value,
                    'type' => 'string'
                ]);
            }
        }
        
        $_SESSION['settings_updated'] = true;
        return true;
    }

    function update_email_settings($data) {
        foreach ($data as $key => $value) {
            $this->update('settings', [
                'value' => $value
            ], "`key` = '$key'");
        }
        
        $_SESSION['settings_updated'] = true;
        return true;
    }

    function update_security_settings($data) {
        // Convert checkbox values to boolean
        $data['enable_2fa'] = isset($data['enable_2fa']) ? '1' : '0';
        $data['force_ssl'] = isset($data['force_ssl']) ? '1' : '0';
        
        foreach ($data as $key => $value) {
            $this->update('settings', [
                'value' => $value
            ], "`key` = '$key'");
        }
        
        $_SESSION['settings_updated'] = true;
        return true;
    }

    function handle_cache_action($action) {
        switch ($action) {
            case 'clear':
                $this->clear_cache();
                $_SESSION['cache_cleared'] = true;
                break;
            case 'rebuild':
                $this->rebuild_cache();
                $_SESSION['cache_rebuilt'] = true;
                break;
        }
        
        return true;
    }

    // Add this method to DecodeSystem class
    function handle_post($action, $data = null) {
        // If no data provided, use $_POST
        $data = $data ?? $_POST;
        
        // Handle different post actions
        switch ($action) {
            // Settings actions
            case 'settings/update':
                $result = $this->update_settings($data);
                $_SESSION['settings_updated'] = $result;
                return $this->redirect('/admin/settings');

            case 'settings/cache/clear':
                $result = $this->clear_cache();
                $_SESSION['cache_cleared'] = $result;
                return $this->redirect('/admin/settings');

            case 'settings/cache/rebuild':
                $result = $this->rebuild_cache();
                $_SESSION['cache_rebuilt'] = $result;
                return $this->redirect('/admin/settings');

            // User actions
            case 'users/add':
                $result = $this->add_user($data);
                $_SESSION['user_added'] = $result;
                return $this->redirect('/admin/users');

            case 'users/update':
                $result = $this->update_user($data);
                $_SESSION['user_updated'] = $result;
                return $this->redirect('/admin/users');

            // Role actions
            case 'roles/add':
                $result = $this->add_role($data);
                $_SESSION['role_added'] = $result;
                return $this->redirect('/admin/roles');

            case 'roles/update':
                $result = $this->update_role($data['id'], $data);
                $_SESSION['role_updated'] = $result;
                return $this->redirect('/admin/roles');

            // Auth actions
            case 'login':
                $result = $this->login($data['username'], $data['password']);
                if ($result) {
                    return $this->redirect('/dashboard');
                }
                $_SESSION['login_error'] = true;
                return $this->redirect('/login');

            case 'register':
                $result = $this->register($data);
                if ($result) {
                    return $this->redirect('/dashboard');
                }
                $_SESSION['register_error'] = true;
                return $this->redirect('/register');
        }

        return false;
    }

    // Helper method for redirects
    private function redirect($path) {
        header('Location: ' . BASE_PATH . $path);
        exit;
    }

    // Add to DecodeSystem class
    function handle_request() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = substr($path, strlen(BASE_PATH));
        $path = rtrim($path, '/') ?: '/';
        
        // Handle special actions first
        $special_actions = [
            '/logout' => function() {
                session_destroy();
                $_SESSION = array();
                if (isset($_COOKIE[session_name()])) {
                    setcookie(session_name(), '', time()-42000, '/');
                }
                header('Location: ' . BASE_PATH . '/');
                exit;
            },
            '/login' => function() {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if ($this->login($_POST['username'], $_POST['password'])) {
                        header('Location: ' . BASE_PATH . '/dashboard');
                    } else {
                        header('Location: ' . BASE_PATH . '/login');
                    }
                    exit;
                }
                return 'auth/login';
            },
            '/register' => function() {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if ($this->register($_POST)) {
                        header('Location: ' . BASE_PATH . '/dashboard');
                    } else {
                        header('Location: ' . BASE_PATH . '/register');
                    }
                    exit;
                }
                return 'auth/register';
            }
        ];

        // Check if this is a special action
        if (isset($special_actions[$path])) {
            $result = $special_actions[$path]();
            if ($result) return $result;
            exit;
        }

        // Get all available routes by scanning displays directory
        $display_root = __DIR__ . "/../themes/default/displays";
        $available_routes = $this->scan_display_directory($display_root);

        // Convert request path to potential display paths
        $display_path = $path === '/' ? 'home' : trim($path, '/');

        // Check if it's a POST request to any valid route
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle POST based on the URL pattern
            $this->handle_action($path);
            exit;
        }

        // For GET requests, check if path exists in our available routes
        if (in_array($display_path, $available_routes)) {
            // Check admin access for admin routes
            if (strpos($display_path, 'admin/') === 0) {
                if (!$this->is_logged_in() || !$this->has_role('admin')) {
                    header('Location: ' . BASE_PATH . '/login');
                    exit;
                }
            }
            return $display_path;
        }

        // If path not found, check if it's a directory with index
        if (in_array($display_path . '/index', $available_routes)) {
            return $display_path . '/index';
        }

        return 'errors/404';
    }

    private function scan_display_directory($dir, $prefix = '') {
        $routes = [];
        $files = scandir($dir);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            $path = $dir . '/' . $file;
            $route = $prefix . ($prefix ? '/' : '') . basename($file, '.php');

            if (is_dir($path)) {
                // Recursively scan subdirectories
                $routes = array_merge($routes, $this->scan_display_directory($path, $route));
            } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $routes[] = $route;
            }
        }

        return $routes;
    }

    private function handle_action($path) {
        $segments = explode('/', trim($path, '/'));
        $action = array_pop($segments); // Get the action (last segment)
        $context = array_pop($segments); // Get the context (second to last segment)
        
        // Try to call matching method if it exists
        $method = "{$action}_{$context}";
        if (method_exists($this, $method)) {
            $this->$method($_POST);
        }
        
        // Redirect back to the page
        header('Location: ' . BASE_PATH . '/' . implode('/', $segments));
    }

    // Handle API requests
    private function handle_api_request($segments) {
        $resource = $segments[0] ?? '';
        $action = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        // Check if method exists
        $method = "{$resource}_{$action}";
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $params);
        }

        // Default CRUD operations
        switch ($action) {
            case 'list':
                return $this->getfrom($resource);
            case 'get':
                return $this->getfrom($resource, '*', "id = " . ($params[0] ?? 0))[0] ?? null;
            case 'create':
                return $this->saveto($resource, $_POST);
            case 'update':
                return $this->update($resource, $_POST, "id = " . ($params[0] ?? 0));
            case 'delete':
                return $this->delete($resource, "id = " . ($params[0] ?? 0));
        }

        return ['error' => 'Method not found'];
    }

    // Add this method to DecodeSystem class
    function get_users() {
        // Get all users ordered by username
        return $this->getfrom('users', '*', '', 'username ASC');
    }

}