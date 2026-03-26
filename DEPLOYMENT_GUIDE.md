# دليل النشر على Railway + Vercel

## نظرة عامة
- **Backend (PHP)**: Railway
- **Frontend (HTML/JS)**: Vercel
- **Database**: Railway MySQL

---

## الخطوة 1: نشر Backend على Railway

### 1.1 إنشاء حساب Railway
1. ادخل على [railway.app](https://railway.app)
2. سجل باستخدام GitHub
3. اربط حساب GitHub الخاص بك

### 1.2 إنشاء مشروع Backend
1. اضغط "New Project"
2. اختر "Deploy from GitHub repo"
3. اختر repo: `dsgjcj332-sayed`
4. Railway هيكتشف تلقائياً إنه PHP project

### 1.3 إضافة قاعدة بيانات MySQL
1. اضغط "New" → "Database" → "Add MySQL"
2. انتظر لحد ما تكون جاهزة

### 1.4 إضافة Environment Variables
1. اذهب لـ Settings → Variables
2. أضف المتغيرات التالية:

```
DB_HOST = ${MySQL.RAILWAY_PRIVATE_DOMAIN}
DB_PORT = 3306
DB_USER = ${MYSQL_USER}
DB_PASS = ${MYSQL_PASSWORD}
DB_NAME = ${MYSQL_DATABASE}
APP_ENV = production
APP_DEBUG = false
```

### 1.5 تشغيل Database Setup
1. اذهب لـ MySQL → Connect
2. افتح Query Console
3. انسخ محتوى `database_setup.sql` والصقه
4. شغل الـ query

### 1.6 الحصول على Domain
1. اذهب لـ Settings → Domains
2. اضغط "Generate Domain"
3. احفظ الرابط (مثال: `https://fitness-app-backend.up.railway.app`)

---

## الخطوة 2: نشر Frontend على Vercel

### 2.1 إنشاء حساب Vercel
1. ادخل على [vercel.com](https://vercel.com)
2. سجل باستخدام GitHub

### 2.2 إنشاء مشروع Frontend
1. اضغط "Add New..." → "Project"
2. استورد نفس الـ repo من GitHub
3. اختر Framework Preset: "Other"
4. في Root Directory: `php` (لأن ملفاتك في folder php)
5. اضغط Deploy

### 2.3 إضافة Environment Variables (لو محتاج)
1. اذهب لـ Project Settings → Environment Variables
2. أضف:
```
API_URL = https://fitness-app-backend.up.railway.app
```

---

## الخطوة 3: ربط Frontend بـ Backend

### 3.1 تعديل ملف config في Frontend
ابحث عن كل الأماكن اللي فيها `localhost` أو `127.0.0.1` واستبدلها بـ Railway domain

### 3.2 مثال على الربط في JavaScript:
```javascript
// بدل:
const API_URL = 'http://localhost/fitness/api';

// خليها:
const API_URL = 'https://fitness-app-backend.up.railway.app/api';
```

---

## الخطوة 4: التحقق من الاتصال

### 4.1 اختبار Backend
افتح في المتصفح:
```
https://fitness-app-backend.up.railway.app/
```

### 4.2 اختبار Frontend
افتح:
```
https://fitness-app-frontend.vercel.app/
```

### 4.3 اختبار API
جرب تسجل دخول أو إنشاء حساب جديد

---

## المشاكل الشائعة والحلول

### المشكلة: Database connection failed
**الحل**: تأكد من صحة بيانات الـ Environment Variables في Railway

### المشكلة: CORS errors
**الحل**: أضف CORS headers في PHP:
```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
```

### المشكلة: الصور والـ assets مش بتظهر
**الحل**: استخدم مسارات نسبية بدلاً من absolute paths

---

## تحديثات مستقبلية

### لتحديث الكود:
```bash
git add .
git commit -m "Update"
git push origin main
```

**Railway و Vercel هيعملوا deploy تلقائياً!**

### لتحديث قاعدة البيانات:
1. صدّر من XAMPP: `mysqldump -u root fitness > backup.sql`
2. استورد في Railway Query Console

---

## روابط مهمة
- Railway Dashboard: https://railway.app/dashboard
- Vercel Dashboard: https://vercel.com/dashboard
- Project Repo: https://github.com/dsgjcj332-creator/dsgjcj332-sayed
