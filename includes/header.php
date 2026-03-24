<?php
if (!isset($active)) {
  $active = '';
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>مدرب اللياقة الذكي</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/style.css" />
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">مدرب اللياقة <span class="text-success">الذكي</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link <?php echo $active === 'home' ? 'active fw-bold' : ''; ?>" href="index.php">الرئيسية</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $active === 'assessment' ? 'active fw-bold' : ''; ?>" href="assessment.php">التقييم الصحي</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $active === 'about' ? 'active fw-bold' : ''; ?>" href="about.php">من نحن</a></li>
      </ul>
      <a class="btn btn-success fw-bold" href="assessment.php">ابدأ الآن</a>
    </div>
  </div>
</nav>
<main class="py-4">
  <div class="container">
