CREATE TABLE users (
	user_id INT NOT NULL AUTO_INCREMENT,
	user_name VARCHAR(30),
	user_firstname VARCHAR(30),
	user_lastname VARCHAR(30),
	user_class VARCHAR(20),
	user_section VARCHAR(20),
	user_ta VARCHAR(20),
	user_admin BOOLEAN DEFAULT 0,
	user_enabled BOOLEAN DEFAULT 1,
	user_time_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(user_id)
);

CREATE TABLE categories (
	category_id INT NOT NULL AUTO_INCREMENT,
	category_name VARCHAR(30),
	category_filename VARCHAR(30),
	category_nav_filename VARCHAR(30),
	category_enabled BOOLEAN DEFAULT 1,
	category_time_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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
	podcast_short_summary TINYTEXT,
	podcast_summary MEDIUMTEXT,
	podcast_acknowledgement BOOLEAN DEFAULT 0,
	podcast_review_permission BOOLEAN DEFAULT 0,
	podcast_approved BOOLEAN DEFAULT 0,
	podcast_approvedBy INT REFERENCES users(user_id),
	podcast_quality INT DEFAULT 1,
	podcast_enabled BOOLEAN DEFAULT 1,
	PRIMARY KEY(podcast_id)
);


