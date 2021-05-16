DROP DATABASE IF EXISTS chaos_db;
DROP USER chaos_user;
DROP USER chaos_admin;

CREATE DATABASE chaos_db;

CREATE USER chaos_user WITH PASSWORD 'snowwhale420hotdog';
CREATE USER chaos_admin WITH PASSWORD 'hotdigcatwallbearscoop';

GRANT SELECT ON ALL TABLES IN SCHEMA chaos_db TO chaos_user;
GRANT ALL PRIVILEGES ON chaos_db TO chaos_admin;