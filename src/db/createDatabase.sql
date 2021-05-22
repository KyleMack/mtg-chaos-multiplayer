DROP DATABASE IF EXISTS chaos_db;
DROP USER IF EXISTS chaos_user;
DROP USER IF EXISTS chaos_admin;
DROP ROLE IF EXISTS chaos_readonly;
DROP ROLE IF EXISTS chaos_readwrite;

CREATE DATABASE chaos_db;
CREATE ROLE chaos_readonly;
CREATE ROLE chaos_readwrite;

\c chaos_db;

GRANT USAGE ON SCHEMA public TO chaos_readonly;
GRANT USAGE, CREATE ON SCHEMA public TO chaos_readwrite;

ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT ON TABLES TO chaos_readonly;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO chaos_readwrite;

GRANT USAGE ON ALL SEQUENCES IN SCHEMA public TO chaos_readwrite;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT USAGE ON SEQUENCES TO chaos_readwrite;

CREATE USER chaos_user WITH PASSWORD 'snowwhale420hotdog';
CREATE USER chaos_admin WITH PASSWORD 'hotdigcatwallbearscoop';

GRANT chaos_readonly TO chaos_user;
GRANT chaos_readwrite TO chaos_admin;