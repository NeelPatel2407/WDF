
CREATE DATABASE IF NOT EXISTS studenthub;
USE studenthub;

CREATE TABLE IF NOT EXISTS students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    course VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(150) NOT NULL,
    event_date DATE NOT NULL,
    venue VARCHAR(150),
    description TEXT
);

CREATE TABLE IF NOT EXISTS registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE (student_id, event_id),

    FOREIGN KEY (student_id)
        REFERENCES students(student_id)
        ON DELETE CASCADE,

    FOREIGN KEY (event_id)
        REFERENCES events(event_id)
        ON DELETE CASCADE
);

INSERT IGNORE INTO students (name, email, phone, course)
VALUES
('Neel Patel', '25dcs093@charusat.edu.in', '9726138765', 'CSE'),
('Kavy Patel', '25dcs001@charusat.edu.in', '9876543210', 'IT');

INSERT INTO events (event_name, event_date, venue, description)
SELECT 'Tech Fest', '2026-11-15', 'CHARUSAT Campus',
       'Annual technical festival'
WHERE NOT EXISTS (
    SELECT 1 FROM events WHERE event_name = 'Tech Fest'
);

INSERT INTO events (event_name, event_date, venue, description)
SELECT 'Coding Competition', '2026-11-20', 'DEPSTAR Lab',
       'Programming competition'
WHERE NOT EXISTS (
    SELECT 1 FROM events
    WHERE event_name = 'Coding Competition'
);

INSERT IGNORE INTO registrations (student_id, event_id)
SELECT s.student_id, e.event_id
FROM students s
JOIN events e ON e.event_name = 'Tech Fest'
WHERE s.email = 'neel@example.com';

INSERT IGNORE INTO registrations (student_id, event_id)
SELECT s.student_id, e.event_id
FROM students s
JOIN events e ON e.event_name = 'Coding Competition'
WHERE s.email = 'neel@example.com';

INSERT IGNORE INTO registrations (student_id, event_id)
SELECT s.student_id, e.event_id
FROM students s
JOIN events e ON e.event_name = 'Tech Fest'
WHERE s.email = 'rahul@example.com';