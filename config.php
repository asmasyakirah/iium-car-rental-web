<?php 

    // These variables define the connection information for MySQL database 
    $username = "root"; 
    $password = ""; 
    $host = "localhost"; 
    $dbname = "iiumcarrental"; 

    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    try 
    { 
        // Opens a connection to database using the PDO library 
        $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 
    } 
    catch(PDOException $ex) 
    { 
        // If an error occurs while opening a connection to database, it will be trapped here.
        die("Failed to connect to the database: " . $ex->getMessage()); 
    } 
     
    // This statement configures PDO to throw an exception when it encounters error.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     
    // This statement configures PDO to return database rows from database using an associative array.
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     
    // This block of code is used to undo magic quotes.
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 
     
    // This tells the web browser that the content is encoded using UTF-8 and should submit content back using UTF-8 
    header('Content-Type: text/html; charset=utf-8'); 
     
    session_start(); 
?>