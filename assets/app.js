(function () {
  function qs(sel) { return document.querySelector(sel); }

  const db = {
    cardio_low: [
      { name: 'المشي السريع', duration: '30 دقيقة', difficulty: 'سهل', image: '🚶', benefits: 'حرق السعرات وتحسين صحة القلب' },
      { name: 'السباحة الخفيفة', duration: '20 دقيقة', difficulty: 'سهل', image: '🏊', benefits: 'تمرين شامل للجسم دون ضغط على المفاصل' },
      { name: 'ركوب الدراجة', duration: '25 دقيقة', difficulty: 'سهل', image: '🚴', benefits: 'تقوية الساقين وحرق الدهون' }
    ],
    cardio_high: [
      { name: 'الجري', duration: '30 دقيقة', difficulty: 'متوسط', image: '🏃', benefits: 'حرق سعرات عالي وتحسين التحمل' },
      { name: 'تمارين HIIT', duration: '20 دقيقة', difficulty: 'صعب', image: '⚡', benefits: 'حرق الدهون المكثف في وقت قصير' },
      { name: 'القفز بالحبل', duration: '15 دقيقة', difficulty: 'متوسط', image: '🪢', benefits: 'تنسيق الجسم ورفع معدل الحرق' }
    ],
    strength: [
      { name: 'تمارين الضغط', duration: '3 مجموعات × 10', difficulty: 'متوسط', image: '💪', benefits: 'تقوية الصدر والذراعين والأكتاف' },
      { name: 'السكوات', duration: '3 مجموعات × 15', difficulty: 'متوسط', image: '🦵', benefits: 'تقوية الساقين والمؤخرة' },
      { name: 'البلانك', duration: '3 × 30 ثانية', difficulty: 'متوسط', image: '🧘', benefits: 'تقوية عضلات البطن والظهر (الكور)' },
      { name: 'رفع الأثقال الخفيفة', duration: '3 مجموعات × 12', difficulty: 'سهل', image: '🏋️', benefits: 'بناء العضلات وشد الجسم' }
    ],
    flexibility: [
      { name: 'اليوغا للمبتدئين', duration: '30 دقيقة', difficulty: 'سهل', image: '🧘‍♀️', benefits: 'تحسين المرونة والاسترخاء الذهني' },
      { name: 'تمارين التمدد', duration: '15 دقيقة', difficulty: 'سهل', image: '🤸', benefits: 'منع الإصابات وتحسين نطاق الحركة' },
      { name: 'بيلاتس', duration: '25 دقيقة', difficulty: 'متوسط', image: '🤸‍♀️', benefits: 'تقوية العضلات الأساسية والمرونة' }
    ],
    beginner: [
      { name: 'المشي الخفيف', duration: '20 دقيقة', difficulty: 'سهل جداً', image: '🚶‍♂️', benefits: 'البداية الآمنة لتحريك الدورة الدموية' },
      { name: 'تمارين التنفس', duration: '10 دقائق', difficulty: 'سهل جداً', image: '🫁', benefits: 'تحسين القدرة التنفسية والاسترخاء' },
      { name: 'تمارين الكرسي', duration: '15 دقيقة', difficulty: 'سهل', image: '🪑', benefits: 'تقوية العضلات لكبار السن أو المصابين' }
    ],
    joint_safe: [
      { name: 'التمارين المائية', duration: '30 دقيقة', difficulty: 'سهل', image: '💧', benefits: 'مقاومة طبيعية وآمنة تماماً للمفاصل' },
      { name: 'تاي تشي', duration: '20 دقيقة', difficulty: 'سهل', image: '☯️', benefits: 'توازن ومرونة وتركيز دون إجهاد' },
      { name: 'الدراجة الثابتة', duration: '20 دقيقة', difficulty: 'سهل', image: '🚲', benefits: 'كارديو فعال وآمن للركبتين' }
    ]
  };

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

  function suggestExercises(data) {
    const bmi = calculateBMI(Number(data.weight), Number(data.height));
    const bmiAnalysis = analyzeBMI(bmi);
    let recommended = [];

    if (data.healthCondition === 'joint_pain' || data.healthCondition === 'chronic') {
      recommended = db.joint_safe.concat(db.flexibility);
    } else if (data.fitnessLevel === 'beginner') {
      recommended = db.beginner.concat(db.cardio_low.slice(0, 2));
    } else if (data.goal === 'weight_loss') {
      recommended = bmi > 30
        ? db.cardio_low.concat(db.joint_safe.slice(0, 1))
        : db.cardio_high.concat(db.strength.slice(0, 2));
    } else if (data.goal === 'muscle_gain') {
      recommended = db.strength.concat(db.cardio_low.slice(0, 1));
    } else if (data.goal === 'flexibility') {
      recommended = db.flexibility.concat(db.joint_safe.slice(0, 2));
    } else {
      recommended = db.cardio_low.slice(0, 2).concat(db.strength.slice(0, 2)).concat(db.flexibility.slice(0, 1));
    }

    if (data.timeAvailable === '15') recommended = recommended.slice(0, 3);
    else if (data.timeAvailable === '30') recommended = recommended.slice(0, 5);

    return {
      bmi: bmi.toFixed(1),
      bmiAnalysis,
      exercises: recommended,
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
          '<h2 class="h3 fw-bold mb-1">برنامجك جاهز، ' + (payload.data.name || '') + '</h2>' +
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
          '<h3 class="h4 fw-bold m-0">جدول التمارين المقترح</h3>' +
        '</div>' +
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
