<?php
// 1. Buscamos la clave en tu archivo .env para seguridad
$envFile = __DIR__ . '/.env';
$correctKey = '';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), 'DEPLOY_KEY=') === 0) {
            $correctKey = trim(substr(trim($line), 11));
            break;
        }
    }
}

// 2. Verificamos que quien llama al script tenga la llave
$requestKey = $_GET['key'] ?? '';

if (empty($correctKey) || $requestKey !== $correctKey) {
    http_response_code(403);
    die("⛔ Acceso Denegado. Clave incorrecta o no configurada en .env");
}

// 3. Descomprimimos
$zipFile = 'deploy.zip';

if (!file_exists($zipFile)) {
    die("❌ No encuentro el archivo deploy.zip");
}

$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    
    // Borramos el zip para limpiar
    unlink($zipFile);
    
    echo "✅ ¡Éxito! Archivos descomprimidos y sitio actualizado.";
} else {
    echo "❌ Error: No se pudo abrir el ZIP.";
}
