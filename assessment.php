<?php
$active = 'assessment';
require __DIR__ . '/includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-lg-9 col-xl-8">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white p-4 border-bottom">
        <h1 class="h4 fw-bold mb-1 text-center">نموذج التقييم الصحي</h1>
        <div class="text-muted small text-center">أدخل بياناتك بدقة للحصول على أفضل النتائج</div>
      </div>
      <div class="card-body p-4 p-md-5">
        <form id="assessmentForm" class="row g-3" method="post" action="results.php">
          <div class="col-md-6">
            <label class="form-label fw-bold">الاسم</label>
            <input class="form-control" name="name" required placeholder="الاسم الكامل" />
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">العمر</label>
            <input class="form-control" type="number" name="age" required min="10" max="100" placeholder="السنوات" />
          </div>

          <div class="col-12">
            <label class="form-label fw-bold">الجنس</label>
            <div class="d-flex gap-3">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="g1" value="male" required>
                <label class="form-check-label" for="g1">ذكر</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="g2" value="female" required>
                <label class="form-check-label" for="g2">أنثى</label>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">الوزن (كجم)</label>
            <input class="form-control" type="number" name="weight" required min="30" max="300" placeholder="00" />
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">الطول (سم)</label>
            <input class="form-control" type="number" name="height" required min="100" max="250" placeholder="000" />
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">مستوى اللياقة</label>
            <select class="form-select" name="fitnessLevel" required>
              <option value="">اختر المستوى</option>
              <option value="beginner">مبتدئ (لا أمارس)</option>
              <option value="intermediate">متوسط (أمارس قليلاً)</option>
              <option value="advanced">متقدم (رياضي)</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">الحالة الصحية</label>
            <select class="form-select" name="healthCondition" required>
              <option value="">اختر الحالة</option>
              <option value="normal">سليم (الحمد لله)</option>
              <option value="joint_pain">آلام مفاصل</option>
              <option value="chronic">أمراض مزمنة</option>
              <option value="injury">إصابة سابقة</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">الهدف الرئيسي</label>
            <select class="form-select" name="goal" required>
              <option value="">حدد هدفك</option>
              <option value="weight_loss">إنقاص الوزن</option>
              <option value="muscle_gain">بناء العضلات</option>
              <option value="general_fitness">لياقة عامة</option>
              <option value="flexibility">مرونة وتوازن</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">الوقت المتاح</label>
            <select class="form-select" name="timeAvailable" required>
              <option value="">المدة اليومية</option>
              <option value="15">15 دقيقة</option>
              <option value="30">30 دقيقة</option>
              <option value="60">60 دقيقة</option>
            </select>
          </div>

          <div class="col-12 d-flex gap-2 pt-2">
            <a class="btn btn-outline-secondary fw-bold flex-fill" href="index.php">إلغاء</a>
            <button class="btn btn-success fw-bold flex-fill" type="submit">تحليل النتائج</button>
          </div>
        </form>
        <div class="text-muted small mt-3">ملاحظة: النتائج يتم تحليلها عبر مساعد ذكي (AI) حسب حالتك الصحية ثم عرضها في صفحة النتائج.</div>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
