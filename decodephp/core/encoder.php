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
class Encoder {
    private $dev;
    public $display;
    
    // Declare properties explicitly
    public $title = '';
    public $content = '';
    public $active_page = '';
    public $params = [];
    
    function __construct() {
        $this->dev = new DecodeSystem();
        $this->display = $this;
    }

    // Core display functionality
    function page($name, $data = []) {
        // Set display variables
        foreach ($data as $key => $value) {
            $this->display->$key = $value;
        }

        // Make dev and display available to templates
        $dev = $this->dev;
        $display = $this->display;

        // Convert URL paths to view paths
        $view_path = trim($name, '/');
        
        // Load content template
        $template_path = __DIR__ . "/../themes/default/displays/{$view_path}.php";

        if (!file_exists($template_path)) {
            http_response_code(404);
            $template_path = __DIR__ . "/../themes/default/displays/errors/404.php";
            $this->display->title = 'Page Not Found';
        }

        // Load content
        ob_start();
        include $template_path;
        $this->display->content = ob_get_clean();

        // Choose layout based on page type
        if (strpos($name, 'admin/') === 0) {
            include __DIR__ . "/../themes/default/displays/layout/admin.php";
        } else {
            include __DIR__ . "/../themes/default/displays/layout/main.php";
        }
    }

    function display() {
        $path = $this->dev->handle_request();
        
        // If it's not an API request, display the page
        if (!is_array($path)) {
            return $this->page($path);
        }
    }

    // Stats methods used in admin dashboard
    function count_users() {
        return $this->dev->count_users();
    }

    function server_status() {
        return $this->dev->check_server_status();
    }

    function cpu_load() {
        return $this->dev->get_cpu_load();
    }

    function memory_usage() {
        return $this->dev->get_memory_usage();
    }

    // User management methods
    function get_users() {
        return $this->dev->get_users();
    }

    function get_user($id) {
        if (!$id) return null;
        return $this->dev->getfrom('users', '*', "id = " . (int)$id)[0] ?? null;
    }

    // Role management methods
    function get_roles() {
        return $this->dev->get_roles();
    }

    function get_role_permissions($role_id) {
        return $this->dev->get_role_permissions($role_id);
    }

    function get_all_permissions() {
        return $this->dev->getfrom('permissions', '*', '', 'name ASC');
    }

    // Settings management methods
    function get_settings() {
        return $this->dev->get_settings();
    }

    function get_email_settings() {
        return $this->dev->get_email_settings();
    }

    function get_security_settings() {
        return $this->dev->get_security_settings();
    }

    function get_cache_size() {
        return $this->dev->get_cache_size();
    }
} 