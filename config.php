<?php


$driver = "mysql";
$config = http_build_query(data: [
    "host" => "localhost",
    "port" => 3306,
    "dbname" => "ville_de_france"
], arg_separator: ";");

$dsn = "{$driver}:{$config}";
$username = "antoine";
$password = "";

// Tableau associatif que je passe à ma classe
define("CONFIG", ["dsn" => $dsn, "user" => $username, "password" => $password]);
