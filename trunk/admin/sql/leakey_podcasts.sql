DROP DATABASE IF EXISTS leakey_podcasts;
CREATE DATABASE leakey_podcasts
	CHARACTER SET utf8;
USE leakey_podcasts;

CREATE TABLE groups (
	group_id INT NOT NULL AUTO_INCREMENT,
	group_name VARCHAR(30),
	group_enabled BOOLEAN DEFAULT 1,
	PRIMARY KEY (group_id)

);

CREATE TABLE users (
	user_id INT NOT NULL AUTO_INCREMENT,
	user_name VARCHAR(30),
	user_firstname VARCHAR(30),
	user_lastname VARCHAR(30),
	user_groupsId INT REFERENCES groups(group_id),
	user_enabled BOOLEAN DEFAULT 1,
	PRIMARY KEY(user_id)
);

CREATE TABLE categories (
	category_id INT NOT NULL AUTO_INCREMENT,
	category_name VARCHAR(30),
	category_parent INT REFERENCES categories(category_id),
	category_enabled BOOLEAN DEFAULT 1,
	PRIMARY KEY(category_id)
);

CREATE TABLE podcasts (
	podcast_id INT NOT NULL AUTO_INCREMENT,
	podcast_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	podcast_file VARCHAR(100),
	podcast_createBy INT REFERENCES users(user_id),
	podcast_categoryId INT REFERENCES categories(category_id),
	podcast_ipaddress VARCHAR(15),
	podcast_source VARCHAR(100),
	podcast_programName VARCHAR(100),
	podcast_showName VARCHAR(100),
	podcast_year VARCHAR(4),
	podcast_url VARCHAR(100),
	podcast_summary MEDIUMTEXT,
	podcast_acknowledgement BOOLEAN DEFAULT 0,
	podcast_permission_review BOOLEAN DEFAULT 0,
	podcast_approved BOOLEAN DEFAULT 0,
	podcast_approvedBy INT REFERENCES users(user_id),
	podcast_quality INT,
	podcast_enabled BOOLEAN DEFAULT 1,
	PRIMARY KEY(podcast_id)
);

INSERT INTO groups(group_name) VALUES('admins');
INSERT INTO groups(group_name) VALUES('users');

