<?php
require_once 'config.php';

// Create a connection
$dbConn = new mysqli($dbHost, $dbUser , $dbPass, $dbName);

// Check connection
if ($dbConn->connect_error) {
    die('Connection failed: ' . $dbConn->connect_error);
}

function dbQuery($sql)
{
    global $dbConn;
    $result = $dbConn->query($sql);
    if (!$result) {
        die('Query failed: ' . $dbConn->error);
    }
    return $result;
}

function dbAffectedRows()
{
    global $dbConn;
    return $dbConn->affected_rows;
}

function dbFetchArray($result, $resultType = MYSQLI_NUM) {
    return $result->fetch_array($resultType);
}

function dbFetchAssoc($result)
{
    return $result->fetch_assoc();
}

function dbFetchRow($result) 
{
    return $result->fetch_row();
}

function dbFreeResult($result)
{
    return $result->free();
}

function dbNumRows($result)
{
    return $result->num_rows;
}

function dbSelect($dbName)
{
    global $dbConn;
    return $dbConn->select_db($dbName);
}

function dbInsertId()
{
    global $dbConn;
    return $dbConn->insert_id;
}

// Close the connection when done
function closeDbConnection() {
    global $dbConn;
    $dbConn->close();
}
?>