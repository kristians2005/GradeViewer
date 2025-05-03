DROP DATABASE IF EXISTS grades;
CREATE DATABASE IF NOT EXISTS grades;
USE grades;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    nick_name VARCHAR(50),
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher') DEFAULT 'student' NOT NULL
);

CREATE TABLE Subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(100)
);

CREATE TABLE Teachers_students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT,
    student_id INT,
    FOREIGN KEY (teacher_id) REFERENCES Users(id),
    FOREIGN KEY (student_id) REFERENCES Users(id)
);

CREATE TABLE User_Subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    subject_id INT,
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (subject_id) REFERENCES Subjects(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE Grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject_id INT,
    grade DECIMAL(4,2),
    grade_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES Users(id),
    FOREIGN KEY (subject_id) REFERENCES Subjects(id)
);

-- First insert subjects since they're referenced by User_Subjects
INSERT INTO Subjects (subject_name) VALUES
('Matemātika'),
('Latviešu valoda'),
('Dabaszinības'),
('Vēsture'),
('Fizika'),
('Ķīmija'),
('Bioloģija'),
('Angļu valoda'),
('Vācu valoda'),
('Krievu valoda'),
('Mūzika'),
('Māksla'),
('Sports'),
('Tehnoloģijas'),
('Ekonomika'),
('Sociālās zinības'),
('Psiholoģija'),
('Filozofija'),
('Programmēšana'),
('Dizains'),
('Teātris'),
('Dejas'),
('Fotogrāfija'),
('Žurnālistika'),
('Mediju māksla'),
('Radošā rakstīšana'),
('Kultūras vēsture'),
('Vides zinības'),
('Starptautiskās attiecības'),
('Politikas zinātne'),
('Tiesību zinātne');

-- password: 1Password.
INSERT INTO Users (first_name, last_name, nick_name, password, role) VALUES
('student', 'stud', 'student', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('teacher', 'teach', 'teacher', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'teacher'),
('teacher', 'teach', 'teacher2', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'teacher'),
('Laura', 'Liepa', 'laura.liepa@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Andris', 'Bērziņš', 'andris.berzins@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'teacher'),

('Jānis', 'Kalniņš', 'janis.kalnins@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Līga', 'Ozola', 'liga.ozola@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Kārlis', 'Krūmiņš', 'karlis.krumins@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Anna', 'Zariņa', 'anna.zarina@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Mārtiņš', 'Priede', 'martins.priede@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Kristīne', 'Egle', 'kristine.egle@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Raivis', 'Saulītis', 'raivis.saulitis@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Elīna', 'Kļaviņa', 'elina.klavina@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Toms', 'Ozoliņš', 'toms.ozolins@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Santa', 'Balode', 'santa.balode@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Artūrs', 'Vītols', 'arturs.vitols@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Ieva', 'Zaķe', 'ieva.zake@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Edgars', 'Liepiņš', 'edgars.liepins@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Linda', 'Bērziņa', 'linda.berzina@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Juris', 'Kalns', 'juris.kalns@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Baiba', 'Jansone', 'baiba.jansone@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Oskars', 'Putniņš', 'oskars.putnins@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Eva', 'Straume', 'eva.straume@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Roberts', 'Upītis', 'roberts.upitis@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Madara', 'Pētersone', 'madara.petersone@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student');

-- Connect all new students to teacher (assuming teacher_id = 2)
INSERT INTO Teachers_students (teacher_id, student_id)
SELECT 2, id FROM Users 
WHERE role = 'student' AND id > 3;

-- Assign subjects to new students (3 subjects per student)
INSERT INTO User_Subjects (user_id, subject_id)
SELECT 
    u.id,
    s.id
FROM Users u
CROSS JOIN (
    SELECT id FROM Subjects WHERE id <= 3
) s
WHERE u.role = 'student' AND u.id > 3;

-- Add grades for new students (3 grades per subject)
INSERT INTO Grades (student_id, subject_id, grade, grade_date) 
SELECT 
    u.id,
    us.subject_id,
    5 + (RAND() * 5),
    DATE_ADD('2024-01-01', INTERVAL FLOOR(RAND() * 365) DAY)
FROM Users u
JOIN User_Subjects us ON u.id = us.user_id
WHERE u.role = 'student' AND u.id > 3;

-- Then insert user_subjects
INSERT INTO User_Subjects (user_id, subject_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 3),
(3, 1),
(3, 4),
(4, 5),
(4, 6);

INSERT INTO Teachers_students (teacher_id, student_id) VALUES
(2, 1),
(2, 3);

-- Finally insert grades
INSERT INTO Grades (student_id, subject_id, grade, grade_date) VALUES
(1, 1, 8.50, '2024-09-12 10:00:00'),
(1, 2, 9.00, '2024-09-15 12:00:00'),
(2, 1, 7.00, '2024-09-13 11:00:00'),
(2, 3, 6.50, '2024-09-20 09:30:00'),
(3, 1, 10.00, '2024-09-11 14:00:00');
