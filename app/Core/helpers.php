<?php

function e(mixed $value): string
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

function render(string $path, array $data = [], string $title = 'Lab05 App'): void
{
    extract($data);

    ob_start();
    require __DIR__ . '/../Views/' . $path . '.php';
    $content = ob_get_clean();

    require __DIR__ . '/../Views/layout.php';
}

function view(string $path, array $data = []): void
{
    render($path, $data);
}

function old(array $data, string $key, mixed $default = ''): mixed
{
    return $data[$key] ?? $default;
}

function log_error(Throwable $e): void
{
    $logDir = __DIR__ . '/../../storage/logs';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }

    $message = sprintf(
        "[%s] %s in %s:%s\n%s\n\n",
        date('Y-m-d H:i:s'),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    );

    file_put_contents($logDir . '/app.log', $message, FILE_APPEND);
}
