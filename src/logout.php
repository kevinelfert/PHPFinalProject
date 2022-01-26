<?php 
//print page title and include header
echo '<title>Logout Page</title>';
include('templates/header.php');

//if user is logged in
if($_SESSION['loggedin']==true)
{
    //set session variables to logged out
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = null;
}

//destry session
session_destroy();

//redirect to index
header('Location: index.php');

//include footer
include('templates/footer.php');
?>