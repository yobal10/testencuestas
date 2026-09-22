<?php

declare(strict_types=1);

$projectDir = dirname(__DIR__);
$envFile = $projectDir . DIRECTORY_SEPARATOR . '.env';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method Not Allowed');
}

if (! is_file($envFile)) {
    http_response_code(500);
    exit('Deployment configuration is missing.');
}

$deploySecret = null;
foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
    $line = trim($line);

    if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
        continue;
    }

    [$key, $value] = explode('=', $line, 2);
    if (trim($key) === 'DEPLOY_WEBHOOK_SECRET') {
        $deploySecret = trim($value, " \t\n\r\0\x0B\"");
        break;
    }
}

$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$payload = file_get_contents('php://input') ?: '';
$expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $deploySecret ?? '');

if ($deploySecret === null || $deploySecret === '' || ! hash_equals($expectedSignature, $signature)) {
    http_response_code(403);
    exit('Invalid webhook signature.');
}

$commands = [
    'git -C ' . escapeshellarg($projectDir) . ' fetch origin main',
    'git -C ' . escapeshellarg($projectDir) . ' reset --hard origin/main',
    'php ' . escapeshellarg($projectDir . '/artisan') . ' optimize:clear',
    'php ' . escapeshellarg($projectDir . '/artisan') . ' config:cache',
    'php ' . escapeshellarg($projectDir . '/artisan') . ' route:cache',
    'php ' . escapeshellarg($projectDir . '/artisan') . ' view:cache',
];

$output = [];
foreach ($commands as $command) {
    exec($command . ' 2>&1', $commandOutput, $exitCode);
    $output[] = [
        'command' => preg_replace('/(git -C ).*/', '$1...', $command),
        'exit_code' => $exitCode,
    ];

    if ($exitCode !== 0) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['ok' => false, 'steps' => $output]);
        exit;
    }
}

header('Content-Type: application/json');
echo json_encode(['ok' => true, 'steps' => $output]);
