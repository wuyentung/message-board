CREATE USER IF NOT EXISTS 'message_board_user'@'localhost'
IDENTIFIED BY '1q@W3e$R5t';
GRANT ALL PRIVILEGES ON message_board_db.*
      TO "message_board_user"@"localhost";
CREATE TABLE if not exists users (
	u_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL,
	psw VARCHAR(255) NOT NULL,
	create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);