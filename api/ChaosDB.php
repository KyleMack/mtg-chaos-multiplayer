<?php

include_once '../DatabaseConn.php';
include_once '../SetDBUser.php';

class ChaosDB{

    //Holds the database connection
    private $conn = null;

    //Constants for creating SQL statements
    const T_PLAYERS     = "players";
    const T_ACTIVEGAMES = "active_games";
    const T_GAMEPLAYERS = "game_players";
    const T_GAMERULES   = "game_rules";

    public function __construct(){
        $this->loadDatabase();
    }

    //Gets an instance of the database
    public function loadDatabase(){
        if($this->conn === null){
            $this->conn = New DatabaseConn();
        }
    }

    //Sets the access to either standard user or admin
    public function setUser(){ setDBUser($this->conn); }
    public function setAdmin(){ setDBAdmin($this->conn); }

    //Returns an array with all player information
    public function getAllPlayers(){
        //Set the user to default
        $this->setUser();

        //Select all columns
        $result = $this->conn->selectcolumns(self::T_PLAYERS, array(
                "*"
            ));

        $output = [];

        foreach ($result as $record){
            $player = []; 
            array_push($player, $record["player_id"], $record["username"]);
            array_push($output, $player);
        }

        //Return the result
        return $output;
    }

    //Returns an array with all active game information
    public function getAllActiveGames(){
        //Set the user to default
        $this->setUser();

        //Select all columns
        $result = $this->conn->selectcolumns(self::T_ACTIVEGAMES, array(
                "*"
            ));

        $output = [];

        foreach ($result as $record){
            $game = []; 
            array_push($game, $record["game_code"], $record["owner_id"]);
            array_push($output, $game);
        }

        //Return the result
        return $output;

    }

    //Returns an array with all players linked to a game
    public function getAllPlayersInGames(){
        //Set the user to default
        $this->setUser();

        //Select all columns
        $result = $this->conn->selectcolumns(self::T_GAMEPLAYERS, array(
                "*"
            ));

            
        $output = [];

        foreach ($result as $record){
            $gameList = []; 
            array_push($gameList, $record["player_id"], $record["active_game_code"]);
            array_push($output, $gameList);
        }

        //Return the result
        return $output;

        //Return the result
        return $result;
    }

    //Saves the given player in the database
    public function savePlayer($playerID, $username){
        //Set the user to admin
        $this->setAdmin();

        //Call the insert function
        $insertID = $this->conn->insertRecord(self::T_PLAYERS, array(
                "player_id"=>$playerID,
                "username"=>$username
            ));

        //Return the insert ID
        return $insertID;
    }

    //Creates a new record in the games table
    public function saveGame($gameCode, $playerCode){
        //Set the user to admin
        $this->setAdmin();

        //Determine the game expiry time
        $gameExpiryTime = (new DateTime())->format('Y-m-d H:i:s');

        //Call the insert function
        $insertID = $this->conn->insertRecord(self::T_ACTIVEGAMES, array(
                "game_code"=>$gameCode,
                "owner_id"=>$playerCode,
                "game_expiry_time"=>$gameExpiryTime
            ));

        //Return the insert id and expiry time
        return array("insertID"=>$insertID, "expiryTime"=>$gameExpiryTime);
    }

    //Creates a new record in the game_players table
    public function addPlayerToGame($gameCode, $playerCode){
        //Set the user to admin
        $this->setAdmin();

        //Call the insert function
        $insertID = $this->conn->insertRecord(self::T_GAMEPLAYERS, array(
                "player_id"=>$playerCode,
                "active_game_code"=>$gameCode
            ));

        //Return the insert ID
        return $insertID;
    }

    //Returns true if the passed game code is active in the database
    public function checkGameExists($gameCode){
        //Set the user to guest
        $this->setUser();

        //Select from the database using the room code
        $exists = $this->conn->recordExists(self::T_ACTIVEGAMES, "game_code", $gameCode);

        return $exists;
    }

    //Returns the name of all players in the passed game
    public function getPlayersInGame($gameCode){
        if( empty($gameCode) ){
            return array();
        }

        $this->setUser();

        //Create the query string for the select
        $queryString = "SELECT p.username FROM game_players gp INNER JOIN players p ON gp.player_id=p.player_id WHERE gp.active_game_code='$gameCode'";

        $results = $this->conn->queryRaw($queryString);

        return $results;

    }

}