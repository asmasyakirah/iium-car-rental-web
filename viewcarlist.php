<?php

// Use configured connection to database
require("config.php");

if (!empty($_POST)) 
{
        //initial query
    $query = "SELECT * FROM cars WHERE ownerID = :user";   
    $query_params = array(':user' => $_POST['username']);

    //execute query
    try 
    {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) 
    {
        $response["success"] = 0;
        $response["message"] = "Database Error!";
        die(json_encode($response));
    }

    // Finally, we can retrieve all of the found rows into an array using fetchAll 
    $rows = $stmt->fetchAll();

    if ($rows) 
    {
        $response["success"] = 1;
        $response["message"] = "Cars Available!";
        $response["cars"]   = array();
        
        foreach ($rows as $row) 
        {
            $post                   = array();
            $post["carID"]          = $row["carID"];
            $post["ownerID"]        = $row["ownerID"];
            $post["carAvailability"]= $row["carAvailability"];
            $post["carModel"]       = $row["carModel"];    
            $post["carBrand"]       = $row["carBrand"];
            $post["carTransmission"]= $row["carTransmission"];
            $post["perHour"]        = $row["perHour"];    
            $post["perHalfDay"]     = $row["perHalfDay"];      
            $post["perDay"]         = $row["perDay"];         
            
            //update our repsonse JSON data
            array_push($response["cars"], $post);
        }
        
        // Create JSON response
        die(json_encode($response));     
    } 
    else 
    {
        $response["success"] = 0;
        $response["message"] = "No Cars Available!";
        die(json_encode($response));
    }
}
?>
