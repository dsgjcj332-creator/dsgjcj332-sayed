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

// BMI Analysis
if ($bmi < 18.5) {
  $bmiAnalysis = ['status' => 'نحيف', 'className' => 'text-primary', 'recommendation' => 'تحتاج لتمارين بناء عضلات مع تغذية جيدة'];
} elseif ($bmi < 25) {
  $bmiAnalysis = ['status' => 'وزن طبيعي', 'className' => 'text-success', 'recommendation' => 'وزنك مثالي! حافظ على لياقتك بتمارين متوازنة'];
} elseif ($bmi < 30) {
  $bmiAnalysis = ['status' => 'وزن زائد', 'className' => 'text-warning', 'recommendation' => 'ركز على تمارين الكارديو وضبط النظام الغذائي'];
} else {
  $bmiAnalysis = ['status' => 'سمنة', 'className' => 'text-danger', 'recommendation' => 'ابدأ بتمارين خفيفة منخفضة التأثير واستشر طبيب'];
}

// Generate personalized exercises based on user data
$exercises = [];

// Define exercise templates
$templates = [
  'walking' => ['name' => 'المشي السريع', 'image' => '🚶', 'benefits' => 'حرق السعرات وتحسين صحة القلب'],
  'swimming' => ['name' => 'السباحة', 'image' => '🏊', 'benefits' => 'تمرين شامل منخفض الضغط على المفاصل'],
  'cycling' => ['name' => 'ركوب الدراجة', 'image' => '🚴', 'benefits' => 'تقوية الساقين وتحسين اللياقة القلبية'],
  'pushups' => ['name' => 'تمارين الضغط', 'image' => '💪', 'benefits' => 'تقوية الصدر والذراعين والأكتاف'],
  'squats' => ['name' => 'السكوات', 'image' => '🦵', 'benefits' => 'تقوية عضلات الساقين والمؤخرة'],
  'plank' => ['name' => 'البلانك', 'image' => '🧘', 'benefits' => 'تقوية عضلات البطن والكور'],
  'yoga' => ['name' => 'اليوغا', 'image' => '🧘‍♀️', 'benefits' => 'تحسين المرونة والاسترخاء'],
  'stretching' => ['name' => 'تمارين التمدد', 'image' => '🤸', 'benefits' => 'زيادة المرونة ومنع الإصابات'],
  'resistance' => ['name' => 'تمارين المقاومة', 'image' => '🏋️', 'benefits' => 'بناء العضلات وشد الجسم'],
  'water' => ['name' => 'تمارين مائية', 'image' => '💧', 'benefits' => 'آمن تماماً للمفاصل وممتاز للتأهيل']
];

$limit = ($timeAvailable === '15') ? 3 : (($timeAvailable === '30') ? 5 : 7);

// Select exercises based on conditions
$selected = [];

if ($healthCondition === 'joint_pain') {
  // Joint-safe exercises
  $selected = ['swimming', 'water', 'cycling', 'walking'];
  $difficulty = 'سهل';
} elseif ($healthCondition === 'chronic') {
  // Low intensity for chronic conditions
  $selected = ['walking', 'yoga', 'stretching', 'swimming'];
  $difficulty = 'سهل';
} elseif ($healthCondition === 'injury') {
  // Gentle recovery exercises
  $selected = ['stretching', 'yoga', 'walking', 'water'];
  $difficulty = 'سهل جداً';
} else {
  // Normal health - can do more variety
  if ($goal === 'weight_loss') {
    $selected = ['walking', 'cycling', 'swimming', 'pushups', 'squats'];
    $difficulty = ($fitnessLevel === 'beginner') ? 'سهل' : (($fitnessLevel === 'intermediate') ? 'متوسط' : 'صعب');
  } elseif ($goal === 'muscle_gain') {
    $selected = ['pushups', 'squats', 'plank', 'resistance', 'cycling'];
    $difficulty = ($fitnessLevel === 'beginner') ? 'سهل' : (($fitnessLevel === 'intermediate') ? 'متوسط' : 'صعب');
  } elseif ($goal === 'flexibility') {
    $selected = ['yoga', 'stretching', 'swimming', 'walking'];
    $difficulty = 'سهل';
  } else {
    $selected = ['walking', 'pushups', 'plank', 'yoga', 'cycling'];
    $difficulty = ($fitnessLevel === 'beginner') ? 'سهل' : 'متوسط';
  }
}

// Set duration based on time available
$durations = [
  '15' => ['15 دقيقة', '3 مجموعات × 8', '2 × 30 ثانية', '10 دقائق'],
  '30' => ['25 دقيقة', '3 مجموعات × 12', '3 × 45 ثانية', '20 دقيقة'],
  '60' => ['40 دقيقة', '4 مجموعات × 15', '4 × 60 ثانية', '30 دقيقة']
];
$durationSet = $durations[$timeAvailable] ?? $durations['30'];

// Build exercises array
$count = 0;
foreach ($selected as $key) {
  if ($count >= $limit) break;
  if (!isset($templates[$key])) continue;
  
  $ex = $templates[$key];
  
  // Determine duration based on exercise type
  if ($key === 'walking' || $key === 'cycling' || $key === 'swimming') {
    $dur = $durationSet[0];
  } elseif ($key === 'pushups' || $key === 'squats' || $key === 'resistance') {
    $dur = $durationSet[1];
  } elseif ($key === 'plank') {
    $dur = $durationSet[2];
  } else {
    $dur = $durationSet[3];
  }
  
  // Adjust difficulty for age
  if ($age >= 50 && $difficulty !== 'سهل جداً') {
    $difficulty = 'سهل';
  }
  
  // Reason based on goal and health
  $reasons = [];
  if ($goal === 'weight_loss') $reasons[] = 'يساعد على حرق السعرات';
  if ($goal === 'muscle_gain') $reasons[] = 'يدعم بناء العضلات';
  if ($goal === 'flexibility') $reasons[] = 'يحسن المرونة';
  if ($healthCondition === 'joint_pain') $reasons[] = 'آمن للمفاصل';
  if ($healthCondition === 'chronic') $reasons[] = 'شدة مناسبة لحالتك';
  if ($fitnessLevel === 'beginner') $reasons[] = 'مناسب للمبتدئين';
  if (count($reasons) === 0) $reasons[] = 'تمرين متوازن للياقة العامة';
  
  $exercises[] = [
    'name' => $ex['name'],
    'duration' => $dur,
    'difficulty' => $difficulty,
    'image' => $ex['image'],
    'benefits' => $ex['benefits'],
    'aiReason' => implode(' • ', array_slice($reasons, 0, 2))
  ];
  $count++;
}

// Generate tips
$tips = [];
$tips[] = 'اشرب 2-3 لتر ماء يومياً';
if ($bmi > 25) {
  $tips[] = 'ابدأ بشدة خفيفة وزد تدريجياً';
  $tips[] = 'ركز على النظام الغذائي alongside التمارين';
}
if ($fitnessLevel === 'beginner') {
  $tips[] = 'خذ يوم راحة بين كل يومين تمرين';
  $tips[] = 'لا تهمل الإحماء قبل التمرين';
}
if ($healthCondition !== 'normal') {
  $tips[] = 'استشر طبيبك قبل البدء بأي برنامج';
}
$tips[] = 'النوم 7-8 ساعات ضروري لبناء العضلات';

$out = [
  'bmi' => $bmi,
  'bmiAnalysis' => $bmiAnalysis,
  'exercises' => $exercises,
  'tips' => array_slice($tips, 0, 5)
];

echo json_encode(['ok' => true, 'results' => $out], JSON_UNESCAPED_UNICODE);
