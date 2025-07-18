<?php

declare(strict_types=1);

define("HOST", "127.0.0.1");
define("DB_NAME", "chatbot");
define("DB_USER", "Mosalem");
define("PASS", "Mosalem 2003");

$host = HOST;
$db_name = DB_NAME;

$dsn = "mysql:host=$host;dbname=$db_name";

try {
	$con = new PDO($dsn, DB_USER, PASS);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	throw new PDOException($e->getMessage());
}
