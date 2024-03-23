USE naturalHRTest;
CREATE TABLE IF NOT EXISTS entries (
    `id` INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    `subject` TEXT,
    `body` TEXT );
CREATE TABLE IF NOT EXISTS drafts (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `subject` TEXT,
    `body` TEXT );
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL,
    `file_location` varchar(100));
INSERT INTO drafts VALUES( NULL, 'My First Post','My First Post Body');