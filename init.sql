CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(90) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(200) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'employee',
    api_token VARCHAR(255) UNIQUE
);

CREATE TABLE IF NOT EXISTS categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS questions (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id INT REFERENCES categories(id) ON DELETE SET NULL,
    question_text TEXT NOT NULL,
    is_discussed BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (name) VALUES
('IT'),
('Technical'),
('HR'),
('Finance'),
('Marketing')
ON CONFLICT (name) DO NOTHING;