CREATE TABLE if not exists users (
	u_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL,
	psw VARCHAR(255) NOT NULL,
	create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE if exists topics;
CREATE TABLE if not exists topics (
	topic_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	topic VARCHAR(50) NOT NULL
);
INSERT INTO topics (topic) VALUES ("remain for init message"), ("News"), ("Sports"), ("Movies"), ("Stocks");

CREATE TABLE if not exists messages (
	message_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	u_id INT NOT NULL,
	topic_id INT NOT NULL,
	-- parent_id INT NOT NULL DEFAULT 1, -- check out following comment for initialize table content
	parent_id INT, -- NULL if root message
	title VARCHAR(255) NOT NULL,
	content VARCHAR(255) NOT NULL,
	message_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (u_id) REFERENCES users(u_id),
	FOREIGN KEY (topic_id) REFERENCES topics(topic_id),
	FOREIGN KEY (parent_id) REFERENCES messages(message_id)
);
-- INSERT INTO messages (u_id, topic_id, title, content) VALUES ("2", "1", "init message", "this message's children are the root message of each topic");