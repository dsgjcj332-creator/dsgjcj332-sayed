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
$model = 'claude-3-5-sonnet-20241022';

if (file_exists($configPath)) {
  $cfg = require $configPath;
  if (is_array($cfg)) {
    $apiKey = (string)($cfg['CLAUDE_API_KEY'] ?? '');
    $model = (string)($cfg['CLAUDE_MODEL'] ?? $model);
  }
}

if ($apiKey === '') {
  http_response_code(501);
  echo json_encode(['ok' => false, 'error' => 'CLAUDE_API_KEY is not configured'], JSON_UNESCAPED_UNICODE);
  exit;
}

function postClaude($apiKey, $model, $messages, $maxTokens = 1200, $retries = 2) {
  $url = 'https://api.anthropic.com/v1/messages';
  $lastError = '';
  
  for ($i = 0; $i <= $retries; $i++) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
      'x-api-key: ' . $apiKey,
      'anthropic-version: 2023-06-01'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
      'model' => $model,
      'max_tokens' => $maxTokens,
      'temperature' => 0.6,
      'messages' => $messages
    ], JSON_UNESCAPED_UNICODE));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For testing only
    $resp = curl_exec($ch);
    $err = curl_error($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($resp !== false && $err === '' && $code >= 200 && $code < 300) {
      return [$code, $resp, ''];
    }
    
    $lastError = $err ?: "HTTP $code";
    if ($i < $retries) {
      sleep(1); // Wait 1 second before retry
    }
  }
  
  return [0, false, $lastError];
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

$systemPrompt = "أنت مدرب لياقة محترف. مهمتك توليد خطة تمارين مخصصة للمستخدم.

يجب أن تُرجع JSON صالح فقط بدون أي نص إضافي قبل أو بعد.

الهيكل المطلوب:
{
  \"bmiAnalysis\": {
    \"status\": \"وصف الحالة\",
    \"className\": \"text-primary|text-success|text-warning|text-danger\",
    \"recommendation\": \"نصيحة مفصلة\"
  },
  \"exercises\": [
    {
      \"name\": \"اسم التمرين\",
      \"duration\": \"المدة\",
      \"difficulty\": \"سهل جداً|سهل|متوسط|صعب\",
      \"image\": \"emoji واحد\",
      \"benefits\": \"فائدة التمرين\",
      \"aiReason\": \"لماذا اخترت هذا التمرين للمستخدم\"
    }
  ],
  \"tips\": [\"نصيحة 1\", \"نصيحة 2\", ...]
}

قواعد مهمة:
- عدد التمارين بالضبط: {$limit}
- مراعاة الحالة الصحية (تجنب الجري والقفز للسمنة/المفاصل)
- اقترح تمارين حقيقية وآمنة
- استخدم emojis مناسبة للتمارين";

$userPrompt = "بيانات المستخدم:
- الاسم: {$name}
- العمر: {$age} سنة
- النوع: {$gender}
- الوزن: {$weight} كجم
- الطول: {$height} سم
- BMI: {$bmi}
- مستوى اللياقة: {$fitnessLabel}
- الحالة الصحية: {$healthLabel}
- الهدف: {$goalLabel}
- الوقت المتاح: {$timeAvailable} دقيقة يومياً

اكتب JSON فقط:";

[$code, $resp, $err] = postClaude($apiKey, $model, [
  ['role' => 'user', 'content' => $userPrompt]
], 1500);

if ($resp === false || $err) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Claude API request failed: ' . $err], JSON_UNESCAPED_UNICODE);
  exit;
}

if ($code < 200 || $code >= 300) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Claude returned error', 'details' => $resp], JSON_UNESCAPED_UNICODE);
  exit;
}

$decoded = json_decode($resp, true);

if (!is_array($decoded) || !isset($decoded['content'][0]['text'])) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Invalid response from Claude', 'raw' => $resp], JSON_UNESCAPED_UNICODE);
  exit;
}

$text = trim($decoded['content'][0]['text']);

// Extract JSON from response
$start = strpos($text, '{');
$end = strrpos($text, '}');

if ($start === false || $end === false || $end <= $start) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Claude response is not valid JSON', 'raw' => $text], JSON_UNESCAPED_UNICODE);
  exit;
}

$jsonStr = substr($text, $start, $end - $start + 1);
$result = json_decode($jsonStr, true);

if (!is_array($result) || !isset($result['bmiAnalysis']) || !isset($result['exercises']) || !isset($result['tips'])) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Invalid JSON structure from Claude', 'raw' => $jsonStr], JSON_UNESCAPED_UNICODE);
  exit;
}

$out = [
  'bmi' => $bmi,
  'bmiAnalysis' => $result['bmiAnalysis'],
  'exercises' => $result['exercises'],
  'tips' => $result['tips']
];

echo json_encode(['ok' => true, 'results' => $out], JSON_UNESCAPED_UNICODE);
