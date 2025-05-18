-- --------------------------------------------------------
-- Table structure for table user
--

CREATE TABLE [user] (
  user_ID INT IDENTITY(1,1) NOT NULL,
  user_name VARCHAR(40) NOT NULL,
  user_password VARCHAR(300) NOT NULL,
  user_email VARCHAR(30) NOT NULL,
  user_phone VARCHAR(11) NOT NULL,
  user_role VARCHAR(10) NOT NULL CHECK (user_role IN ('admin', 'supervisor', 'student')),
  PRIMARY KEY (user_ID)
);

-- --------------------------------------------------------
-- Table structure for table admin
--

CREATE TABLE admin (
    admin_ID INT IDENTITY(80001,1) NOT NULL,
    user_ID INT NOT NULL,
    PRIMARY KEY (admin_ID),
    FOREIGN KEY (user_ID) REFERENCES [user](user_ID)
);

-- --------------------------------------------------------
-- Table structure for table student
--

CREATE TABLE student (
    student_ID INT IDENTITY(10001,1) NOT NULL,
    specialization VARCHAR(20) NOT NULL CHECK (specialization IN ('Computer Science','Cybersecurity','Game Development','Data Science','Software Engineering','Information System')),
    user_ID INT NOT NULL,
    PRIMARY KEY (student_ID),
    FOREIGN KEY (user_ID) REFERENCES [user](user_ID)
);

-- --------------------------------------------------------
-- Table structure for table supervisor
--

CREATE TABLE supervisor (
    supervisor_ID INT IDENTITY(50001,1) NOT NULL,
    user_ID INT NOT NULL,
    PRIMARY KEY (supervisor_ID),
    FOREIGN KEY (user_ID) REFERENCES [user](user_ID)
);

-- --------------------------------------------------------
-- Table structure for table proposal
--

CREATE TABLE proposal (
    proposal_ID INT IDENTITY(1,1) NOT NULL,
    student_name VARCHAR(40) NOT NULL,
    student_ID INT NOT NULL,
    specialization VARCHAR(20) NOT NULL CHECK (specialization IN ('Computer Science','Cybersecurity','Game Development','Data Science','Software Engineering','Information System')),
    project_title VARCHAR(100) NOT NULL,
    supervisor_name VARCHAR(40) NOT NULL,
    supervisor_ID INT NOT NULL,
    co_supervisor_name VARCHAR(40),
    proposed_by VARCHAR(10) NOT NULL CHECK (proposed_by IN ('Student', 'Lecture', 'Industry')),
    project_type VARCHAR(50) NOT NULL CHECK (project_type IN ('Application', 'Research', 'Application and Research')),
    project_specialization VARCHAR(20) NOT NULL CHECK (project_specialization IN ('Computer Science','Cybersecurity','Game Development','Data Science','Software Engineering','Information System')),
    project_category VARCHAR(100) NOT NULL,
    industry_collaboration VARCHAR(3) NOT NULL CHECK (industry_collaboration IN ('yes', 'no')),
    file_address VARCHAR(100) NOT NULL,
    proposal_status VARCHAR(10) NOT NULL CHECK (proposal_status IN ('approve', 'pending', 'reject')),
    PRIMARY KEY (proposal_ID),
    FOREIGN KEY (student_ID) REFERENCES student(student_ID),
    FOREIGN KEY (supervisor_ID) REFERENCES supervisor(supervisor_ID)
);

-- --------------------------------------------------------
-- Table structure for table meeting_record
--

CREATE TABLE meeting_record (
    meeting_ID INT IDENTITY(1,1) NOT NULL,
    meeting_title VARCHAR(50) NOT NULL,
    meeting_date DATE NOT NULL,
    meeting_time TIME NOT NULL,
    meeting_desc VARCHAR(100) NOT NULL,
    student_ID INT NOT NULL,
    supervisor_ID INT NOT NULL,
    meeting_status VARCHAR(10) NOT NULL,
    PRIMARY KEY (meeting_ID),
    FOREIGN KEY (student_ID) REFERENCES student(student_ID),
    FOREIGN KEY (supervisor_ID) REFERENCES supervisor(supervisor_ID)
);

-- --------------------------------------------------------
-- Table structure for table meeting_log
--

CREATE TABLE meeting_log(
    meeting_log_ID INT IDENTITY(1,1) NOT NULL,
    file_address VARCHAR(100) NOT NULL,
    student_ID INT NOT NULL,
    PRIMARY KEY (meeting_log_ID),
    FOREIGN KEY (student_ID) REFERENCES student(student_ID)
);

-- --------------------------------------------------------
-- Table structure for table announcement
--

CREATE TABLE announcement(
    announcement_ID INT IDENTITY(1,1) NOT NULL,
    post_by VARCHAR(40) NOT NULL,
    announcement_title VARCHAR(50) NOT NULL,
    announcement_content VARCHAR(350) NOT NULL,
    admin_ID INT NOT NULL,
    PRIMARY KEY (announcement_ID),
    FOREIGN KEY (admin_ID) REFERENCES admin(admin_ID)
);

-- --------------------------------------------------------
-- Table structure for table event
--

CREATE TABLE event(
    event_ID INT IDENTITY(1,1) NOT NULL,
    post_by VARCHAR(40) NOT NULL,
    event_date DATE NOT NULL,
    event_title VARCHAR(50) NOT NULL,
    admin_ID INT NOT NULL,
    PRIMARY KEY (event_ID),
    FOREIGN KEY (admin_ID) REFERENCES admin(admin_ID)
);

-- --------------------------------------------------------
-- Table structure for table goal_and_progress
--

CREATE TABLE goal_and_progress(
    goal_ID INT IDENTITY(1,1) NOT NULL,
    progress_date DATE NOT NULL,
    current_progress VARCHAR(50) NOT NULL,
    next_goal VARCHAR(50) NOT NULL,
    comment VARCHAR(50) NOT NULL,
    student_ID INT NOT NULL,
    PRIMARY KEY (goal_ID),
    FOREIGN KEY (student_ID) REFERENCES student(student_ID)
);

-- --------------------------------------------------------
-- Table structure for table assessment
--

CREATE TABLE assessment (
    assessment_ID INT IDENTITY(1,1) NOT NULL,
    assessment_date DATE NOT NULL,
    program_name VARCHAR(40) NOT NULL,
    assessment_file VARCHAR(100) NOT NULL,
    supervisor_ID INT NOT NULL,
    student_ID INT NOT NULL,
    clarity_objectives INT NOT NULL,
    understanding_problem INT NOT NULL,
    quality_methodology INT NOT NULL,
    technical_implementation INT NOT NULL,
    innovation INT NOT NULL,
    quality_report INT NOT NULL,
    presentation_skills INT NOT NULL,
    ability_answer_question INT NOT NULL,
    signature_file VARCHAR(100) NOT NULL,
    Grade VARCHAR(2) NOT NULL CHECK (Grade IN ('A+','A','A-','B+','B','C+','C','F')),
    PRIMARY KEY (assessment_ID),
    FOREIGN KEY (student_ID) REFERENCES student(student_ID),
    FOREIGN KEY (supervisor_ID) REFERENCES supervisor(supervisor_ID)
);



-- --------------------------------------------------------
-- Table structure for user activity log
--

CREATE TABLE user_activity_log (
    log_ID INT IDENTITY(1,1) NOT NULL,
    user_ID INT NOT NULL,
    action NVARCHAR(100) NOT NULL,       -- e.g., 'login', 'logout', 'update_password'
    ip_address NVARCHAR(45) NULL,
    user_agent NVARCHAR(MAX) NULL,
    timestamp DATETIME DEFAULT GETDATE()

	FOREIGN KEY (user_ID) REFERENCES [user] (user_ID)
);


-- ----------------------- DUMPING DATA -------------------------

-- user data
INSERT INTO [user] (user_name, user_password, user_email, user_phone, user_role) VALUES
('Alice', '$2y$10$yzxifITdexFYYbQFANBjlOr80kgh/f.U/o8V1R6c7tQksjvlEIW9O', 'alice@gmail.com', '0123456789', 'admin'),
('Bob', '$2y$10$ZlzEvVsnmHoD/hcQ983b8ezrE7t7dAeSYBj3JmuSe6U3hyMPlQ8XK', 'bob@gmail.com', '01245678912', 'admin'),
('Jayden', '$2y$10$QVUZGYLOxUTMM5OJqsbaNOU5Ig7Tbnter2NXwcwGcZLxQgncLS3OS', 'Jayden@gmail.com', '0122515491', 'admin'),
('Camellya', '$2y$10$mfH3aZZO/4CE9nGMij6.t.TLgTcbC29F8LVvdbtc4oSpX5ve6MgAC', 'Camellya@gmail.com', '0165487315', 'admin'),

('Charlie', '$2y$10$wvKiRaQePDT2cwmFqKe5dO4yN4.76IBM57ayVdTVv5tXY4MluRgLm', 'charlie@gmail.com', '01345678903', 'student'),
('David', '$2y$10$cHuZTE1ouMyckzTmHWNcuuSMeL4/bHonSdyD/jT21Y7EXJheMf8h2', 'david@gmail.com', '01123456789', 'student'),
('Eva', '$2y$10$r0F7MEFBiRlvSCWyFK6WHuAQt3ltIIwrdzFCMEntAWK9lCJzHJjWy', 'eva@gmail.com', '0123678905', 'student'),
('Frank', '$2y$10$xI0BFyR.Q.HnyUo8zlMskeYqJ0pNpMU20iR8o19Xp731Ka8EXKuye', 'frank@gmail.com', '0179872478', 'student'),
('Grace', '$2y$10$Jt5OFU1QHD/hPfif480CYeu2xpj32NdzObcUZWZDpHAr3RF2avxYG', 'grace@gmail.com', '0198792467', 'student'),
('Hank', '$2y$10$B7Pditn3y.gwqYffFnTy0eNr7zS4H6EZzrEeMZ9JE8Sk514oSC6/6', 'hank@gmail.com', '0101254879', 'student'),
('AbuAbi', '$2y$10$.0ztQ.R21M297biarJMPM.YZjbR4sP25827eaHDHWBtOFjku1dbN2', 'AbuAbi@gmail.com', '0165789254', 'student'),
('Dom', '$2y$10$aifPfGDacp5TRoytf8crW.xhYrNMwdFGxzqk2hfdp8v94vWIObmHC', 'Dom@gmail.com', '0152485987', 'student'),
('Vivian', '$2y$10$pNW793R.SQ8vJN3MIvn0buMiiEQ4MVs1tsuHv/zF7l/eLZmdQTrxi', 'vivian@gmail.com', '0114587548', 'student'),
('Kai', '$2y$10$lPxoju3cfATtUVD0zX/1R.PMwEh/.TNSVKhXW7cilngFaN5zFLa8S', 'Kai@gmail.com', '016982888', 'student'),

('Ivy', '$2y$10$z4IRyPT5Klc2Ho6Mv6LeIupWcNUCSUtB151YP7TNElH5be7hgVvJ.', 'ivy@gmail.com', '0129783467', 'supervisor'),
('Jack', '$2y$10$PdNsBumSFvPy7WQsMYemI.TK3tXaDfGBuCxlKPHnjwuiVF/cm5pxy', 'jack@gmail.com', '0125786548', 'supervisor'),
('Karen', '$2y$10$v4VDbyuM8ePuiOf.Pb0ab.fMiOBefmci64OB5DufWtnigtEYOLmXu', 'karen@gmail.com', '0105485691', 'supervisor'),
('Leo', '$2y$10$HQHQysBDCA.aULK8pnm0ZO.M9pCQIH12AgYXLJxTkWOPl2vj6/e6y', 'leo@gmail.com', '0176543168', 'supervisor'),
('Sherif', '$2y$10$v/nLbVj4hIDiXZHIkFyoNOieMrj3M8/DBZck90ePqbbwb/ekw77la', 'Sherif@gmail.com', '0158792482', 'supervisor'),
('Jhon', '$2y$10$A6hpWbYBmKAxKuZ96jx76uJPifljeY2yvlP9AXfnHF4FtVc1IaohK', 'Jhon@gmail.com', '0163658987', 'supervisor');

-- admin data
INSERT INTO admin (user_ID) VALUES
(1),
(2),
(3),
(4);

-- student data
INSERT INTO student (specialization, user_ID) VALUES
('Computer Science', 5), 
('Cybersecurity', 6), 
('Game Development', 7), 
('Data Science', 8),
('Software Engineering', 9), 
('Information System', 10),
('Data Science', 11),
('Game Development', 12), 
('Software Engineering', 13), 
('Software Engineering', 14);

-- supervisor data
INSERT INTO supervisor (user_ID) VALUES
(15),
(16),
(17), 
(18),
(19),
(20);

-- proposal data
INSERT INTO proposal (
    student_name, student_ID, specialization, project_title, 
    supervisor_name, supervisor_ID, co_supervisor_name, proposed_by, 
    project_type, project_specialization, project_category, 
    industry_collaboration, file_address, proposal_status
) VALUES
    ('Charlie', 10001, 'Computer Science', 'AI-powered Chatbot for Critical Systems', 
     'Ivy', 50001, 'Jack', 'Student', 
     'Application and Research', 'Computer Science', 'Critical System', 
     'no', 'store_proposal/charlie_proposal.pdf', 'approve'),

    ('David', 10002, 'Cybersecurity', 'Advanced Cryptography Methods for Data Security', 
     'Jack', 50002, 'Karen', 'Lecture', 
     'Research', 'Cybersecurity', 'Cryptography and Data Security', 
     'no', 'store_proposal/david_proposal.pdf', 'approve'),

    ('Eva', 10003, 'Game Development', 'Immersive Game Design for Virtual Reality', 
     'Karen', 50003, 'Leo', 'Student',
     'Application', 'Game Development', 'Game Design Prototyping (GDP)', 
     'no', 'store_proposal/eva_proposal.pdf', 'pending'),

    ('Frank', 10004, 'Data Science', 'Data Analytics for Smart Healthcare Systems', 
     'Leo', 50004, 'Ivy', 'Student', 
     'Research', 'Data Science', 'Data Analytics', 
     'no', 'store_proposal/frank_proposal.pdf', 'approve'),

    ('Grace', 10005, 'Software Engineering', 'Service-Oriented System for E-Commerce', 
     'Sherif', 50005, 'Jhon', 'Industry', 
     'Application', 'Software Engineering', 'Service Oriented Computing', 
     'yes', 'store_proposal/grace_proposal.pdf', 'pending'),
    
    ('Hank', 10006, 'Information System', 'IT Infrastructure for Smart Cities', 
     'Sherif', 50005, 'Ivy', 'Lecture', 
     'Application', 'Information System', 'IT Infrastructure', 
     'yes', 'store_proposal/hank_proposal.pdf', 'approve'),

    ('AbuAbi', 10007, 'Data Science', 'Intelligent Systems for Automated Data Processing', 
     'Karen', 50003, 'Leo', 'Student', 
     'Application and Research', 'Data Science', 'Intelligent Systems', 
     'no', 'store_proposal/abuabi_proposal.pdf', 'pending'),

    ('Dom', 10008, 'Game Development', 'Game Algorithm Research for AI NPC Behavior', 
     'Leo', 50004, 'Jack', 'Industry', 
     'Research', 'Game Development', 'Game Algorithm Research (GAR)', 
     'no', 'store_proposal/dom_proposal.pdf', 'pending'),

    ('Vivian', 10009, 'Software Engineering', 'Transaction Processing Systems for Banking', 
     'Ivy', 50001, 'Sherif', 'Student', 
     'Application', 'Software Engineering', 'Transaction Processing Systems', 
     'no', 'store_proposal/vivian_proposal.pdf', 'approve'),

    ('Kai', 10010, 'Software Engineering', 'Investigation and Analysis of Software Vulnerabilities', 
     'Jhon', 50006, 'Jack', 'Student', 
     'Research', 'Software Engineering', 'Investigation and Analysis', 
     'no', 'store_proposal/kai_proposal.pdf', 'pending');

-- meeting_record data
INSERT INTO meeting_record (
    meeting_title, meeting_date, meeting_time, meeting_desc, student_ID, supervisor_ID, meeting_status
) VALUES
    ('Project Kickoff', '2025-01-15', '10:00:00', 'Discussed project scope and deliverables', 10001, 50001, 'Accept'),
    ('Cryptography Research Update', '2025-01-16', '14:00:00', 'Reviewed initial research findings', 10002, 50002, 'Cancel'),
    ('Data Analysis Plan', '2025-01-17', '11:00:00', 'Discussed methodology for data analysis', 10004, 50004, 'Pending'),
    ('Smart Cities IT Infrastructure', '2025-01-18', '09:00:00', 'Reviewed IT requirements and system design', 10006, 50005, 'Pending'),
    ('Banking TPS Review', '2025-01-19', '15:00:00', 'Discussed system integration and security', 10009, 50001, 'Pending');

-- meeting_log data
INSERT INTO meeting_log (
    file_address, student_ID
) VALUES
    ('store_meeting_log/charlie_meetingLog_1.pdf', 10001),
    ('store_meeting_log/david_meetingLog_1.pdf', 10002),
    ('store_meeting_log/frank_meetingLog_1.pdf', 10004),
    ('store_meeting_log/hank_meetingLog_1.pdf', 10006),
    ('store_meeting_log/vivian_meetingLog_1.pdf', 10009);

-- announcement data
INSERT INTO announcement (
    post_by, announcement_title, announcement_content, admin_ID
) VALUES
    ('Camellya', 'FYP PROPOSAL SUBMISSION', 'Student Must Submit Their Proposal By 3rd December. Any late submission will not be accepted', 80004);

-- event data
INSERT INTO event (
   post_by, event_date, event_title, admin_ID
) VALUES
    ('Alice', '2024-02-21', 'FYP TIPS SHARING WORKSHOP', 80001);

-- goal_and_progress data
INSERT INTO goal_and_progress (
    progress_date, current_progress, next_goal, comment, student_ID
) VALUES
    ('2024-12-12', 'Draft approved by supervisor', 'Start project implementation', 'Well-prepared proposal', 10001),
    ('2024-11-12', 'Initial research completed', 'Develop encryption prototype', 'Good progress on research', 10002),
    ('2024-12-11', 'Data collection completed', 'Perform data analysis', 'Impressive dataset preparation', 10004),
    ('2024-12-13', 'Infrastructure plan drafted', 'Implement network simulation', 'Thorough analysis provided', 10006),
    ('2024-11-13', 'System design completed', 'Begin coding transactions', 'Comprehensive design', 10009);

-- assessment data
INSERT INTO assessment (
    assessment_date, program_name, assessment_file, supervisor_ID, student_ID, clarity_objectives, understanding_problem, quality_methodology, technical_implementation, innovation, quality_report, presentation_skills, ability_answer_question, signature_file, Grade
) VALUES
    ('2025-01-31', 'Information System', 'kai_assessment.pdf', 50006, 10010, 5, 5, 4, 7, 6, 8, 5, 6, 'signature.jpg', 'C+');