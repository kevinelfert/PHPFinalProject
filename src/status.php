<?php
//print page title and include header and db connection
echo '<title>Status</title>';
include('templates/header.php');
include('../mysqli_connect.php');

//if user is logged in and user is an admin
if($_SESSION != [] && $_SESSION['admin']=='Y')
{
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST['username'];
        //sql query
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($dbc, $query);
        $user = mysqli_fetch_assoc($result);

        $status = $user['status'];

        //if delete option is selected
        if(isset($_POST['delete']))
        {
            $status = 'DELETED';
            //delete user from table
            $delete_query = "DELETE FROM users WHERE username='$username'";
            mysqli_query($dbc, $delete_query);
            //delete users/$username
            $search_dir = "../users/$username/";
            $contents = scandir($search_dir);
            foreach($contents as $filename)
            {
                if(is_file($search_dir . '/' . $filename))
                {
                    unlink($search_dir . '/' . $filename);
                }
            }
            rmdir("../users/$username");
        }
        else
        {
            //if delete is not selected
            if(($_POST['status']) == 'open')
            {
                $status = 'OPEN';
            }
            if(($_POST['status']) == 'locked')
            {
                $status = 'LOCKED';
            }

            $admin = $user['admin'];

            if(isset($_POST['admin']))
            {
                if(($_POST['admin']) == 'grant')
                {
                    $admin = 'Y';
                }
                if(($_POST['admin']) == 'revoke')
                {
                    $admin = 'N';
                }
            }
            //update the user table
            $update_query = "UPDATE users SET status='$status', admin='$admin' WHERE username='$username'";
            mysqli_query($dbc, $update_query);
        }

        //print changes
        print "
        <h2>Account Status</h2>
        <p>The Account $username is now $status<p>
        ";
        //redirect to admin
        header('refresh: 4, admin.php');
    }
}
else
{
    header('Location: index.php');
}

//close databse connection
mysqli_close($dbc);

//include footer
include('templates/footer.php');
?>