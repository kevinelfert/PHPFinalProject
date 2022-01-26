<?php 
//print page title and include header and db connection
echo '<title>Update Quote</title>';
include('templates/header.php');
include('../mysqli_connect.php');

//declare id
$id = null;

//initialize id
if(isset($_GET['id']))
{
    $id = $_GET['id'];
}

//if user is logged in
if($_SESSION != [])
{
    if($_SESSION['loggedin']==true)
    {
        if($id != null)
        {
            //sql query for updating quote
            $update_query = "SELECT * FROM quotes WHERE id='$id'";
            $result = mysqli_query($dbc, $update_query);
            $quote_to_update = mysqli_fetch_array($result, MYSQLI_ASSOC);
            //set up variables from result
            $author = $quote_to_update['author'];
            $text = $quote_to_update['text'];
            $favorite = $quote_to_update['favorite'];
            $date = $quote_to_update['date_entered'];

            //print form
            print '
            <form action="update_quote.php" method="POST" class="form--inline">';
            print "
                <input type=\"hidden\" name=\"id\" value=\"$id\">
                <input type=\"hidden\" name=\"date\" value=\"$date\">
                <p>Author: <input type=\"text\" name=\"author\" value=\"$author\" required></p>
                <p>Quote Text:</p>
                <textarea name=\"quote\" rows=\"5\" columns=\"15\" required>$text</textarea>
            ";
            print '
                <div>';
                if($favorite=='Y')
                {
                    print '<input type="checkbox" id="favorite" name="favorite" value="yes" checked>';
                }
                else
                {
                    print '<input type="checkbox" id="favorite" name="favorite" value="yes">';
                }
                    
                print '
                    <label for="favorite">Check to add as a favorite</label>
                </div>
                <input type="submit" name="submit" value="Update Quote!">
            </form>
            ';
        }
    }
}
else
{
    header('Location: login.php');
}

//handle form
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //set up variables
    $author = $_POST['author'];
    $quote = $_POST['quote'];
    $update_id = $_POST['id'];
    $date = $_POST['date'];
    if(isset($_POST['favorite']) && $_POST['favorite']=='yes')
    {
        $favorite = 'Y';
    }
    else 
    {
        $favorite = 'N';
    }

    //query for updating
    $query = "UPDATE quotes SET id='$update_id', text='$quote', author='$author', favorite='$favorite', date_entered='$date' WHERE id='$update_id'";
    if (mysqli_query($dbc, $query)) 
    {
        print '<p class="input--success">The quote has been updated!</p>';
        //redirect to quotes
        header('refresh: 4, quotes.php');
    } 
    else 
    {
        print '<p class="input--error">Could not update the quote </p>';
    }
}

//close databse connection 
mysqli_close($dbc);

//include footer
include('templates/footer.php');
?>