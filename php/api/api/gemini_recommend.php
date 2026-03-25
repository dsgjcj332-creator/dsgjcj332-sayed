<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
  exit;
}

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);

if (!is_array($payload) || !isset($payload['data']) || !is_array($payload['data'])) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Invalid payload'], JSON_UNESCAPED_UNICODE);
  exit;
}

$data = $payload['data'];

$name = trim((string)($data['name'] ?? ''));
$age = (int)($data['age'] ?? 0);
$gender = (string)($data['gender'] ?? '');
$weight = (float)($data['weight'] ?? 0);
$height = (float)($data['height'] ?? 0);
$fitnessLevel = (string)($data['fitnessLevel'] ?? '');
$healthCondition = (string)($data['healthCondition'] ?? '');
$goal = (string)($data['goal'] ?? '');
$timeAvailable = (string)($data['timeAvailable'] ?? '');

if ($weight <= 0 || $height <= 0) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Missing weight/height'], JSON_UNESCAPED_UNICODE);
  exit;
}

$h = $height / 100.0;
$bmiVal = $weight / ($h * $h);
$bmi = number_format($bmiVal, 1, '.', '');

$configPath = __DIR__ . '/../config.local.php';
$apiKey = '';
$model = 'gemini-1.5-flash';

if (file_exists($configPath)) {
  $cfg = require $configPath;
  if (is_array($cfg)) {
    $apiKey = (string)($cfg['GEMINI_API_KEY'] ?? '');
    $model = (string)($cfg['GEMINI_MODEL'] ?? $model);
  }
}

if ($apiKey === '') {
  http_response_code(501);
  echo json_encode(['ok' => false, 'error' => 'GEMINI_API_KEY is not configured'], JSON_UNESCAPED_UNICODE);
  exit;
}

function postJson($url, $body) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  $resp = curl_exec($ch);
  $err = curl_error($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return [$code, $resp, $err];
}

$goalMap = [
  'weight_loss' => 'إنقاص الوزن',
  'muscle_gain' => 'بناء العضلات',
  'general_fitness' => 'لياقة عامة',
  'flexibility' => 'مرونة وتوازن'
];

$fitnessMap = [
  'beginner' => 'مبتدئ',
  'intermediate' => 'متوسط',
  'advanced' => 'متقدم'
];

$healthMap = [
  'normal' => 'سليم',
  'joint_pain' => 'آلام مفاصل',
  'chronic' => 'أمراض مزمنة',
  'injury' => 'إصابة سابقة'
];

$goalLabel = $goalMap[$goal] ?? $goal;
$fitnessLabel = $fitnessMap[$fitnessLevel] ?? $fitnessLevel;
$healthLabel = $healthMap[$healthCondition] ?? $healthCondition;

$limit = 7;
if ($timeAvailable === '15') $limit = 3;
else if ($timeAvailable === '30') $limit = 5;

$schema = [
  'bmiAnalysis' => [
    'status' => 'string',
    'className' => 'text-success|text-warning|text-danger|text-primary',
    'recommendation' => 'string'
  ],
  'exercises' => [
    [
      'name' => 'string',
      'duration' => 'string',
      'difficulty' => 'سهل جداً|سهل|متوسط|صعب',
      'image' => 'single emoji',
      'benefits' => 'string',
      'aiReason' => 'string'
    ]
  ],
  'tips' => ['string']
];

$prompt = "أنت مدرب لياقة. بناءً على بيانات المستخدم التالية، اقترح تمارين حقيقية وآمنة وعملية.\n" .
  "الاسم: {$name}\nالعمر: {$age}\nالنوع: {$gender}\nالوزن: {$weight} كجم\nالطول: {$height} سم\nBMI: {$bmi}\n" .
  "المستوى: {$fitnessLabel}\nالحالة الصحية: {$healthLabel}\nالهدف: {$goalLabel}\nالوقت المتاح يومياً: {$timeAvailable} دقيقة\n\n" .
  "أرجع JSON فقط (بدون أي شرح أو Markdown) بالشكل التالي: \n" .
  json_encode($schema, JSON_UNESCAPED_UNICODE) .
  "\n\nشروط: \n" .
  "- التمارين عددها بالضبط {$limit}.\n" .
  "- راعي الحالة الصحية (خصوصاً آلام المفاصل/السمنة) وتجنب الجري والقفز و HIIT إذا غير مناسب.\n" .
  "- className لازم واحدة من: text-primary, text-success, text-warning, text-danger.\n" .
  "- image لازم emoji واحد فقط.\n";

$url = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($model) . ':generateContent?key=' . rawurlencode($apiKey);

$body = [
  'contents' => [
    ['parts' => [
      ['text' => $prompt]
    ]]
  ],
  'generationConfig' => [
    'temperature' => 0.6,
    'maxOutputTokens' => 1200
  ]
];

[$code, $resp, $err] = postJson($url, $body);

if ($resp === false || $err) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Gemini request failed'], JSON_UNESCAPED_UNICODE);
  exit;
}

if ($code < 200 || $code >= 300) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Gemini returned error', 'details' => $resp], JSON_UNESCAPED_UNICODE);
  exit;
}

$decoded = json_decode($resp, true);
$text = '';

if (is_array($decoded) && isset($decoded['candidates'][0]['content']['parts'])) {
  foreach ($decoded['candidates'][0]['content']['parts'] as $p) {
    if (isset($p['text'])) {
      $text .= $p['text'];
    }
  }
}

$text = trim($text);

$start = strpos($text, '{');
$end = strrpos($text, '}');

if ($start === false || $end === false || $end <= $start) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Gemini response is not JSON', 'raw' => $text], JSON_UNESCAPED_UNICODE);
  exit;
}

$jsonStr = substr($text, $start, $end - $start + 1);
$result = json_decode($jsonStr, true);

if (!is_array($result) || !isset($result['bmiAnalysis']) || !isset($result['exercises']) || !isset($result['tips'])) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Invalid JSON from Gemini', 'raw' => $jsonStr], JSON_UNESCAPED_UNICODE);
  exit;
}

$out = [
  'bmi' => $bmi,
  'bmiAnalysis' => $result['bmiAnalysis'],
  'exercises' => $result['exercises'],
  'tips' => $result['tips']
];

echo json_encode(['ok' => true, 'results' => $out], JSON_UNESCAPED_UNICODE);
