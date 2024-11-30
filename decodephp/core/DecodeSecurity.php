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
class DecodeSecurity {
    private $decode;
    private $config;
    
    function __construct($decode) {
        $this->decode = $decode;
        $this->config = $this->load_security_config();
    }

    // Auto Security Features
    function auto_secure() {
        // Headers Security
        $this->secure_headers();
        
        // Input Sanitization
        $this->sanitize_inputs();
        
        // CSRF Protection
        $this->csrf_protect();
        
        // XSS Prevention
        $this->xss_protect();
        
        // SQL Injection Prevention
        $this->sql_protect();
        
        // Rate Limiting
        $this->rate_limit();
        
        // Session Security
        $this->secure_session();
    }

    // Secure Headers
    private function secure_headers() {
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
        header("X-Content-Type-Options: nosniff");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Permissions-Policy: geolocation=()");
        
        if($this->config['hsts_enabled']) {
            header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
        }
    }

    // Input Sanitization
    private function sanitize_inputs() {
        $_GET = $this->clean_input($_GET);
        $_POST = $this->clean_input($_POST);
        $_REQUEST = $this->clean_input($_REQUEST);
        $_COOKIE = $this->clean_input($_COOKIE);
    }

    // CSRF Protection
    private function csrf_protect() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || 
                $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                throw new Exception('CSRF token validation failed');
            }
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // XSS Protection
    private function xss_protect() {
        // Output filtering
        ob_start(function($buffer) {
            return htmlspecialchars($buffer, ENT_QUOTES, 'UTF-8');
        });
    }

    // SQL Injection Protection
    private function sql_protect() {
        // Already handled by PDO in DecodeSystem
        // This is an additional layer
        $this->scan_sql_patterns($_REQUEST);
    }

    // Rate Limiting
    private function rate_limit() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $route = $_SERVER['REQUEST_URI'];
        
        $attempts = $this->decode->cache("rate_limit_{$ip}_{$route}") ?? 0;
        
        if ($attempts > $this->config['rate_limit']) {
            throw new Exception('Rate limit exceeded');
        }
        
        $this->decode->cache(
            "rate_limit_{$ip}_{$route}", 
            $attempts + 1, 
            60  // Reset after 1 minute
        );
    }

    // Session Security
    private function secure_session() {
        // Regenerate ID periodically
        if (!isset($_SESSION['_security_last_regen'])) {
            $_SESSION['_security_last_regen'] = time();
        }
        
        if (time() - $_SESSION['_security_last_regen'] > 300) {
            session_regenerate_id(true);
            $_SESSION['_security_last_regen'] = time();
        }
    }

    // Helper Methods
    private function clean_input($data) {
        if (is_array($data)) {
            return array_map([$this, 'clean_input'], $data);
        }
        return htmlspecialchars(strip_tags($data));
    }

    private function scan_sql_patterns($data) {
        $patterns = [
            '/UNION/i',
            '/SELECT.*FROM/i',
            '/INSERT.*INTO/i',
            '/UPDATE.*SET/i',
            '/DELETE.*FROM/i'
        ];
        
        foreach ($data as $key => $value) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    throw new Exception('Potential SQL injection detected');
                }
            }
        }
    }

    private function load_security_config() {
        return [
            'hsts_enabled' => true,
            'rate_limit' => 100,
            'allowed_hosts' => ['example.com'],
            'secure_cookies' => true,
            'password_policy' => [
                'min_length' => 8,
                'require_special' => true,
                'require_number' => true,
                'require_uppercase' => true
            ]
        ];
    }
} 