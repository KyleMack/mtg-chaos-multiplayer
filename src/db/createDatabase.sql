DROP DATABASE IF EXISTS chaos_db;
DROP USER chaos_user CASCADE;
DROP USER chaos_admin CASCADE;

CREATE USER chaos_user;
CREATE USER chaos_admin;

ALTER USER chaos_user WITH PASSWORD 'snowwhale420hotdog';
ALTER USER chaos_admin WITH PASSWORD 'hotdigcatwallbearscoop';

CREATE DATABASE chaos_db;

GRANT SELECT ON ALL TABLES IN SCHEMA chaos_db TO chaos_user;
GRANT ALL ON ALL TABLES IN SCHEMA chaos_db TO chaos_admin;