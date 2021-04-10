<?php

/**
 * make a database connection
 */

$host ='localhost';
$user ='root';
$pass ='';
$db ='eshop';

/**
 * Create DB Connection with Function
 */

function connect(){

global $host, $user, $pass, $db;
return $connection = new mysqli($host, $user, $pass, $db);

};



?>