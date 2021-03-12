<?php

function setDBUser($conn){
    $conn->setUser('chaos_user', '*PASSWORD*');
}

function setDBAdmin($conn){
    $conn->setUser('chaos_admin', '*PASSWORD*');
}

