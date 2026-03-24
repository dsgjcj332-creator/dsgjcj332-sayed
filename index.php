<?php
$active = 'home';
require __DIR__ . '/includes/header.php';
?>
<div class="hero rounded-4 p-4 p-md-5 border">
  <div class="row align-items-center g-4">
    <div class="col-lg-7">
      <h1 class="display-5 fw-bold mb-3">مدرب اللياقة <span class="text-success">الذكي</span></h1>
      <p class="lead text-muted mb-4">احصل على خطة تمارين رياضية مصممة خصيصاً لك بناءً على بياناتك الصحية وأهدافك.</p>
      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-success btn-lg fw-bold" href="assessment.php">ابدأ التقييم</a>
        <a class="btn btn-outline-secondary btn-lg fw-bold" href="about.php">تعرف علينا</a>
      </div>
      <div class="row g-3 mt-4">
        <div class="col-md-4">
          <div class="card h-100 card-hover">
            <div class="card-body">
              <div class="fw-bold">صحة أفضل</div>
              <div class="text-muted small mt-1">تحسين صحة القلب والأوعية</div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 card-hover">
            <div class="card-body">
              <div class="fw-bold">نتائج واضحة</div>
              <div class="text-muted small mt-1">حساب BMI وتمارين مناسبة</div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 card-hover">
            <div class="card-body">
              <div class="fw-bold">سهولة الاستخدام</div>
              <div class="text-muted small mt-1">واجهة بسيطة وسريعة</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card border-0 bg-light shadow-sm">
        <div class="card-body p-4">
          <div class="text-center mb-3">
            <div class="display-1 text-success mb-3">💪</div>
            <h5 class="fw-bold mb-2">ابدأ رحلتك نحو اللياقة</h5>
            <p class="text-muted small mb-4">أجب عن بعض الأسئلة واحصل على خطة تمارين مخصصة لك</p>
          </div>
          <div class="text-center">
            <a class="btn btn-success btn-lg fw-bold px-4" href="assessment.php">ابدأ الآن</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
