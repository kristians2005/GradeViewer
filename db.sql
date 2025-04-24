CREATE DATABASE grades;
USE grades;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    nickname VARCHAR(50),
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher') DEFAULT 'student' NOT NULL
);

CREATE TABLE Subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(100)
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

INSERT INTO Users (first_name, last_name, email, password, role) VALUES
('Anna', 'Kalniņa', 'anna.kalnina@example.com', 'hashed_password_anna', 'student'),
('Jānis', 'Ozols', 'janis.ozols@example.com', 'hashed_password_janis', 'student'),
('Laura', 'Liepa', 'laura.liepa@example.com', 'hashed_password_laura', 'student'),
('Andris', 'Bērziņš', 'andris.berzins@example.com', 'hashed_password_andris', 'teacher');

INSERT INTO Subjects (subject_name) VALUES
('Matemātika'),
('Latviešu valoda'),
('Dabaszinības');

INSERT INTO Grades (student_id, subject_id, grade, grade_date) VALUES
(1, 1, 8.50, '2024-09-12 10:00:00'),
(1, 2, 9.00, '2024-09-15 12:00:00'),
(2, 1, 7.00, '2024-09-13 11:00:00'),
(2, 3, 6.50, '2024-09-20 09:30:00'),
(3, 1, 10.00, '2024-09-11 14:00:00');
