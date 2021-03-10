CREATE USER chaos_user;
CREATE USER chaos_admin;

ALTER USER chaos_user WITH PASSWORD '*password*';
ALTER USER chaos_admin WITH PASSWORD '*password*';

CREATE DATABASE chaos_db;

GRANT SELECT ON DATABASE chaos_db TO chaos_user;
GRANT ALL PRIVILEGES ON DATABASE chaos_db TO chaos_admin;