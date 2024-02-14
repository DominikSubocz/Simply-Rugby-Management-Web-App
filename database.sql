DROP DATABASE IF EXISTS simplyrugby;
CREATE DATABASE simplyrugby;

CREATE TABLE simplyrugby.addresses (
  address_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  address_line VARCHAR(48) NOT NULL,
  address_line2 VARCHAR(48) NOT NULL,
  city varchar(40) NOT NULL,
  county varchar(40) NOT NULL,
  postcode varchar(10) NOT NULL
);

CREATE TABLE simplyrugby.users (
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(32) UNIQUE NOT NULL,
  email VARCHAR(128) NOT NULL,
  password VARCHAR(60) NOT NULL,
  user_role VARCHAR(24) NOT NULL DEFAULT "Member"
);

CREATE TABLE simplyrugby.doctors(
doctor_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
address_id INT NOT NULL,
first_name  varchar(32) NOT NULL,
last_name  varchar(32) NOT NULL,
contact_no  varchar(40) NOT NULL,
FOREIGN KEY (address_id) REFERENCES simplyrugby.addresses (address_id)

);

CREATE TABLE simplyrugby.juniors(
junior_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
address_id INT NOT NULL,
user_id INT,
first_name  varchar(32) NOT NULL,
last_name  varchar(32) NOT NULL,
dob DATE,
sru_no  INT NOT NULL,
contact_no  varchar(40) NOT NULL,
mobile_no  varchar(40),
email_address varchar(45),
health_issues TEXT,
filename VARCHAR(64),
FOREIGN KEY (address_id) REFERENCES simplyrugby.addresses (address_id),
FOREIGN KEY (user_id) REFERENCES simplyrugby.users (user_id)
);



CREATE TABLE simplyrugby.players (
player_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
address_id INT NOT NULL,
user_id INT,
doctor_id int NOT NULL,
first_name  varchar(32) NOT NULL,
last_name  varchar(32) NOT NULL,
dob DATE,
sru_no  INT NOT NULL,
contact_no  varchar(40) NOT NULL,
mobile_no  varchar(40),
email_address varchar(45),
next_of_kin varchar(32),
kin_contact_no  varchar(40) NOT NULL,
health_issues TEXT,
filename VARCHAR(64),
FOREIGN KEY (address_id) REFERENCES simplyrugby.addresses (address_id),
FOREIGN KEY (user_id) REFERENCES simplyrugby.users (user_id),
FOREIGN KEY (doctor_id) REFERENCES simplyrugby.doctors (doctor_id)

);

CREATE TABLE simplyrugby.members (
  member_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  address_id INT NOT NULL,
  user_id INT,
  first_name  varchar(32) NOT NULL,
  last_name  varchar(32) NOT NULL,
  dob DATE,
  sru_no  INT NOT NULL,
  contact_no  varchar(40) NOT NULL,
  mobile_no  varchar(40),
  email_address varchar(45),
  filename VARCHAR(64),
  FOREIGN KEY (address_id) REFERENCES simplyrugby.addresses (address_id),
  FOREIGN KEY (user_id) REFERENCES simplyrugby.users (user_id)
);

CREATE TABLE simplyrugby.skills (
  skill_id  INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  category varchar(30) NOT NULL,
  skill_name varchar(30) NOT NULL
);

CREATE TABLE simplyrugby.squads (
  squad_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
  squad_name varchar(45) NOT NULL,
  squad_level varChar(32) NOT NULL
);

CREATE TABLE simplyrugby.junior_skills (
  junior_id INT NOT NULL,
  skill_id INT NOT NULL,
  squad_id INT NOT NULL,
  skill_level INT NOT NULL,
  comment TEXT,
  PRIMARY KEY (junior_id, skill_id),
  FOREIGN KEY (junior_id) REFERENCES simplyrugby.juniors(junior_id),
  FOREIGN KEY (skill_id) REFERENCES skills(skill_id)
);

INSERT INTO simplyrugby.addresses (address_line, address_line2, city, county, postcode)
VALUES ('123 Rugby Rd', 'Apt 4', 'Sportstown', 'Gameshire', 'SG11 2DZ');

-- Assuming you have an entry in addresses with address_id = 1
-- Inserting into doctors
INSERT INTO simplyrugby.doctors (address_id, first_name, last_name, contact_no)
VALUES (1, 'John', 'Doe', '0123456789');


INSERT INTO simplyrugby.players (address_id, doctor_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, next_of_kin, kin_contact_no, health_issues, filename)
VALUES (1, 1, 'Jane', 'Doe', '1995-05-15', 123456789, '0987654321', '07123456789', 'jane.doe@example.com', 'Jim Doe', '0987654321', 'None','michael.png');

INSERT INTO simplyrugby.juniors (address_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, health_issues, filename)
VALUES (1, 'John', 'Doe', '2008-03-15', 987654321, '0123456789', '07123456789', 'john.doe@example.com', 'None', 'john.jpg');

INSERT INTO simplyrugby.members (address_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, filename)
VALUES (1, 'Johnatan', 'Banks', '1965-04-25', 987654321, '0123456789', '07123456789', 'johnatanbanks@yahoo.com', 'johnatan.jpg');

INSERT INTO simplyrugby.skills (category, skill_name) VALUES
('Passing', 'Standard'),
('Passing', 'Spin'),
('Passing', 'Pop'),
('Tackling', 'Front'),
('Tackling', 'Rear'),
('Tackling', 'Side'),
('Tackling', 'Scrabble'),
('Kicking', 'Drop'),
('Kicking', 'Punt'),
('Kicking', 'Grubber'),
('Kicking', 'Goal');

-- Inserting squads into the simplyrugby.squads table
INSERT INTO simplyrugby.squads (squad_name, squad_level) VALUES
('Senior Squad 1', 'Senior'),
('Senior Squad 2', 'Senior'),
('Junior Squad 1', 'Junior'),
('Junior Squad 2', 'Junior');

-- Inserting junior skills into the simplyrugby.junior_skills table
INSERT INTO simplyrugby.junior_skills (junior_id, skill_id, squad_id, skill_level, comment) VALUES
(1, 1, 1, 4, 'Good passer'),
(1, 2, 1, 3, 'Needs improvement on spin pass'),
(1, 3, 1, 5, 'Excellent pop pass'),
(1, 4, 1, 4, 'Great passing skills'),
(1, 5, 1, 3, 'Average tackling technique'),
(1, 6, 1, 5, 'Exceptional scrabble ability'),
(1, 7, 1, 5, 'Outstanding kicking accuracy'),
(1, 8, 1, 4, 'Impressive drop kick technique'),
(1, 9, 1, 3, 'Room for improvement in punting'),
(1, 10, 1, 5, 'Superb goal-kicking proficiency'),
(1, 11, 1, 5, 'Top-notch leadership qualities');
