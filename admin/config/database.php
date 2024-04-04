<?php
require 'constants.php';

// connect to the database==conexao de banco de dados
$connectiion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if(mysqli_errno($connectiion)) {
    die(mysqli_error($connectiion));
}