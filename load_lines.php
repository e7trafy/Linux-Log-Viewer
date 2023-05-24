<?php

use App\Auth;
use App\FileReader;

require_once 'vendor/autoload.php';
session_start();

if (!Auth::isAuthenticated()) {
    exit;
}

$lines_per_page = 10;
$page =  intval($_POST['page']) ?? 1;
$file_path = $_POST['file_path'] ?? '';

if ($file_path === '') {
    exit;
}

try {
    $fileReader = new FileReader($file_path, $lines_per_page);
} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    exit();
}

$lines = $fileReader->getLines($page);
$total_pages = $fileReader->getTotalPages();

$content = '';
$line_number = ($page - 1) * $lines_per_page + 1;
foreach ($lines as $line) {
    $content .= "<tr><td class='line-number'>" . $line_number . "</td> <td class='lines'>" . htmlspecialchars($line) . "</td> </tr>";
    $line_number++;
}

echo json_encode(['content' => $content, 'total_pages' => $total_pages]);