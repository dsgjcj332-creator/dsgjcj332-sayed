<?php
$active = 'about';
require __DIR__ . '/includes/header.php';
?>
<div class="row g-3">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-4">
        <h1 class="h3 fw-bold mb-3">عن <span class="text-success">مشروعنا</span></h1>
        <p class="text-muted">"مدرب اللياقة الذكي" مشروع تخرج يهدف لتقديم خطة تمارين مناسبة حسب بيانات المستخدم الصحية وأهدافه.</p>
        <div class="row g-3 mt-1">
          <div class="col-md-6">
            <div class="border rounded-3 p-3 h-100">
              <div class="fw-bold mb-1">فكرة المشروع</div>
              <div class="text-muted small">تحليل بيانات المستخدم واقتراح تمارين آمنة وفعالة.</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded-3 p-3 h-100">
              <div class="fw-bold mb-1">الخصوصية</div>
              <div class="text-muted small">نحترم خصوصية بياناتك الصحية. جميع المعلومات التي تدخلها تستخدم فقط لغرض توليد الخطة الرياضية.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 mt-4">
    <div class="card">
      <div class="card-body p-4">
        <div class="fw-bold mb-2">روابط سريعة</div>
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-success fw-bold" href="assessment.php">ابدأ التقييم</a>
          <a class="btn btn-outline-secondary fw-bold" href="index.php">الرئيسية</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
