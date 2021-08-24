<?php 
//print page title and include header and db connection
echo '<title>Login Page</title>';
include('templates/header.php');
include('../mysqli_connect.php');

?>
<!-- Login Form -->
<h2>Login Form</h2>
<p>Please login to access certain features</p>
<form action="login.php" method="POST" class="form--inline">
    <p>Username: <input type="text" name="username"></p>
    <p>Password: <input type="password" name="password"></p>
    <input type="submit" value="Login">
</form>

<?php 
//handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{   
    //both fields must be entered
    if ( (!empty($_POST['username'])) && (!empty($_POST['password'])) ) 
    {
        //set up variables for later use
        $username = $_POST['username'];
        $password = $_POST['password'];
        //SQL query to verify user
        $verification = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($dbc, $verification);

        //if the user exists
        if(mysqli_num_rows($result) == 1)
        {
            //set up variables
            $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $username_verif = $data['username'];
            $password_verif = $data['password'];
            $status = $data['status'];
            $admin = $data['admin'];

            //verify the username
            if($username == $username_verif)
            {
                //check the password
                if($password == $password_verif)
                {
                    //if account status is OPEN
                    if($status == 'OPEN')
                    {
                        //add elements to session variable
                        $_SESSION['username'] = $username;
                        $_SESSION['loggedin'] = true;
                        $_SESSION['admin'] = $admin;
                        //redirect to index
                        header('Location: index.php');
                    }
                    else 
                    {
                        print '<p class="input--error">This user account is locked. Contact the admin to unlock it.</p>';
                    }
                    
                }
                else
                {
                    print '<p class="input--error">Your password is incorrect!</p>';
                }
            }  
        }
        else
        {
            print '<p class="input--error">The submitted username does not match any on file!</p>';
        }

        //close database connection
        mysqli_close($dbc);
    }
    else 
    {    
        print '<p class="input--error">Please make sure you enter both an email address and a password!<br>Go back and try again.</p>';   
    }
}

//include footer
include('templates/footer.php');
?>