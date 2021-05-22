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

        //Return the result
        return $result;
    }

    //Returns an array with all active game information
    public function getAllActiveGames(){
        //Set the user to default
        $this->setUser();

        //Select all columns
        $result = $this->conn->selectcolumns(self::T_ACTIVEGAMES, array(
                "*"
            ));

        //Return the result
        return $result;
    }

    //Returns an array with all players linked to a game
    public function getAllPlayersInGames(){
        //Set the user to default
        $this->setUser();

        //Select all columns
        $result = $this->conn->selectcolumns(self::T_GAMEPLAYERS, array(
                "*"
            ));

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
                "player_id"=>$playerID,
                "active_game_code"=>$gameCode
            ));

        //Return the insert ID
        return $insertID;
    }

}