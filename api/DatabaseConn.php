<?php

/**
 * Class DatabaseConn
 *
 * Class that is used to access the database. All querys should be run through this
 * class, with no PDO objects being created outside of this object.
 */
class DatabaseConn{

    const DEBUGGING     = true;
    private $address    = "localhost";
    private $database   = "chaos_db";
    private $username;
    private $password;

    /**
     * DatabaseConn constructor.
     */
    function __construct(){
    }

    /**
     * @param $property
     * @return null
     */
    public function __get($property){
        if(property_exists($this, $property)){
            return $this->$property;
        }
        return null;
    }

    /**
     * @param $property
     * @param $value
     */
    public function __set($property, $value){
        if(property_exists($this, $property)){
            $this->$property = $value;
        }
    }

    //Sets the user credentials and password
    public function setUser($username = null, $password = null){
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Gets the default user connection for accessing the database
     *
     * @return null|PDO Returns null if unable to create the connection
     */
    private function getUserConnection(){

        $dsn = "pgsql:host=" . $this->address . ";dbname=" . $this->database;
        
        try{
            $conn = new PDO($dsn, $this->username, $this->password);
        } catch(PDOException $e){
            $conn = null;
        }

        return $conn;
    }

    /**
     * Creates a table in the database
     *
     * @param string $tableName The name of the table to create
     * @param array $tableColumns An array of strings containing the name of each column
     * @return int Return 0 if the command was executed properly
     */
    function createTable($tableName, $tableColumns){

        // Get the connection
        $conn = $this->getAdminConnection();

        // Create the query string
        $createTableSQL = "CREATE TABLE $tableName ($tableColumns)";

        // Execute the query
        $executed = $conn->exec($createTableSQL);

        // Close the connection and return the result
        $conn = null;
        return $executed;
    }

    /**
     * Drops a table in the database with the given name
     *
     * @param string $tableName The name of the table to drop
     * @return int Returns 0 if the command was executed properly
     */
    function dropTable($tableName){

        // Get the connection
        $conn = $this->getAdminConnection();

        // Create the query string
        $DROP_TABLE_SQL = "DROP TABLE IF EXISTS $tableName";

        // Execute the query
        $executed = $conn->exec($DROP_TABLE_SQL);

        // Close the connection and return the result
        $conn = null;
        return $executed;

    }

    /**
     * Inserts a new record into the database
     *
     * @param string $tableName The name of the table to insert the record into
     * @param array $values Associative array, where each key is the column name and each value is the column value
     * @return string Returns the id of the inserted row, if auto increment
     */
    function insertRecord($tableName, $values){

        // Get the limited connection
        $conn = $this->getUserConnection();

        // Get the keys to be used as the values
        $stmtKeys = array_keys($values);
        $stmtValues = array_values($values);
        $stmtBindings = array();
        $keyString = "";
        $valueString = "";

        // For each key in the list
        for($i = 0; $i < count($stmtKeys); $i++){
            // Add the key to the string
            $keyString .= $stmtKeys[$i];

            // Add a comma
            if($i !== count($stmtKeys)-1)
                $keyString .= ", ";

        }
        // For each value in the list
        for($i = 0; $i < count($stmtValues); $i++){
            $valueString .= ":".$stmtKeys[$i];
            if($i !== count($stmtKeys)-1)
                $valueString .= ", ";

            // Add to the bindings array
            $stmtBindings[ ":".$stmtKeys[$i] ] = $values[$stmtKeys[$i]];
        }

        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO $tableName ($keyString) VALUES ($valueString)");

        // Execute the statement
        $stmt->execute($stmtBindings);

        return $conn->lastInsertId();

    }

    /**
     * Check if a record exists in the database
     *
     * @param string $tableName The name of the table
     * @param string $column The column to perform the check on
     * @param array $value The value to look for in the column
     * @return bool Returns true if at least one the record is found
     */
    function recordExists($tableName, $column, $value){

        // Get the connection
        $conn = $this->getUserConnection();

        // Prepare the query
        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE $column='$value'");

        // Execute the query
        $stmt->execute();

        // Get the results
        $results = $stmt->fetchAll();

        if(!result){
            return false;
        } else {
            return true;
        }

    }

    /**
     * Selects records using a where condition
     *
     * @param string $table The name of the table
     * @param array $columns An array of columns to select. Use array("*") to select all
     * @param string $condition A where conditional used for filtering
     * @return array Returns an array using the fetchAll() method
     */
    function selectWithWhere($table, $columns, $condition){

        // Get the connection
        $conn = $this->getUserConnection();

        // Get the columns that will be selected
        $selectColumns = "";
        for($i = 0; $i < count($columns); $i++){
            $selectColumns .= $columns[$i];

            if($i !== count($columns)-1)
                $selectColumns .= ",";
        }

        // Prepare the statement
        $stmt = $conn->prepare("SELECT $selectColumns FROM $table WHERE $condition");

        // execute the statement
        $stmt->execute();

        // Returns the results
        return $stmt->fetchAll();

    }

    /**
     * Selects the specified columns from all rows in the database
     *
     * @param string $table The table name to select from
     * @param array $columns Array of strings representing the column names
     * @return bool|PDOStatement Returns the PDO statement
     */
    function selectColumns($table, $columns){

        // Get the connection
        $conn = $this->getUserConnection();

        // Get the columns that will be selected
        $selectColumns = "";
        for($i = 0; $i < count($columns); $i++){
            $selectColumns .= $columns[$i];

            if($i !== count($columns)-1)
                $selectColumns .= ",";
        }

        // Prepare the statement
        $stmt = $conn->prepare("SELECT $selectColumns FROM $table");

        // execute the statement
        $stmt->execute();

        // Returns the results
        return $stmt->fetchAll();
    }

    /**
     * Performs a raw query against the database
     *
     * @param string $queryString A SQL query that will be executed against the database
     * @return array The results of the fetchAll() method
     */
    function queryRaw($queryString){

        // Get the connection
        $conn = $this->getUserConnection();

        // Prepare the statement
        $stmt = $conn->prepare($queryString);

        // Execute and fetch the statement
        $stmt->execute();
        $results = $stmt->fetchAll();

        $conn = null;
        $stmt = null;
        return $results;
    }

    /**
     * Updates all rows in the table using the where condition
     *
     * @param string $tableName Table name to run the query against
     * @param array $values Associative array where the key is the column name and value is the new value
     * @param string $where Where clause that will be used to filter the update
     * @return bool Returns true if one or more rows were affected
     */
    function updateRowsWhere($tableName, $values, $where){

        // Get the limited connection
        $conn = $this->getUserConnection();

        // String that will be used for the binding
        $stmtKeys = array_keys($values);
        $bindingString = "";
        $bindingArray = array();

        // For each binding
        for($i = 0; $i < count($values); $i++){

            // Add the current row to the script
            $bindingString .= $stmtKeys[$i] . "=:" . $stmtKeys[$i];

            // Add the binding to the array
            $bindingArray[":" . $stmtKeys[$i]] = $values[$stmtKeys[$i]];

            // Add a comma
            if($i !== count($stmtKeys)-1)
                $bindingString .= ", ";
        }

        // Prepare the statement
        $stmt = $conn->prepare("UPDATE $tableName SET $bindingString WHERE $where");
        $stmt->execute($bindingArray);

        $rowCount = $stmt->rowCount();
        $stmt = null;

        return $rowCount;

    }

    function log($message){
        if(self::DEBUGGING){
            echo "log: $message</>";
        }
    }


}// end class DatabaseConn

?>