DROP DATABASE IF EXISTS simplyrugby;
CREATE DATABASE simplyrugby;

CREATE TABLE simplyrugby.addresses (
  address_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  address_line VARCHAR(48) NOT NULL,
  address_line2 VARCHAR(48),
  city varchar(40) NOT NULL,
  county varchar(40),
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
doctor_first_name  varchar(32) NOT NULL,
doctor_last_name  varchar(32) NOT NULL,
doctor_contact_no  varchar(40) NOT NULL
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

CREATE TABLE simplyrugby.guardians(
  guardian_id INT AUTO_INCREMENT PRIMARY KEY,
  address_id INT NOT NULL,
  guardian_first_name varchar(48) NOT NULL,
  guardian_last_name varchar(48) NOT NULL,
  guardian_contact_no int NOT NULL,
  relationship varchar(35) NOT NULL,
  FOREIGN KEY (address_id) REFERENCES addresses(address_id)
);

CREATE TABLE simplyrugby.junior_associations(
  association_id INT AUTO_INCREMENT PRIMARY KEY,
  junior_id INT NOT NULL,
  guardian_id INT NOT NULL,
  doctor_id INT NOT NULL,
  FOREIGN KEY (junior_id) REFERENCES juniors(junior_id),
  FOREIGN KEY (guardian_id) REFERENCES guardians(guardian_id),
  FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
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

CREATE TABLE simplyrugby.player_skills (
  player_id INT NOT NULL,
  skill_id INT NOT NULL,
  squad_id INT NOT NULL,
  skill_level INT NOT NULL,
  comment TEXT,
  PRIMARY KEY (player_id, skill_id),
  FOREIGN KEY (player_id) REFERENCES simplyrugby.players(player_id),
  FOREIGN KEY (skill_id) REFERENCES skills(skill_id)
);

CREATE TABLE simplyrugby.positions (
  position_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  position varchar(45)
);

CREATE TABLE simplyrugby.junior_positions (
  position_id int NOT NULL,
  junior_id int NOT NULL,
  
  PRIMARY KEY(position_id, junior_id),
  FOREIGN KEY (position_id) REFERENCES simplyrugby.positions (position_id),
  FOREIGN KEY (junior_id) REFERENCES simplyrugby.juniors (junior_id)
);

CREATE TABLE simplyrugby.player_positions (
  position_id int NOT NULL,
  player_id int NOT NULL,
  
  PRIMARY KEY(position_id, player_id),
  FOREIGN KEY (position_id) REFERENCES simplyrugby.positions (position_id),
  FOREIGN KEY (player_id) REFERENCES simplyrugby.players (player_id)
);

CREATE TABLE simplyrugby.games(
  game_id INT PRIMARY KEY AUTO_INCREMENT,
  squad_id INT NOT NULL,
  name varchar(128) NOT NULL,
  opposition_team varchar(45) NOT NULL,
  start DATETIME NOT NULL,
  end DATETIME NOT NULL,
  location varchar(128) NOT NULL,
  kickoff_time TIME NOT NULL,
  result varchar(15),
  score INT,
  color VARCHAR(30),
  FOREIGN KEY (squad_id) REFERENCES simplyrugby.squads (squad_id)
);

CREATE TABLE simplyrugby.sessions(
  session_id INT PRIMARY KEY AUTO_INCREMENT,
  coach_id INT NOT NULL,
  squad_id INT NOT NULL,
  name varchar(128) NOT NULL,
  start DATETIME NOT NULL,
  end DATETIME NOT NULL,
  location varchar(128) NOT NULL,
  FOREIGN KEY (coach_id) REFERENCES simplyrugby.coaches (coach_id),
  FOREIGN KEY (squad_id) REFERENCES simplyrugby.squads (squad_id)
);

CREATE TABLE simplyrugby.coaches(
  coach_id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  first_name  varchar(32) NOT NULL,
  last_name  varchar(32) NOT NULL,
  dob DATE,
  contact_no  varchar(40) NOT NULL,
  mobile_no  varchar(40),
  email_address varchar(45),
  FOREIGN KEY (user_id) REFERENCES simplyrugby.users (user_id)
);

INSERT INTO simplyrugby.coaches (first_name, last_name, dob, contact_no, mobile_no, email_address) 
VALUES 
('John', 'Doe', '1990-05-15', '123456789', '987654321', 'john.doe@example.com'),
('Alice', 'Smith', '1985-10-20', '987654321', NULL, 'alice.smith@example.com');


INSERT INTO simplyrugby.addresses (address_line, address_line2, city, county, postcode)
VALUES 
('456 Rugby St', 'Apt 3', 'Sportstown', 'Gameshire', 'SG11 3AA'),
('789 Rugby Ave', NULL, 'Sportsville', 'Gameshire', 'SG11 4BB'),
('1010 Rugby Blvd', 'Unit 8', 'Athleticsburg', 'Gameshire', 'SG11 5CC'),
('1111 Rugby Rd', 'Suite 12', 'Fitness City', 'Gameshire', 'SG11 6DD'),
('1313 Rugby Lane', NULL, 'Healthytown', 'Gameshire', 'SG11 7EE');

-- Sample data for simplyrugby.doctors table
INSERT INTO simplyrugby.doctors (doctor_first_name, doctor_last_name, doctor_contact_no)
VALUES 
('Michael', 'Jordan', '0123456789'),
('LeBron', 'James', '9876543210'),
('Serena', 'Williams', '1112223333'),
('Rafael', 'Nadal', '4445556666'),
('Roger', 'Federer', '7778889999');

INSERT INTO simplyrugby.players (address_id, doctor_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, next_of_kin, kin_contact_no, health_issues, filename)
VALUES 
(1, 2, 'John', 'Doe', '1995-05-15', 123456789, '0987654321', '07123456789', 'john.doe@example.com', 'Jim Doe', '0987654321', 'None', 'johndoe_player.jpg'),
(3, 1, 'Jane', 'Smith', '1990-10-20', 987654321, '0123456789', '07123456789', 'jane.smith@example.com', 'Alice Smith', '0123456789', 'Asthma', 'janedoe_player.jpg'),
(2, 3, 'Michael', 'Brown', '2002-08-05', 543216789, '0198765432', '07123456789', 'michael.brown@example.com', 'Emma Brown', '0198765432', 'None', 'michael.jpg'),
(4, 1, 'Sarah', 'Johnson', '1998-03-30', 654321789, '0147852369', '07123456789', 'sarah.johnson@example.com', 'David Johnson', '0147852369', 'None', 'sarahplayer.jpg'),
(5, 5, 'David', 'Wilson', '2005-12-12', 234567891, '0157842369', '07123456789', 'david.wilson@example.com', 'Emma Wilson', '0157842369', 'None', 'david.jpg');


-- Sample data for simplyrugby.juniors table
INSERT INTO simplyrugby.juniors (address_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, health_issues, filename)
VALUES 
(1, 'Jamie', 'Doe', '2008-03-15', 123456, '0123456789', '07123456789', 'jamie.doe@example.com', 'None', 'jamiedoe_junior.jpg'),
(2, 'Jack', 'Jeff', '2009-05-20', 789012, '9876543210', '07987654321', 'jack.jeff@example.com', 'Asthma', 'jackjeff_junior.jpg'),
(3, 'Xi', 'Jin', '2010-07-25', 345678, '5554443333', '07555444333', 'xi.jin@example.com', 'None', 'xijin_junior.jpg'),
(4, 'Emily', 'Brown', '2011-09-30', 901234, '3332221111', '07333221111', 'emily.brown@example.com', 'Food Allergy', 'emilybrown_junior.jpg'),
(5, 'Alex', 'Smith', '2012-11-05', 567890, '1112223333', '07111222333', 'alex.smith@example.com', 'None', 'alexsmith_junior.jpg');

-- Sample data for simplyrugby.members table
INSERT INTO simplyrugby.members (address_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, filename)
VALUES (1, 'Johnatan', 'Banks', '1965-04-25', 987654321, '0123456789', '07123456789', 'johnatanbanks@yahoo.com', 'johnatanbanks_member.jpg'),
        (2, 'Laura', 'Taylor', '1978-04-15', 678901, '7778889999', '07778889999', 'laura.taylor@example.com', 'laura.jpg'),
        (3, 'Steven', 'Williams', '1990-06-20', 123456, '9998887777', '07999888777', 'steven.williams@example.com', 'steven.jpg'),
        (4, 'Jessica', 'Martinez', '1993-08-25', 789012, '6667778888', '07666777888', 'jessica.martinez@example.com', 'jessica.jpg'),
        (5, 'Daniel', 'Anderson', '1980-10-30', 567890, '4445556666', '07444556666', 'daniel.anderson@example.com', 'daniel.jpg');
        

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
(1, 1, 3, 4, 'Good passer'),
(1, 2, 3, 3, 'Needs improvement on spin pass'),
(1, 3, 3, 5, 'Excellent pop pass'),
(1, 4, 3, 4, 'Great passing skills'),
(1, 5, 3, 3, 'Average tackling technique'),
(1, 6, 3, 5, 'Exceptional scrabble ability'),
(1, 7, 3, 5, 'Outstanding kicking accuracy'),
(1, 8, 3, 4, 'Impressive drop kick technique'),
(1, 9, 3, 3, 'Room for improvement in punting'),
(1, 10, 3, 5, 'Superb goal-kicking proficiency'),
(1, 11, 3, 5, 'Top-notch leadership qualities'),

(2, 1, 4, 4, 'Good passer'),
(2, 2, 4, 3, 'Needs improvement on spin pass'),
(2, 3, 4, 5, 'Excellent pop pass'),
(2, 4, 4, 4, 'Great passing skills'),
(2, 5, 4, 3, 'Average tackling technique'),
(2, 6, 4, 5, 'Exceptional scrabble ability'),
(2, 7, 4, 5, 'Outstanding kicking accuracy'),
(2, 8, 4, 4, 'Impressive drop kick technique'),
(2, 9, 4, 3, 'Room for improvement in punting'),
(2, 10, 4, 5, 'Superb goal-kicking proficiency'),
(2, 11, 4, 5, 'Top-notch leadership qualities'),

(3, 1, 4, 4, 'Good passer'),
(3, 2, 4, 3, 'Needs improvement on spin pass'),
(3, 3, 4, 5, 'Excellent pop pass'),
(3, 4, 4, 4, 'Great passing skills'),
(3, 5, 4, 3, 'Average tackling technique'),
(3, 6, 4, 5, 'Exceptional scrabble ability'),
(3, 7, 4, 5, 'Outstanding kicking accuracy'),
(3, 8, 4, 4, 'Impressive drop kick technique'),
(3, 9, 4, 3, 'Room for improvement in punting'),
(3, 10, 4, 5, 'Superb goal-kicking proficiency'),
(3, 11, 4, 5, 'Top-notch leadership qualities'),

(4, 1, 3, 4, 'Good passer'),
(4, 2, 3, 3, 'Needs improvement on spin pass'),
(4, 3, 3, 5, 'Excellent pop pass'),
(4, 4, 3, 4, 'Great passing skills'),
(4, 5, 3, 3, 'Average tackling technique'),
(4, 6, 3, 5, 'Exceptional scrabble ability'),
(4, 7, 3, 5, 'Outstanding kicking accuracy'),
(4, 8, 3, 4, 'Impressive drop kick technique'),
(4, 9, 3, 3, 'Room for improvement in punting'),
(4, 10, 3, 5, 'Superb goal-kicking proficiency'),
(4, 11, 3, 5, 'Top-notch leadership qualities'),

(5, 1, 3, 4, 'Good passer'),
(5, 2, 3, 3, 'Needs improvement on spin pass'),
(5, 3, 3, 5, 'Excellent pop pass'),
(5, 4, 3, 4, 'Great passing skills'),
(5, 5, 3, 3, 'Average tackling technique'),
(5, 6, 3, 5, 'Exceptional scrabble ability'),
(5, 7, 3, 5, 'Outstanding kicking accuracy'),
(5, 8, 3, 4, 'Impressive drop kick technique'),
(5, 9, 3, 3, 'Room for improvement in punting'),
(5, 10, 3, 5, 'Superb goal-kicking proficiency'),
(5, 11, 3, 5, 'Top-notch leadership qualities');

INSERT INTO simplyrugby.player_skills (player_id, skill_id, squad_id, skill_level, comment) 
VALUES
(1, 1, 1, 4, 'Good passer'),
(1, 2, 1, 3, 'Needs improvement on spin pass'),
(1, 3, 1, 5, 'Excellent pop pass'),
(1, 4, 1, 4, 'Good passer'),
(1, 5, 1, 3, 'Needs improvement on spin pass'),
(1, 6, 1, 5, 'Excellent pop pass'),
(1, 7, 1, 5, 'Excellent pop pass'),
(1, 8, 1, 4, 'Good passer'),
(1, 9, 1, 3, 'Needs improvement on spin pass'),
(1, 10, 1, 5, 'Excellent pop pass'),
(1, 11, 1, 5, 'Excellent pop pass'),

(2, 1, 1, 4, 'Good passer'),
(2, 2, 1, 3, 'Needs improvement on spin pass'),
(2, 3, 1, 5, 'Excellent pop pass'),
(2, 4, 1, 4, 'Good passer'),
(2, 5, 1, 3, 'Needs improvement on spin pass'),
(2, 6, 1, 5, 'Excellent pop pass'),
(2, 7, 1, 5, 'Excellent pop pass'),
(2, 8, 1, 4, 'Good passer'),
(2, 9, 1, 3, 'Needs improvement on spin pass'),
(2, 10, 1, 5, 'Excellent pop pass'),
(2, 11, 1, 5, 'Excellent pop pass'),

(3, 1, 2, 4, 'Good passer'),
(3, 2, 2, 3, 'Needs improvement on spin pass'),
(3, 3, 2, 5, 'Excellent pop pass'),
(3, 4, 2, 4, 'Good passer'),
(3, 5, 2, 3, 'Needs improvement on spin pass'),
(3, 6, 2, 5, 'Excellent pop pass'),
(3, 7, 2, 5, 'Excellent pop pass'),
(3, 8, 2, 4, 'Good passer'),
(3, 9, 2, 3, 'Needs improvement on spin pass'),
(3, 10,2, 5, 'Excellent pop pass'),
(3, 11, 2, 5, 'Excellent pop pass'),

(4, 1, 2, 4, 'Good passer'),
(4, 2, 2, 3, 'Needs improvement on spin pass'),
(4, 3, 2, 5, 'Excellent pop pass'),
(4, 4, 2, 4, 'Good passer'),
(4, 5, 2, 3, 'Needs improvement on spin pass'),
(4, 6, 2, 5, 'Excellent pop pass'),
(4, 7, 2, 5, 'Excellent pop pass'),
(4, 8, 2, 4, 'Good passer'),
(4, 9, 2, 3, 'Needs improvement on spin pass'),
(4, 10, 2, 5, 'Excellent pop pass'),
(4, 11, 2, 5, 'Excellent pop pass'),

(5, 1, 1, 4, 'Good passer'),
(5, 2, 1, 3, 'Needs improvement on spin pass'),
(5, 3, 1, 5, 'Excellent pop pass'),
(5, 4, 1, 4, 'Good passer'),
(5, 5, 1, 3, 'Needs improvement on spin pass'),
(5, 6, 1, 5, 'Excellent pop pass'),
(5, 7, 1, 5, 'Excellent pop pass'),
(5, 8, 1, 4, 'Good passer'),
(5, 9, 1, 3, 'Needs improvement on spin pass'),
(5, 10, 1, 5, 'Excellent pop pass'),
(5, 11, 1, 5, 'Excellent pop pass');



INSERT INTO simplyrugby.positions (position) VALUES
("Full back"),
("Wing"),
("Centre"),
("Fly half"),
("Scrum half"),
("Hooker"),
("Prop"),
("2nd row"),
("Back Row");

INSERT INTO simplyrugby.junior_positions (position_id,junior_id) VALUES
(1,1),
(3,1),
(7,1),
(1,2),
(3,2),
(7,2),
(1,3),
(3,3),
(7,3),
(1,4),
(3,4),
(7,4),
(1,5),
(3,5),
(7,5);


INSERT INTO simplyrugby.player_positions (position_id,player_id) VALUES
(4,1),
(6,1),
(2,1),
(4,2),
(6,2),
(2,2),
(4,3),
(6,3),
(2,3),
(4,4),
(6,4),
(2,4),
(4,5),
(6,5),
(2,5);

INSERT INTO simplyrugby.guardians (address_id, guardian_first_name, guardian_last_name, guardian_contact_no, relationship)
VALUES 
(1, 'Michael', 'Smith', 5556667777, 'Father'),
(2, 'Laura', 'Taylor', 7778889999, 'Aunt'),
(3, 'Steven', 'Williams', 9998887777, 'Uncle'),
(4, 'Jessica', 'Martinez', 6667778888, 'Mother'),
(5, 'Daniel', 'Anderson', 4445556666, 'Father');


-- Sample data for simplyrugby.junior_associations table
INSERT INTO simplyrugby.junior_associations (junior_id, guardian_id, doctor_id) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

-- (1, 'Michael', 'Smith', '1985-02-10', 654321, '5556667777', '07555667777', 'michael.smith@example.com', 'michael.jpg'),