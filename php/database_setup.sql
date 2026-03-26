-- Database Setup Script for Railway
-- Run this script in Railway MySQL to create all tables

CREATE DATABASE IF NOT EXISTS fitness;
USE fitness;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- User profiles table
CREATE TABLE IF NOT EXISTS user_profiles (
    user_id INT PRIMARY KEY,
    name VARCHAR(100) NULL,
    age INT NULL,
    gender VARCHAR(10) NULL,
    weight DECIMAL(6,2) NULL,
    height DECIMAL(6,2) NULL,
    fitness_level VARCHAR(30) NULL,
    health_condition VARCHAR(30) NULL,
    chronic_type VARCHAR(30) NULL,
    goal VARCHAR(30) NULL,
    time_available VARCHAR(10) NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Progress table
CREATE TABLE IF NOT EXISTS progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    weight DECIMAL(5,2) NULL,
    bmi DECIMAL(5,2) NULL,
    recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Exercises table
CREATE TABLE IF NOT EXISTS exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    difficulty VARCHAR(20) NULL,
    category VARCHAR(50) NULL,
    target_muscles VARCHAR(100) NULL,
    duration_minutes INT NULL,
    video_url VARCHAR(255) NULL,
    image_url VARCHAR(255) NULL,
    instructions TEXT NULL
);

-- User exercises table
CREATE TABLE IF NOT EXISTS user_exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    exercise_id INT NOT NULL,
    completed BOOLEAN DEFAULT FALSE,
    scheduled_date DATE NULL,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (exercise_id) REFERENCES exercises(id) ON DELETE CASCADE
);

-- Insert sample exercises
INSERT INTO exercises (name, description, difficulty, category, target_muscles, duration_minutes, instructions) VALUES
('تمارين تمدد الصباح', 'تمارين خفيفة لتنشيط الجسم في الصباح', 'beginner', 'warmup', 'full_body', 10, 'ابدأ بتمدد بطيء للرقبة، ثم الكتفين، ثم أسفل الظهر. خذ نفساً عميقاً مع كل تمدد.'),
('المشي السريع', 'مشي سريع لمدة 30 دقيقة', 'beginner', 'cardio', 'legs, heart', 30, 'حافظ على وتيرة سريعة مع الحفاظ على استقامة الظهر. أرجح ذراعيك بشكل طبيعي.'),
('تمارين القوة الأساسية', 'تمارين تقوية العضلات الأساسية', 'intermediate', 'strength', 'chest, arms, core', 25, '10 ضغطات + 10 بوش أب + 20 تمرين بطن. كرر 3 مرات مع راحة دقيقة.'),
('اليوغا للمبتدئين', 'تمارين يوغا بسيطة للاسترخاء', 'beginner', 'flexibility', 'full_body, mind', 20, 'ركز على التنفس العميق والوضعيات الأساسية: الجبل، الكلب، الطفل.'),
('تمرين HIIT', 'تمرين عالي الكثافة', 'advanced', 'cardio', 'full_body', 15, '30 ثانية جري ثابت + 30 ثانية راحة. كرر 15 مرة.'),
('تمارين الكرش', 'تقوية عضلات البطن', 'intermediate', 'strength', 'abs, core', 15, '20 كرنش + 20 ليغ رايز + 20 بلانك. كرر 3 مرات.');
