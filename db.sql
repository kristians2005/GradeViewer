DROP DATABASE IF EXISTS grades;
CREATE DATABASE IF NOT EXISTS grades;
USE grades;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    nick_name VARCHAR(50),
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher') DEFAULT 'student' NOT NULL
);

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT UNIQUE,
    class_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    class_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
);

CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT,
    subject_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
);

CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject_id INT,
    grade DECIMAL(4,2) CHECK (grade >= 0 AND grade <= 10),
    grade_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- Create triggers to enforce role constraints
DELIMITER //

CREATE TRIGGER before_class_insert 
BEFORE INSERT ON classes
FOR EACH ROW
BEGIN
    IF NOT EXISTS (SELECT 1 FROM users WHERE id = NEW.teacher_id AND role = 'teacher') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Only teachers can be assigned to classes';
    END IF;
END//

CREATE TRIGGER before_student_insert
BEFORE INSERT ON students
FOR EACH ROW
BEGIN
    IF NOT EXISTS (SELECT 1 FROM users WHERE id = NEW.user_id AND role = 'student') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Only students can be added to Students table';
    END IF;
END//

CREATE TRIGGER before_grade_insert
BEFORE INSERT ON grades
FOR EACH ROW
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM students s
        JOIN subjects sub ON s.class_id = sub.class_id
        WHERE s.id = NEW.student_id AND sub.id = NEW.subject_id
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Can only add grades for students in the subject''s class';
    END IF;
END//

DELIMITER ;

-- Add indexes for better performance
CREATE INDEX idx_student_class ON students(class_id);
CREATE INDEX idx_subject_class ON subjects(class_id);
CREATE INDEX idx_grades_student ON grades(student_id);
CREATE INDEX idx_grades_subject ON grades(subject_id);

-- Sample data for testing
INSERT INTO users (first_name, last_name, nick_name, password, role) VALUES
-- Test accounts
('teacher', 'teach', 'teacher', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'teacher'),
('student', 'stud', 'student', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),

-- Regular teacher
('John', 'Doe', 'john.doe', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'teacher'),

-- Regular students
('Jane', 'Smith', 'jane.smith', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Alice', 'Johnson', 'alice.j', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Bob', 'Wilson', 'bob.w', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Charlie', 'Brown', 'charlie.b', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('David', 'Miller', 'david.m', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Emma', 'Davis', 'emma.d', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Frank', 'Garcia', 'frank.g', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Grace', 'Martinez', 'grace.m', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Henry', 'Anderson', 'henry.a', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Isabel', 'Thomas', 'isabel.t', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Jack', 'Jackson', 'jack.j', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Kelly', 'White', 'kelly.w', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Leo', 'Lopez', 'leo.l', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Mia', 'Lee', 'mia.l', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Noah', 'Walker', 'noah.w', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student'),
('Olivia', 'Hall', 'olivia.h', '$2y$10$MA4ZmdHDh7V6CfaEHci.w.0ysGCh4xkDaj.JhZgk5tFFvdAcevTXC', 'student');

INSERT INTO classes (teacher_id, class_name) VALUES
(1, 'Class 12A'),
(3, 'Class 12B');

-- First add subjects for both classes
INSERT INTO subjects (class_id, subject_name) VALUES
(1, 'Mathematics'),    -- For Class 12A
(1, 'Physics'),        -- For Class 12A
(1, 'Chemistry'),      -- For Class 12A
(1, 'Biology'),        -- For Class 12A
(1, 'English'),        -- For Class 12A
(1, 'History'),        -- For Class 12A
(1, 'Geography'),      -- For Class 12A
(1, 'Computer Science'),-- For Class 12A
(1, 'Literature'),     -- For Class 12A
(1, 'Art'),           -- For Class 12A
(2, 'Mathematics'),    -- For Class 12B
(2, 'Physics'),        -- For Class 12B
(2, 'Chemistry'),      -- For Class 12B
(2, 'Biology'),        -- For Class 12B
(2, 'English'),        -- For Class 12B
(2, 'History'),        -- For Class 12B
(2, 'Geography'),      -- For Class 12B
(2, 'Computer Science'),-- For Class 12B
(2, 'Literature'),     -- For Class 12B
(2, 'Art');           -- For Class 12B

INSERT INTO students (user_id, class_id) VALUES
(2, 1),  -- test student in first class
(4, 2),  -- Jane in second class
(5, 2),  -- Alice in second class
(6, 2),  -- Bob in second class
(7, 2),  -- Charlie in second class
(8, 2),  -- David in second class
(9, 2),  -- Emma in second class
(10, 2), -- Frank in second class
(11, 2), -- Grace in second class
(12, 2), -- Henry in second class
(13, 2), -- Isabel in second class
(14, 2), -- Jack in second class
(15, 2), -- Kelly in second class
(16, 2), -- Leo in second class
(17, 2), -- Mia in second class
(18, 2), -- Noah in second class
(19, 2); -- Olivia in second class

-- Insert sample grades for all students across all subjects
INSERT INTO grades (student_id, subject_id, grade) VALUES
-- Grades for test student (student_id 1) in Class 12A
(1, 1, 8.5),  -- Mathematics
(1, 2, 9.0),  -- Physics
(1, 3, 7.5),  -- Chemistry
(1, 4, 8.0),  -- Biology
(1, 5, 9.5),  -- English
(1, 6, 8.0),  -- History
(1, 7, 7.5),  -- Geography
(1, 8, 9.0),  -- Computer Science
(1, 9, 8.5),  -- Literature
(1, 10, 7.0), -- Art

-- Grades for students in Class 12B (student_ids 2-19)
-- Jane Smith (student_id 2)
(2, 11, 8.0),  -- Mathematics
(2, 12, 7.5),  -- Physics
(2, 13, 8.5),  -- Chemistry
(2, 14, 9.0),  -- Biology
(2, 15, 8.0),  -- English
(2, 16, 7.5),  -- History
(2, 17, 8.5),  -- Geography
(2, 18, 9.0),  -- Computer Science
(2, 19, 8.0),  -- Literature
(2, 20, 7.5),  -- Art

-- Alice Johnson (student_id 3)
(3, 11, 9.0),  -- Mathematics
(3, 12, 8.5),  -- Physics
(3, 13, 9.5),  -- Chemistry
(3, 14, 8.0),  -- Biology
(3, 15, 9.0),  -- English
(3, 16, 8.5),  -- History
(3, 17, 9.0),  -- Geography
(3, 18, 8.5),  -- Computer Science
(3, 19, 9.0),  -- Literature
(3, 20, 8.0),  -- Art

-- Bob Wilson (student_id 4)
(4, 11, 7.0),  -- Mathematics
(4, 12, 7.5),  -- Physics
(4, 13, 8.0),  -- Chemistry
(4, 14, 7.5),  -- Biology
(4, 15, 8.0),  -- English
(4, 16, 7.0),  -- History
(4, 17, 7.5),  -- Geography
(4, 18, 8.0),  -- Computer Science
(4, 19, 7.5),  -- Literature
(4, 20, 8.0),  -- Art

-- Charlie Brown (student_id 5)
(5, 11, 8.0),  -- Mathematics
(5, 12, 8.5),  -- Physics
(5, 13, 8.0),  -- Chemistry
(5, 14, 8.5),  -- Biology
(5, 15, 8.0),  -- English
(5, 16, 8.5),  -- History
(5, 17, 8.0),  -- Geography
(5, 18, 8.5),  -- Computer Science
(5, 19, 8.0),  -- Literature
(5, 20, 8.5),  -- Art

-- David Miller (student_id 6)
(6, 11, 9.5),  -- Mathematics
(6, 12, 9.0),  -- Physics
(6, 13, 9.5),  -- Chemistry
(6, 14, 9.0),  -- Biology
(6, 15, 9.5),  -- English
(6, 16, 9.0),  -- History
(6, 17, 9.5),  -- Geography
(6, 18, 9.0),  -- Computer Science
(6, 19, 9.5),  -- Literature
(6, 20, 9.0),  -- Art

-- Emma Davis (student_id 7)
(7, 11, 6.5),  -- Mathematics
(7, 12, 7.0),  -- Physics
(7, 13, 6.5),  -- Chemistry
(7, 14, 7.0),  -- Biology
(7, 15, 7.5),  -- English
(7, 16, 6.5),  -- History
(7, 17, 7.0),  -- Geography
(7, 18, 7.5),  -- Computer Science
(7, 19, 6.5),  -- Literature
(7, 20, 7.0),  -- Art

-- Frank Garcia (student_id 8)
(8, 11, 8.5),  -- Mathematics
(8, 12, 8.0),  -- Physics
(8, 13, 8.5),  -- Chemistry
(8, 14, 8.0),  -- Biology
(8, 15, 8.5),  -- English
(8, 16, 8.0),  -- History
(8, 17, 8.5),  -- Geography
(8, 18, 8.0),  -- Computer Science
(8, 19, 8.5),  -- Literature
(8, 20, 8.0),  -- Art

-- Grace Martinez (student_id 9)
(9, 11, 7.5),  -- Mathematics
(9, 12, 8.0),  -- Physics
(9, 13, 7.5),  -- Chemistry
(9, 14, 8.0),  -- Biology
(9, 15, 7.5),  -- English
(9, 16, 8.0),  -- History
(9, 17, 7.5),  -- Geography
(9, 18, 8.0),  -- Computer Science
(9, 19, 7.5),  -- Literature
(9, 20, 8.0);  -- Art
