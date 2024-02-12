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

CREATE TABLE simplyrugby.players (
player_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
address_id INT NOT NULL,
user_id INT DEFAULT NULL,
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

INSERT INTO simplyrugby.addresses (address_line, address_line2, city, county, postcode)
VALUES ('123 Rugby Rd', 'Apt 4', 'Sportstown', 'Gameshire', 'SG11 2DZ');

-- Assuming you have an entry in addresses with address_id = 1
-- Inserting into doctors
INSERT INTO simplyrugby.doctors (address_id, first_name, last_name, contact_no)
VALUES (1, 'John', 'Doe', '0123456789');


INSERT INTO simplyrugby.players (address_id, doctor_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, next_of_kin, kin_contact_no, health_issues, filename)
VALUES (1, 1, 'Jane', 'Doe', '1995-05-15', 123456789, '0987654321', '07123456789', 'jane.doe@example.com', 'Jim Doe', '0987654321', 'None','michael.png');