<?php
// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load configurations
require_once __DIR__ . '/decodephp/config/app.php';

// Load the framework
require_once __DIR__ . '/decodephp/core/Database.php';
require_once __DIR__ . '/decodephp/core/DecodeSystem.php';
require_once __DIR__ . '/decodephp/core/encoder.php';

// Initialize framework
$dev = new DecodeSystem();
$display = new Encoder();

// Handle the request
$display->display();
