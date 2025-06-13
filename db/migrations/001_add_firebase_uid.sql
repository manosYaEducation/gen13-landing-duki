-- Añadir columna firebase_uid a la tabla users
ALTER TABLE users ADD COLUMN firebase_uid VARCHAR(255) UNIQUE AFTER id;
