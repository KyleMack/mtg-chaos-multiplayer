
DROP TABLE IF EXISTS players;
DROP TABLE IF EXISTS active_games;
DROP TABLE IF EXISTS game_players;
DROP TABLE IF EXISTS game_rules;

\c chaos_db;

CREATE TABLE players(
    player_id         CHAR(10) NOT NULL,
    username          VARCHAR(25) NOT NULL,

    PRIMARY KEY (player_id)
);

CREATE TABLE active_games(
    game_code         CHAR(5) NOT NULL UNIQUE,
    owner_id          CHAR(10) NOT NULL,
    game_expiry_time  TIMESTAMP NOT NULL,

    PRIMARY KEY (game_code),
    FOREIGN KEY (owner_id) REFERENCES players(player_id)
);

CREATE TABLE game_players(
    player_id         CHAR(10) NOT NULL,
    active_game_code  CHAR(5) NOT NULL,
   
    FOREIGN KEY (player_id) REFERENCES players(player_id),
    FOREIGN KEY (active_game_code) REFERENCES active_games(game_code)
);

CREATE TABLE rules(
   rule_code CHAR(4),
   rule_text TEXT NOT NULL,

   PRIMARY KEY (rule_code)
);

CREATE TABLE game_rules(
    active_game_code  CHAR(5) NOT NULL,
    rule_code         CHAR(4) NOT NULL,
    rule_order        INT NOT NULL,
   
    FOREIGN KEY (active_game_code) REFERENCES active_games(game_code)
);

CREATE INDEX active_games_index ON active_games (game_code);
CREATE INDEX players_index ON players (player_id);
CREATE INDEX game_rules_index ON game_rules (active_game_code);
CREATE INDEX rules_index ON game_rules (rule_code);
