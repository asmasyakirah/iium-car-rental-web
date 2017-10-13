<?php

// Use configured connection to database
require("config.php");

// If posted data is not empty
if (!empty($_POST)) 
{
    //If the username or password is empty when the user submits
    //the form, the page will die.
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['passwordConfirm']) || empty($_POST['firstName']) || empty($_POST['lastName'])) 
    {    
        // Create some data that will be the JSON response 
        $response["success"] = 0;
        $response["message"] = "Please Enter All The Required Fills";
        
        // Create JSON response
        die(json_encode($response));
    }
    
    // Check database to see if username already exist
    $query        = "SELECT 1 FROM users WHERE userID = :user";

    // Update :user. This will increase security and defend against sql injections
    $query_params = array(':user' => $_POST['username']);
    
    //Run the query against database table
    try 
    {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) 
    {
        // Create JSON response
        $response["success"] = 0;
        $response["message"] = "Database Error-1. Please Try Again!";
        die(json_encode($response));
    }
    
    // If fetch data (array of returned data) exist, username already exist
    $row = $stmt->fetch();
    if ($row) 
    {                
        // Create JSON response
        $response["success"] = 0;
        $response["message"] = "Sorry, this username is already in use";
        die(json_encode($response));
    }

    // Check unmatched password
    if (($_POST['password']) != ($_POST['passwordConfirm'])) 
    {    
        // Create JSON response
        $response["success"] = 0;
        $response["message"] = "Password not match!";
        die(json_encode($response));
    }
    
    // Create a user
    $query = "INSERT INTO users (userID, password, firstName, lastName) VALUES (:user, :pass, :fName, :lName) ";
    
    // Update tokens with the actual data
    $query_params = array
    (
        ':user'         => $_POST['username'],
        ':pass'         => $_POST['password'],
        ':fName'        => $_POST['firstName'],
        ':lName'        => $_POST['lastName']
    );
    
    // Run query and create the user
    try 
    {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) 
    {
        
        //o Create JSON response
        $response["success"] = 0;
        $response["message"] = "Database Error-2. Please Try Again!";
        die(json_encode($response));
    }
    
    // Create JSON response
    $response["success"] = 1;
    $response["message"] = "User Successfully Added!";
    echo json_encode($response);
            
} 
else 
{
?>

<!DOCTYPE html>
<html lang="en">

    <head>
    <title>Sign Up | Car Rental IIUM </title>
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
                                <h1>Sign Up</h1>
                                <h2>Ready to start rent!</h2>

                        </center>
                        </div>

                     
                    	<form action="signup.php" method="post">
                        <center>

                        <form class="form-inline" role="form">
                        <div class="form-group">
                          <label for="firstName">Name:</label></br>
                          <div class="col-sm-17">
                    	    <input type="text" name="firstName" placeholder="Fatimah" value="" style="width:300px; height:40px;"/> 
                    	    <br /> 
                        </div>
                        </div>
                             
                            <p><div class="form-group">
                            <label for="lastName"> </label>
                            <div class="col-sm-17">
                            <input type="text" name="lastName" placeholder="Muhammad" value="" style="width:300px; height:40px;"/> 
                            <br /><br /> 
                            </div>
                            </p>

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

                            <div class="form-group">
                            <label for="password">Confirm Your Password</label>
                            <div class="col-sm-17">
                            <input type="password" name="passwordConfirm" maxlength = "8" value="" style="width:300px; height:40px;"/> 
                            <br /><br /> 
                            </div>
                            </br>

                            <div class = "form-actions">
                                <button type = "submit" name = "signup" class = "btn btn-primary">Sign Up</button> <!--create button named "Sign Up" to submit the process-->
                                <a href = "login.php" class = "btn">Already a Member? </a>
                                <button type = "submit" name = "signup"  class = "btn btn-default" href = "welcome.php">Back</button>
                               <!--button for go back to the form-->
                                </div><!--/form-actions-->
                        </center>

                    	  
                    	</form>
</body>

<footer class="container-fluid text-center">
        
       
            <p>     &#169; IIUM CAR RENTAL COPYRIGHT</p>  

    </footer>

                        <!-- Bootstrap JS -->
                        <script type="text/javascript" src = "js/jquery.min.js"></script>
                        <script type="text/javascript" src = "js/bootstrap.min.js"></script>
                        </body>
	<?php
}

?>



</html>
