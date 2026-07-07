<?php
header('Content-Type: application/json; charset=utf-8');

$dataFile = __DIR__ . '/data/scores.json';
if (!file_exists($dataFile)) {
    if (!is_dir(dirname($dataFile))) {
        mkdir(dirname($dataFile), 0775, true);
    }
    file_put_contents($dataFile, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function readScores(string $file): array {
    $raw = @file_get_contents($file);
    if ($raw === false || trim($raw) === '') {
        return [];
    }
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

function writeScores(string $file, array $scores): bool {
    return file_put_contents($file, json_encode($scores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['scores' => readScores($dataFile)], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'clear') {
    writeScores($dataFile, []);
    echo json_encode(['message' => '排行榜已清空', 'scores' => []], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

$payload = json_decode(file_get_contents('php://input'), true);
$name = trim((string)($payload['name'] ?? ''));
$score = (int)($payload['score'] ?? 0);

if ($name === '' || mb_strlen($name) > 20) {
    http_response_code(422);
    echo json_encode(['message' => '玩家名稱必填且不可超過 20 字'], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($score < 0) {
    http_response_code(422);
    echo json_encode(['message' => '分數格式錯誤'], JSON_UNESCAPED_UNICODE);
    exit;
}

$scores = readScores($dataFile);
$scores[] = [
    'name' => htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
    'score' => $score,
    'time' => date('Y-m-d H:i:s')
];

usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);
$scores = array_slice($scores, 0, 10);

if (!writeScores($dataFile, $scores)) {
    http_response_code(500);
    echo json_encode(['message' => '無法寫入排行榜，請確認 data 資料夾權限'], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode(['message' => '分數已儲存', 'scores' => $scores], JSON_UNESCAPED_UNICODE);
