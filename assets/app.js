(function () {
  function qs(sel) { return document.querySelector(sel); }

  const db = [
    { name: 'بنش برس (بار/دمبل)', image: '🏋️', type: 'strength', levels: ['intermediate', 'advanced'], goals: ['muscle_gain'], safety: ['normal'], durationByTime: { 15: '4 مجموعات × 6-8', 30: '5 مجموعات × 6-8', 60: '5 مجموعات × 6-10' }, benefits: 'زيادة قوة وحجم عضلات الصدر والترايسبس' },
    { name: 'سكوات مركب', image: '🦵', type: 'strength', levels: ['intermediate', 'advanced'], goals: ['muscle_gain', 'general_fitness'], safety: ['normal'], durationByTime: { 15: '4 مجموعات × 6-8', 30: '5 مجموعات × 6-10', 60: '5 مجموعات × 6-10' }, benefits: 'بناء عضلات الرجلين والعضلات الأساسية' },
    { name: 'رفعة رومانية (RDL)', image: '🏋️‍♂️', type: 'strength', levels: ['intermediate', 'advanced'], goals: ['muscle_gain'], safety: ['normal'], durationByTime: { 15: '3 مجموعات × 8', 30: '4 مجموعات × 8', 60: '4 مجموعات × 8-10' }, benefits: 'تقوية الخلفية والسلسلة الخلفية للجسم' },
    { name: 'سحب علوي (Lat Pulldown)', image: '🧲', type: 'strength', levels: ['beginner', 'intermediate', 'advanced'], goals: ['muscle_gain', 'general_fitness'], safety: ['normal', 'injury'], durationByTime: { 15: '3 مجموعات × 10', 30: '4 مجموعات × 10', 60: '4 مجموعات × 10-12' }, benefits: 'بناء عضلات الظهر وتحسين القوام' },
    { name: 'ضغط كتف دمبل', image: '💪', type: 'strength', levels: ['beginner', 'intermediate', 'advanced'], goals: ['muscle_gain'], safety: ['normal'], durationByTime: { 15: '3 مجموعات × 10', 30: '4 مجموعات × 8-10', 60: '4 مجموعات × 8-10' }, benefits: 'تقوية الأكتاف والثبات العلوي' },
    { name: 'تمارين الضغط', image: '💥', type: 'strength', levels: ['beginner', 'intermediate', 'advanced'], goals: ['muscle_gain', 'general_fitness'], safety: ['normal', 'injury'], durationByTime: { 15: '3 مجموعات × 8-12', 30: '4 مجموعات × 10-15', 60: '5 مجموعات × 10-15' }, benefits: 'تقوية الصدر والذراعين ويمكن تطويرها تدريجياً' },
    { name: 'تمارين HIIT على الدراجة', image: '⚡', type: 'cardio', levels: ['intermediate', 'advanced'], goals: ['weight_loss'], safety: ['normal'], durationByTime: { 15: '12 دقيقة (40ث سريع / 80ث هادئ)', 30: '20 دقيقة (45ث سريع / 75ث هادئ)', 60: '30 دقيقة (45ث سريع / 75ث هادئ)' }, benefits: 'رفع الحرق وتحسين اللياقة القلبية بسرعة' },
    { name: 'الجري المتدرج', image: '🏃', type: 'cardio', levels: ['intermediate', 'advanced'], goals: ['weight_loss', 'general_fitness'], safety: ['normal'], durationByTime: { 15: '15 دقيقة', 30: '25 دقيقة', 60: '40 دقيقة' }, benefits: 'تحسين التحمل وحرق سعرات أعلى' },
    { name: 'المشي السريع', image: '🚶', type: 'cardio', levels: ['beginner', 'intermediate'], goals: ['weight_loss', 'general_fitness'], safety: ['normal', 'joint_pain', 'chronic', 'injury'], durationByTime: { 15: '15 دقيقة', 30: '25 دقيقة', 60: '40 دقيقة' }, benefits: 'تنشيط القلب والدورة الدموية بأمان' },
    { name: 'السباحة', image: '🏊', type: 'cardio', levels: ['beginner', 'intermediate', 'advanced'], goals: ['weight_loss', 'general_fitness'], safety: ['joint_pain', 'chronic', 'injury', 'normal'], durationByTime: { 15: '15 دقيقة', 30: '25 دقيقة', 60: '40 دقيقة' }, benefits: 'تمرين شامل منخفض الضغط على المفاصل' },
    { name: 'الدراجة الثابتة', image: '🚲', type: 'cardio', levels: ['beginner', 'intermediate', 'advanced'], goals: ['weight_loss', 'general_fitness'], safety: ['joint_pain', 'chronic', 'injury', 'normal'], durationByTime: { 15: '15 دقيقة', 30: '25 دقيقة', 60: '35 دقيقة' }, benefits: 'كارديو فعال وآمن للركبتين' },
    { name: 'بلانك + كور', image: '🧱', type: 'core', levels: ['beginner', 'intermediate', 'advanced'], goals: ['general_fitness', 'muscle_gain'], safety: ['normal', 'injury'], durationByTime: { 15: '3 جولات × 30-45 ثانية', 30: '4 جولات × 45 ثانية', 60: '5 جولات × 45-60 ثانية' }, benefits: 'ثبات الجذع وتقليل الإصابات' },
    { name: 'يوغا حركية', image: '🧘‍♀️', type: 'flexibility', levels: ['beginner', 'intermediate', 'advanced'], goals: ['flexibility', 'general_fitness'], safety: ['normal', 'joint_pain', 'chronic', 'injury'], durationByTime: { 15: '12 دقيقة', 30: '25 دقيقة', 60: '35 دقيقة' }, benefits: 'تحسين المرونة ونطاق الحركة وتقليل الشد' },
    { name: 'تمارين تمدد موجهة', image: '🤸', type: 'flexibility', levels: ['beginner', 'intermediate', 'advanced'], goals: ['flexibility', 'injury_recovery'], safety: ['normal', 'joint_pain', 'chronic', 'injury'], durationByTime: { 15: '10 دقائق', 30: '20 دقيقة', 60: '30 دقيقة' }, benefits: 'زيادة المرونة وتسريع التعافي العضلي' },
    { name: 'تمارين مقاومة مطاطية', image: '🟢', type: 'strength', levels: ['beginner', 'intermediate'], goals: ['muscle_gain', 'general_fitness'], safety: ['joint_pain', 'chronic', 'injury', 'normal'], durationByTime: { 15: '3 مجموعات × 12', 30: '4 مجموعات × 12', 60: '5 مجموعات × 12-15' }, benefits: 'تقوية العضلات بأمان مع ضغط أقل على المفاصل' },
    { name: 'تاي تشي', image: '☯️', type: 'balance', levels: ['beginner', 'intermediate'], goals: ['flexibility', 'general_fitness'], safety: ['joint_pain', 'chronic', 'injury'], durationByTime: { 15: '12 دقيقة', 30: '20 دقيقة', 60: '30 دقيقة' }, benefits: 'تحسين التوازن والتحكم الحركي دون إجهاد' }
  ];

  function calculateBMI(weightKg, heightCm) {
    const h = heightCm / 100;
    return (weightKg / (h * h));
  }

  function analyzeBMI(bmi) {
    if (bmi < 18.5) return { status: 'نحيف', className: 'text-primary', recommendation: 'تحتاج لتمارين بناء عضلات مع تغذية جيدة لزيادة الوزن الصحي' };
    if (bmi < 25) return { status: 'وزن طبيعي', className: 'text-success', recommendation: 'وزنك مثالي! حافظ على لياقتك بتمارين متوازنة' };
    if (bmi < 30) return { status: 'وزن زائد', className: 'text-warning', recommendation: 'ينصح بالتركيز على تمارين الكارديو وضبط النظام الغذائي' };
    return { status: 'سمنة', className: 'text-danger', recommendation: 'يجب البدء بتمارين خفيفة منخفضة التأثير واستشارة طبيب' };
  }

  function generateTips(data, bmi) {
    const tips = [];
    if (bmi > 25) {
      tips.push('ابدأ بالتمارين الخفيفة وزد الشدة تدريجياً لتجنب الإرهاق');
      tips.push('شرب الماء بكميات كافية (3 لتر يومياً) يعزز عملية الحرق');
    }
    if (data.fitnessLevel === 'beginner') {
      tips.push('الراحة لا تقل أهمية عن التمرين، خذ يوم راحة بعد كل يومين تمرين');
      tips.push('لا تهمل تمارين الإحماء (5-10 دقائق) لتجنب الإصابات');
    }
    if (data.healthCondition === 'joint_pain') {
      tips.push('استبدل الجري بالمشي السريع أو السباحة لتخفيف الضغط على المفاصل');
      tips.push('توقف فوراً إذا شعرت بألم حاد في المفاصل');
    }
    tips.push('النوم الجيد (7-8 ساعات) هو الوقت الذي يبني فيه جسمك العضلات');
    return tips;
  }

  function getAiRuleSummary(data, bmi) {
    const rules = [];
    if (data.healthCondition === 'joint_pain') rules.push('تخفيف الضغط على المفاصل');
    if (data.healthCondition === 'chronic') rules.push('شدة منخفضة مع انتظام');
    if (data.healthCondition === 'injury') rules.push('تدرج حذر بعد الإصابة');
    if (Number(data.age) >= 50) rules.push('تمارين توازن وحركة آمنة');
    if (bmi >= 30) rules.push('كارديو منخفض التأثير لحرق الدهون');
    if (data.goal === 'muscle_gain') rules.push('إضافة مقاومة لبناء العضلات');
    if (data.goal === 'flexibility') rules.push('زيادة تمارين المرونة');
    return rules;
  }

  function durationForExercise(ex, timeAvailable) {
    const key = String(timeAvailable || '30');
    return ex.durationByTime[key] || ex.durationByTime['30'] || '20 دقيقة';
  }

  function difficultyFromLevel(level) {
    if (level === 'beginner') return 'سهل';
    if (level === 'intermediate') return 'متوسط';
    return 'صعب';
  }

  function aiRecommendExercises(data, bmi) {
    const scored = db.map(function (ex) {
      let score = 0;
      const reasons = [];
      if (ex.goals.indexOf(data.goal) !== -1) {
        score += 5;
        reasons.push('مطابق لهدفك الأساسي');
      }

      if (ex.levels.indexOf(data.fitnessLevel) !== -1) {
        score += 4;
        reasons.push('مناسب لمستواك الحالي');
      }

      if (ex.safety.indexOf(data.healthCondition) !== -1) {
        score += 5;
        reasons.push('آمن لحالتك الصحية');
      } else {
        score -= 6;
      }

      if (data.goal === 'muscle_gain' && ex.type === 'strength') {
        score += 3;
      }
      if (data.goal === 'weight_loss' && ex.type === 'cardio') {
        score += 3;
      }
      if (data.goal === 'flexibility' && (ex.type === 'flexibility' || ex.type === 'balance')) {
        score += 3;
      }

      if (data.healthCondition === 'joint_pain' && (ex.name.indexOf('الجري') !== -1 || ex.name.indexOf('سكوات مركب') !== -1)) {
        score -= 5;
      }
      if (data.healthCondition === 'chronic' && ex.type === 'cardio' && ex.name.indexOf('HIIT') !== -1) {
        score -= 5;
      }
      if (data.healthCondition === 'injury' && ex.type === 'strength' && data.fitnessLevel !== 'beginner') {
        score -= 2;
      }

      if (Number(data.age) >= 50 && ex.type === 'strength' && data.fitnessLevel === 'advanced') {
        score -= 2;
      }

      if (bmi >= 30 && ex.type === 'cardio' && ex.safety.indexOf(data.healthCondition) !== -1) {
        score += 2;
      }

      if (data.goal === 'muscle_gain' && data.fitnessLevel === 'advanced' && ex.type === 'strength') {
        score += 2;
        reasons.push('يدعم برنامج مقاومة حقيقي لمستوى متقدم');
      }

      return {
        exercise: ex,
        score: score,
        reason: reasons.slice(0, 2).join(' • ')
      };
    });

    scored.sort(function (a, b) { return b.score - a.score; });
    const limit = data.timeAvailable === '15' ? 3 : (data.timeAvailable === '30' ? 5 : 7);
    return scored.slice(0, limit).map(function (item) {
      return {
        name: item.exercise.name,
        image: item.exercise.image,
        difficulty: difficultyFromLevel(data.fitnessLevel),
        duration: durationForExercise(item.exercise, data.timeAvailable),
        benefits: item.exercise.benefits,
        aiReason: item.reason || 'اختيار متوازن حسب الحالة الصحية والهدف'
      };
    });
  }

  function suggestExercises(data) {
    const bmi = calculateBMI(Number(data.weight), Number(data.height));
    const bmiAnalysis = analyzeBMI(bmi);
    const recommended = aiRecommendExercises(data, bmi);
    const aiRules = getAiRuleSummary(data, bmi);

    return {
      bmi: bmi.toFixed(1),
      bmiAnalysis,
      exercises: recommended,
      aiRules: aiRules,
      tips: generateTips(data, bmi)
    };
  }

  function renderResults(payload) {
    const root = qs('#resultsRoot');
    if (!root) return;

    const goalLabel = payload.data.goal === 'weight_loss' ? 'تخسيس' : payload.data.goal === 'muscle_gain' ? 'عضلات' : payload.data.goal === 'flexibility' ? 'مرونة' : 'لياقة';
    const levelLabel = payload.data.fitnessLevel === 'beginner' ? 'مبتدئ' : payload.data.fitnessLevel === 'intermediate' ? 'متوسط' : 'متقدم';

    const badgeClass = payload.results.bmiAnalysis.className;

    const exCards = payload.results.exercises.map(function (ex) {
      const diffClass = ex.difficulty.indexOf('سهل') !== -1 ? 'success' : (ex.difficulty === 'متوسط' ? 'warning' : 'danger');
      return (
        '<div class="col-md-6 col-lg-4">' +
          '<div class="card h-100 card-hover">' +
            '<div class="card-body">' +
              '<div class="d-flex align-items-start justify-content-between gap-2">' +
                '<div>' +
                  '<div class="fs-1">' + ex.image + '</div>' +
                  '<div class="fw-bold mt-1">' + ex.name + '</div>' +
                '</div>' +
                '<span class="badge text-bg-' + diffClass + '">' + ex.difficulty + '</span>' +
              '</div>' +
              '<div class="mt-3 small text-muted badge-soft rounded px-2 py-1 d-inline-block">⏱ ' + ex.duration + '</div>' +
              '<div class="mt-3 small"><span class="fw-bold text-success">الفائدة:</span> ' + ex.benefits + '</div>' +
              '<div class="mt-2 small text-primary"><span class="fw-bold">🤖 سبب ترشيح AI:</span> ' + (ex.aiReason || 'اختيار مناسب لملفك الصحي') + '</div>' +
            '</div>' +
          '</div>' +
        '</div>'
      );
    }).join('');

    const tips = payload.results.tips.map(function (t) {
      return '<li class="list-group-item">' + t + '</li>';
    }).join('');

    root.innerHTML = (
      '<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">' +
        '<div>' +
          '<h2 class="h3 fw-bold mb-1">خطة تدريبك المخصصة، ' + (payload.data.name || '') + '</h2>' +
          '<div class="text-muted small">تاريخ الإنشاء: ' + new Date().toLocaleDateString('ar-EG') + '</div>' +
        '</div>' +
        '<div class="d-flex gap-2">' +
          '<button class="btn btn-outline-primary fw-bold" type="button" onclick="window.print()">طباعة</button>' +
          '<a class="btn btn-outline-secondary fw-bold" href="assessment.php">جديد</a>' +
        '</div>' +
      '</div>' +

      '<div class="row g-3 mb-4">' +
        '<div class="col-md-4">' +
          '<div class="card h-100">' +
            '<div class="card-body text-center">' +
              '<div class="text-muted fw-bold">مؤشر الكتلة (BMI)</div>' +
              '<div class="display-6 fw-bold mt-2">' + payload.results.bmi + '</div>' +
              '<div class="mt-2 fw-bold ' + badgeClass + '">' + payload.results.bmiAnalysis.status + '</div>' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="col-md-8">' +
          '<div class="card h-100">' +
            '<div class="card-body">' +
              '<div class="fw-bold mb-2">تحليل الحالة</div>' +
              '<div class="alert alert-warning mb-3">' + payload.results.bmiAnalysis.recommendation + '</div>' +
              '<div class="row g-2 small">' +
                '<div class="col-6 col-md-3"><div class="p-2 bg-light rounded"><div class="text-muted">الوزن</div><div class="fw-bold">' + payload.data.weight + ' كجم</div></div></div>' +
                '<div class="col-6 col-md-3"><div class="p-2 bg-light rounded"><div class="text-muted">الطول</div><div class="fw-bold">' + payload.data.height + ' سم</div></div></div>' +
                '<div class="col-6 col-md-3"><div class="p-2 bg-light rounded"><div class="text-muted">الهدف</div><div class="fw-bold">' + goalLabel + '</div></div></div>' +
                '<div class="col-6 col-md-3"><div class="p-2 bg-light rounded"><div class="text-muted">المستوى</div><div class="fw-bold">' + levelLabel + '</div></div></div>' +
              '</div>' +
            '</div>' +
          '</div>' +
        '</div>' +
      '</div>' +

      '<div class="mb-4">' +
        '<div class="d-flex align-items-center justify-content-between mb-3">' +
          '<h3 class="h4 fw-bold m-0">جدول التمارين المقترح بواسطة المساعد الذكي AI</h3>' +
        '</div>' +
        '<div class="alert alert-primary py-2 small"><span class="fw-bold">منطق AI المستخدم:</span> ' + (payload.results.aiRules && payload.results.aiRules.length ? payload.results.aiRules.join(' + ') : 'اختيار متوازن حسب الحالة الصحية والهدف والمستوى') + '</div>' +
        '<div class="row g-3">' + exCards + '</div>' +
      '</div>' +

      '<div class="card">' +
        '<div class="card-body">' +
          '<h3 class="h5 fw-bold">نصائح لنجاح خطتك</h3>' +
          '<ul class="list-group list-group-flush mt-2">' + tips + '</ul>' +
        '</div>' +
      '</div>'
    );
  }

  document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (form.id !== 'assessmentForm') return;

    e.preventDefault();

    const data = {
      name: form.name.value.trim(),
      age: form.age.value,
      gender: form.gender.value,
      weight: form.weight.value,
      height: form.height.value,
      fitnessLevel: form.fitnessLevel.value,
      healthCondition: form.healthCondition.value,
      goal: form.goal.value,
      timeAvailable: form.timeAvailable.value
    };

    const results = suggestExercises(data);
    sessionStorage.setItem('fitness_assessment_data', JSON.stringify(data));
    sessionStorage.setItem('fitness_assessment_results', JSON.stringify(results));

    window.location.href = 'results.php';
  });

  document.addEventListener('DOMContentLoaded', function () {
    const root = qs('#resultsRoot');
    if (!root) return;

    const dataStr = sessionStorage.getItem('fitness_assessment_data');
    const resStr = sessionStorage.getItem('fitness_assessment_results');

    if (!dataStr || !resStr) {
      root.innerHTML = '<div class="alert alert-info">لا توجد نتائج بعد. ابدأ من صفحة التقييم.</div><a class="btn btn-success fw-bold" href="assessment.php">اذهب للتقييم</a>';
      return;
    }

    const payload = {
      data: JSON.parse(dataStr),
      results: JSON.parse(resStr)
    };

    renderResults(payload);
  });
})();
