<?php
/**
 * CORS Helper - Add this to the top of your PHP API files
 * Enables cross-origin requests from Vercel frontend
 */

// Allow requests from any origin (for development)
// For production, replace * with your Vercel domain
$allowedOrigins = [
    'http://localhost',
    'https://localhost',
    'https://*.vercel.app',
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if ($origin) {
    foreach ($allowedOrigins as $allowed) {
        if (fnmatch($allowed, $origin)) {
            header("Access-Control-Allow-Origin: $origin");
            break;
        }
    }
}

// If no specific origin matched, allow all (for Railway deployment)
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}

// Allow specific methods and headers
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Max-Age: 86400');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Set content type for JSON responses
header('Content-Type: application/json; charset=utf-8');
