<?php
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header("Location: {$path}");
    exit;
}

function query_string(array $params = []): string
{
    $current = $_GET;
    foreach ($params as $key => $value) {
        if ($value === null) {
            unset($current[$key]);
        } else {
            $current[$key] = $value;
        }
    }
    return http_build_query($current);
}

function flash_set(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function flash_get(string $key): ?string
{
    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $message;
}

function view(string $path, array $data = []): void
{
    extract($data);
    $app = require __DIR__ . '/../../config/app.php';
    ob_start();
    require __DIR__ . '/../Views/' . $path . '.php';
    $content = ob_get_clean();
    require __DIR__ . '/../Views/layout.php';
}

function json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function old(array $old, string $key, string $default = ''): string
{
    return (string) ($old[$key] ?? $default);
}

function selected(string $value, string $current): string
{
    return $value === $current ? 'selected' : '';
}

function log_error(Throwable $e): void
{
    $logDir = __DIR__ . '/../../storage/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }
    $line = '[' . date('Y-m-d H:i:s') . '] ' . get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
    file_put_contents($logDir . '/app.log', $line, FILE_APPEND);
}
