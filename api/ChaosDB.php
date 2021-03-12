<?php

include_once '../DatabaseConn.php';
include_once '../SetDBUser.php';

class ChaosDB{

    //Holds the database connection
    private $conn = null;

    //Constants for creating SQL statements
    private const T_PLAYERS     = "players";
    private const T_ACTIVEGAMES = "active_games";
    private const T_GAMEPLAYERS = "game_players";
    private const T_GAMERULES   = "game_rules";

    public __construct(){
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
        $result = $this->conn->selectcolumns($this->T_PLAYERS, array(
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
        $result = $this->conn->selectcolumns($this->T_ACTIVEGAMES, array(
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
        $insertID = $this->conn->insertRecord($this->T_PLAYERS, array(
                "player_id"=>$playerID,
                "username"=>$username
            ));

        //Return the insert ID
        return $insertID;
    }

    //Creates a new record in the games table
    public function saveGame($gameCode, $playerCode, $gameSecret){
        //Set the user to admin
        $this->setAdmin();

        //Determine the game expiry time
        $gameExpiryTime = new DateTime();

        //Call the insert function
        $insertID = $this->conn->insertRecord($this->T_ACTIVEGAMES, array(
                "game_code"=>$gameCode,
                "game_secret"=>$gameSecret,
                "owner_id"=>$playerID,
                "game_expiry_time"=>$gameExpiryTime
            ));

        //Return the insert id and expiry time
        return array("insertID"=>$insertID, "expiryTime"=>$gameExpiryTime);
    }

}