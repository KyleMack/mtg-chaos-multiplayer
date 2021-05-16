CREATE USER chaos_user;
CREATE USER chaos_admin;

ALTER USER chaos_user WITH PASSWORD 'snowwhale420hotdog';
ALTER USER chaos_admin WITH PASSWORD 'hotdigcatwallbearscoop';

CREATE DATABASE chaos_db;

GRANT SELECT ON DATABASE chaos_db TO chaos_user;
GRANT ALL PRIVILEGES ON DATABASE chaos_db TO chaos_admin;