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
('student', 'stud', 'students', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('teacher', 'teach', 'teacher', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'teacher'),
('Laura', 'Liepa', 'laura.liepa@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Andris', 'Bērziņš', 'andris.berzins@example.com', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'teacher');

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
