<?php

// Connect to MySQL database 
require("config.php");

if (!empty($_POST)) 
{
    // Get user info from username
    $query = " SELECT userID, password FROM users WHERE userID = :user";     
    $query_params = array(':user' => $_POST['username']);
    
    try 
    {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) 
    {
        // Create JSON response
        $response["success"] = 0;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
        
    }
    
    // Determine whether or not the user's information is correct, initially set to false
    $validated_info = false;
    
    // Fetch all rows from the query
    $row = $stmt->fetch();
    if ($row) 
    {
        // Check password
        if ($_POST['password'] === $row['password']) 
        {
            $login_ok = true;
        }
    }
    
    // If user logged in successfully, direct to home
    // Otherwise, display a login failed message and show the login form again 
    if ($login_ok) 
    {
        $response["success"] = 1;
        $response["message"] = "Login successful!";
        die(json_encode($response));
        
    } 
    else 
    {
        $response["success"] = 0;
        $response["message"] = "Invalid Credentials!";
        die(json_encode($response));
    }
} 
else 
{
?>

<!DOCTYPE html>
<html lang="en">

    <head>
    <title>Log In | Car Rental IIUM </title>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    </head>

<style>

    /* Add a orange background color and some padding to the footer */
    footer 
    {
      background-color: #ff9900;
      padding: 25px;
    }

  </style>


  <body>


                        <div class="jumbotron">
                        <center>
                                <h1>Login</h1>
                                <h2>Welcome back!</h2>

                        </center>
                        </div>

                     
                        <form action="login.php" method="post">
                        <center>

                           <div class="form-group">
                            <label for="username">Mobile Number:</label>
                            <div class="col-sm-17">
                            <input type="text" name="username" placeholder="0123456789" value="" style="width:300px; height:40px;"/> 
                            <br /><br /> 
                            </div>

                            <div class="form-group">
                            <label for="password">Password:</label>
                            <div class="col-sm-17">
                            <input type="password" name="password" placeholder="Use maximum 8 characters" maxlength="8" value=""style="width:300px; height:40px;"/> 
                            <br /><br /> 
                            </div>

                             <div class = "form-actions">
                                <button type = "submit" name = "signup" class = "btn btn-success" a href = "main.php" >Login</button> <!--create button named "Sign Up" to submit the process-->
                                <a href = "welcome.php" class = "btn">Back</a> <!--button for go back to the form-->
                                </div><!--/form-actions-->
                                </br>


		</form> 

        </body>

                <footer class="container-fluid text-center">
                    <p>     &#169; IIUM CAR RENTAL COPYRIGHT</p>  
                </footer>
	<?php
}

?> 
