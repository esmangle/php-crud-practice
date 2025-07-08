CREATE DATABASE phpPracticeDB;

USE phpPracticeDB;

CREATE TABLE users (
	id int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	username varchar(20) CHARACTER SET ascii COLLATE ascii_general_ci UNIQUE NOT NULL,
	bio varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
	pass char(60) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
	creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
	id bigint UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	author_id int UNSIGNED NOT NULL,
	parent_id bigint UNSIGNED DEFAULT NULL,
	content varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	likes int UNSIGNED DEFAULT 0,
	replies int UNSIGNED DEFAULT 0,
	deleted boolean DEFAULT 0,
	creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (parent_id) REFERENCES posts(id) ON DELETE SET NULL,
	INDEX (creation_date)
);

CREATE TABLE likes (
	user_id int UNSIGNED NOT NULL,
	post_id bigint UNSIGNED NOT NULL,
	creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (user_id, post_id),
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
	INDEX (creation_date)
);
