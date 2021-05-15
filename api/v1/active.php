<<<<<<< HEAD
<?php

error_reporting(E_ALL);
ini_set("display_errors","On");

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();

//Select all active games
$players = $conn->getAllPlayers();

//return the games as JSON
echo "Active Players:<br/>";
=======
<?php

error_reporting(E_ALL);
ini_set("display_errors","On");

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();

//Select all active games
$players = $conn->getAllPlayers();

//return the games as JSON
echo "Active Players:<br/>";
>>>>>>> 113741d9a0044950da30038d06b2e374fd536555
echo json_encode($players);