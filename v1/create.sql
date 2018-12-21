DROP DATABASE gallery;
CREATE DATABASE gallery;
USE gallery;
CREATE TABLE customer (
	id INT(11) NOT NULL AUTO_INCREMENT,
	username VARCHAR(256) NOT NULL,
	firstname VARCHAR(256) NOT NULL,	
	lastname VARCHAR(256) NOT NULL,
	email VARCHAR(256) NOT NULL,
	password VARCHAR(256) NOT NULL,
	created_at DATE NOT NULL,
	city VARCHAR(256),
	state VARCHAR(256),
	country VARCHAR(256),
	credit int(11) default 1,
	PRIMARY KEY (id)
);
CREATE TABLE image (
	category VARCHAR(256) NOT NULL,
	id INT(11) NOT NULL AUTO_INCREMENT,
	name VARCHAR(256) NOT NULL,
	resolution VARCHAR(256),
	size INT(11),
	author int(11) NOT NULL,
	image_type VARCHAR(256),
	filename VARCHAR(256),
	purchased INT(11) NOT NULL,
	price INT(11) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (author) REFERENCES customer(id)
);
CREATE TABLE transaction (
	user_id INT(11) NOT NULL,
	image_id INT(11) NOT NULL,
	date DATE NOT NULL,
	price INT(11) NOT NULL
);
CREATE TABLE usergallery (
	user_id INT(11) NOT NULL,
	image_id INT(11) NOT NULL,
	image_status VARCHAR(256) NOT NULL
);