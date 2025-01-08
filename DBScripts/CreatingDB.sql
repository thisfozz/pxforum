CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

CREATE TABLE roles 
(
	role_id UUID PRIMARY KEY,
	role_name VARCHAR(25) UNIQUE NOT NULL
);

INSERT INTO roles (role_id, role_name) 
VALUES (uuid_generate_v4(), 'User');

CREATE TABLE users
(
	user_id UUID PRIMARY KEY,
	login VARCHAR(20) UNIQUE NOT NULL,
	email VARCHAR(255) UNIQUE NOT NULL,
	password_hash VARCHAR(255) NOT NULL,
	role_id UUID,
	display_name VARCHAR(20) UNIQUE,
	created_at DATE DEFAULT CURRENT_DATE,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	is_deleted BOOLEAN DEFAULT FALSE,
	CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE SET NULL
);

CREATE TABLE user_details 
(
    user_id UUID PRIMARY KEY REFERENCES users(user_id) ON DELETE CASCADE,
	display_name VARCHAR(30),
    avatar_url VARCHAR(2048),
    birthdate DATE,
    first_name VARCHAR(50),
    last_name VARCHAR(50)
);

CREATE TABLE topics
(
	topic_id UUID PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	created_at DATE DEFAULT CURRENT_DATE,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	created_by UUID REFERENCES users(user_id)
);

CREATE TABLE posts
(
	post_id UUID PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	content TEXT NOT NULL,
	status VARCHAR(20) CHECK (status IN ('open', 'closed', 'archived')) DEFAULT 'open',
	created_at DATE DEFAULT CURRENT_DATE,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	topic_id UUID REFERENCES topics(topic_id)
);

CREATE TABLE replies
(
	reply_id UUID PRIMARY KEY,
	"content" TEXT NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	post_id UUID REFERENCES posts(post_id)
);

CREATE TABLE post_likes (
    like_id UUID PRIMARY KEY,
    user_id UUID REFERENCES users(user_id) ON DELETE CASCADE,
    reply_id UUID REFERENCES replies(reply_id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Уникальность лайков на одном ответе от одного пользователя
CREATE UNIQUE INDEX idx_user_reply_like ON post_likes(user_id, reply_id);

CREATE TABLE user_changes_logs (
    log_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    user_id UUID REFERENCES users(user_id) ON DELETE CASCADE,
    field_name VARCHAR(50),
    old_value TEXT,
    new_value TEXT,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    changed_by UUID REFERENCES users(user_id)
);