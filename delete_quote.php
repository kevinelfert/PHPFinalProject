<?php 
//print page title and include header and db connection
echo '<title>Delete Quote</title>';
include('templates/header.php');
include('../mysqli_connect.php');

//declare id
$id = null;

//initialize id
if(isset($_GET['id']))
{
    $id = $_GET['id'];
}

//check if user is logged in
if($_SESSION != [])
{
    if($_SESSION['loggedin']==true)
    {
        if($id != null)
        {
            //print delete form
            print '
            <form action="delete_quote.php" method="POST">
                <p>Are you sure you want to delete this quote?</p>';

            //SQL query
            $query = "SELECT * FROM quotes WHERE id='$id'";
            //get query result and set it to associative array
            $result = mysqli_query($dbc, $query);
            $quote_to_delete = mysqli_fetch_array($result, MYSQLI_ASSOC);
            //set up variables
            $quote = $quote_to_delete['text'];
            $author = $quote_to_delete['author'];
        
            //finish printing form
            print "
            <pre>
            \"$quote\"
            - $author
            </pre>";
            print   "<input type=\"hidden\" name=\"id\" value=\"$id\">";
            print '
            <input type="submit" name="submit" value="Delete this Entry!">
            </form>
            ';
        }
    }
}
else
{
    header('Location: login.php');
}

//handle delete form
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //initialize id var
    $delete_id = $_POST['id'];

    //SQL query to delete quote
    $delete_query = "DELETE FROM quotes WHERE id='$delete_id'";

    //print message
    if (mysqli_query($dbc, $delete_query)) 
    {
        print '<p class="input--success">The quote has been deleted!</p>';
        //redirect to quotes
        header('refresh: 4, quotes.php');
    } 
    else 
    {
        print '<p class="input--error">Could not delete the quote </p>';
    }
}

//close databse connection
mysqli_close($dbc);

//include footer
include('templates/footer.php');
?>