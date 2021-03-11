<?php

error_reporting(E_ALL);
ini_set("display_errors","On");

//Bring in core include file
include_once '../coreIncludes.php';

// //Create DB conneciton and to Admin
$conn = new DatabaseConn();
include '../SetDBAdmin.php';

//Generate the random code
$newCode = generateGameCode();

echo $newCode;

?>