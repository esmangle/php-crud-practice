CREATE DATABASE phpPracticeDB;

USE phpPracticeDB;

CREATE TABLE users (
	id int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	username varchar(32) UNIQUE NOT NULL,
	bio varchar(500) NOT NULL DEFAULT '',
	password varchar(60) NOT NULL,
	creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
	id int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	author_id int UNSIGNED NOT NULL,
	parent_id int UNSIGNED DEFAULT NULL,
	content varchar(500) NOT NULL,
	likes int DEFAULT 0,
	replies int DEFAULT 0,
	deleted boolean DEFAULT 0,
	creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (parent_id) REFERENCES posts(id) ON DELETE SET NULL
);

CREATE TABLE likes (
	user_id int UNSIGNED NOT NULL,
	post_id int UNSIGNED NOT NULL,
	creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (user_id, post_id),
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
