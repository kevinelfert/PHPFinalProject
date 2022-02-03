<?php 
//print page title and include header and db connection
echo '<title>Registration Page</title>';
include('templates/header.php');
include('../mysqli_connect.php');
?>

<!-- registration form -->
<h2>Registration Form</h2>
<p>Please register to create your account</p>
<form action="register.php" method="POST" class="form--inline">
    <p>Username: <input type="text" name="username"></p>
    <p>Password: <input type="password" name="password"></p>
    <p>Confirm Password: <input type="password" name="password2"></p>
    <input type="submit" value="Register">
</form>

<?php
//handle form
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{   
    if ( (!empty($_POST['username'])) && (!empty($_POST['password']) &&(!empty($_POST['password2']))) ) 
    {
        //set up variables
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        if ( $password == $password2 )
        {
            //make sure username is not taken
            $verification = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($dbc, $verification);
            $hash_pass = password_hash($password, PASSWORD_DEFAULT);
            if(mysqli_num_rows($result) == 0)
            {
                //add user to table
                $query = "INSERT INTO users (username, password, status, admin) VALUES ('$username', '$password', 'OPEN', 'N')";
                if (mysqli_query($dbc, $query)) 
                {
                    print '<p>The user has been registered!</p>';
                } 
                else 
                {
                    print '<p class="input--error">Could not add the entry </p>';
                }
                
                //close database connection
                mysqli_close($dbc);
            }
            else
            {
                print '<p class="input--error">Username is already taken! Please try again!</p>';
            }
        }
        else 
        {
            print '<p class="input--error">Please make sure your passwords match!</p>';
        }
    }
    else 
    {
        print '<p class="input--error">Please make sure you enter both an email address and a password! Please make sure you confirm your password!<br>Go back and try again.</p>';  
    }
}

//inclide footer
include('templates/footer.php');
?>