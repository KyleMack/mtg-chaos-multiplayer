<?php

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB conneciton and to Admin
$conn = DatabaseConn();
include '../SetDBAdmin.php';

//Generate the random code
$newCode = generateGameCode();

return $newCode;

?>