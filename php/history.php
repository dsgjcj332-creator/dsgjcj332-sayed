<?php
$active = 'history';
require __DIR__ . '/includes/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
  <h1 class="h3 fw-bold m-0">سجل التقييمات السابقة</h1>
  <a class="btn btn-success fw-bold" href="assessment.php">تقييم جديد</a>
</div>
<div class="card">
  <div class="card-body p-4">
    <div class="alert alert-info mb-0">
      السجل سيتم ربطه بقاعدة البيانات (MySQL) لاحقًا. حاليًا الصفحة جاهزة كواجهة.
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
