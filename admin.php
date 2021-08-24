<?php
//print page title and include header and db connection
echo '<title>Admin</title>';
include('templates/header.php');
include('../mysqli_connect.php');

//print page header
print '<h2>Administrator Functions</h2>';

//check if user is logged in and if user is admin
if($_SESSION != [] && $_SESSION['admin']=='Y')
{
    //SQL query
    $query = "SELECT * FROM users";
    $result = mysqli_query($dbc, $query);

    if(!isset($_POST['user']))
    {
        //print form
        print '
        <form action="admin.php" method="POST" class="form--inline">
            <label for="user">Username: </label>
            <select name="user">';

        //dropdown menu of users
        while($users = mysqli_fetch_assoc($result))
        {
            $username = $users['username'];
            print "<option value=\"$username\">$username</option>";
            
        }
        print '
            </select>
            <br><br>
            <input type="submit" value="Submit">
        </form>';
    }
}
else
{
    header('Location: index.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = $_POST['user'];
    print "Username: <b>$username</b>";

    //query and result of updating users table
    $update_query = "SELECT * FROM users WHERE username='$username'";
    $update_result = mysqli_query($dbc, $update_query);

    $user_info = mysqli_fetch_assoc($update_result);

    print '<br>';
    $status = $user_info['status'];
    $admin = $user_info['admin'];

    //prinf form, lots of options
    print '
    <form action="status.php" method="POST">
        <h3>Account Options:</h3>
    ';
    print "<input type=\"hidden\" name=\"username\" value=\"$username\">";
    if($status == 'OPEN')
    {
        print '
        <input type="radio" name="status" value="open" checked>
        <label for="status">Open</label>
        <br>
        <input type="radio" name="status" value="locked">
        <label for="status">Locked</label>
        <br>
        ';
    }
    else
    {
        print '
        <input type="radio" name="status" value="open">
        <label for="status">Open</label>
        <br>
        <input type="radio" name="status" value="locked" checked>
        <label for="status">Locked</label>
        <br>
        ';
    }
    if($admin == 'N')
    {
        print '
        <input type="radio" name="admin" value="grant">
        <label for="admin">Grant Administrator Role</label>
        <br>
        ';
    }
    else
    {
        print '
        <input type="radio" name="admin" value="revoke">
        <label for="admin">Revoke Administrator Role</label>
        <br>
        ';
    }

    print '
    <input type="radio" name="delete" value="delete">
    <label for="delete">Delete This Account</label>
    <br><br>
    <input type="submit" value="Submit Changes">
    </form>
    ';

}

//close database connection 
mysqli_close($dbc);

//include footer
include('templates/footer.php');
?>