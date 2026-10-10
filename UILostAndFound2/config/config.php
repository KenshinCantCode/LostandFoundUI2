<?php

require_once __DIR__ . '/load-env.php';
loadEnvironmentFile(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');

date_default_timezone_set('Asia/Manila');

$serverProtocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? 'https://' : 'http://';
$serverHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDirectory = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$scriptFolder = basename($scriptDirectory);
if (in_array($scriptFolder, ['admin', 'api'], true)) {
    $scriptDirectory = dirname($scriptDirectory);
}
if ($scriptDirectory === '/' || $scriptDirectory === '\\' || $scriptDirectory === '.') {
    $scriptDirectory = '';
}

define('SITE_NAME', 'Lost and Found');
define('SITE_URL', $serverProtocol . $serverHost . $scriptDirectory);
define('BASE_PATH', realpath(__DIR__ . '/..'));

define('SMTP_HOST', getenv('SMTP_HOST') ?: '');
define('SMTP_PORT', (int) (getenv('SMTP_PORT') ?: 587));
define('SMTP_ENCRYPTION', strtolower(getenv('SMTP_ENCRYPTION') ?: 'tls'));
define('SMTP_USERNAME', getenv('SMTP_USERNAME') ?: '');
define('SMTP_PASSWORD', getenv('SMTP_PASSWORD') ?: '');
define('SMTP_FROM_EMAIL', getenv('SMTP_FROM_EMAIL') ?: SMTP_USERNAME);
define('SMTP_FROM_NAME', getenv('SMTP_FROM_NAME') ?: 'PHINMA UI Lost And Found');

define('UPLOAD_PATH', BASE_PATH . '/uploads/');
define('ITEMS_UPLOAD', UPLOAD_PATH . 'items/');
define('AVATARS_UPLOAD', UPLOAD_PATH . 'avatars/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024);
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

define('ITEMS_PER_PAGE', 12);

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>