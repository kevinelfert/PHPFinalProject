<?php 
//print page title and include header and db connection
echo '<title>Add Quote</title>';
include('templates/header.php');
include('../mysqli_connect.php');

//if user is logged in, print add quote form
if($_SESSION != [])
{
    if($_SESSION['loggedin'] == true)
    {
        print '
        <form action="add_quote.php" method="POST" class="form--inline">
            <p>Author: <input type="text" name="author" required></p>
            <p>Quote Text:</p>
            <textarea name="quote" rows="5" columns="15" required></textarea>
            <div>
                <input type="checkbox" id="favorite" name="favorite" value="yes">
                <label for="favorite">Check to add as a favorite</label>
            </div>
            <input type="submit" name="submit" value="Submit Quote!">
        </form>
        ';
    }
}
//else, redirect to login page
else
{
    header('Location: login.php');
}

//handle post data
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //set up variables for later use
    $author = $_POST['author'];
    $quote = $_POST['quote'];
    $favorite = null;

    //if favorite is set and is yes
    if(isset($_POST['favorite']) && $_POST['favorite'] == 'yes')
    {
        $favorite = 'Y';
    }
    else 
    {
        $favorite = 'N';
    }
    
    //SQL query
    $query = "INSERT INTO quotes (id, text, author, favorite, date_entered) VALUES (0, '$quote', '$author', '$favorite', NOW())";

    //add quote to the quotes table and print message
    if (mysqli_query($dbc, $query)) 
    {
        print '<p class="input--success">The quote has been added!</p>';
    } 
    else 
    {
        print '<p class="input--error">Could not add the quote </p>';
    }

    //close database connection
    mysqli_close($dbc);
}

//include footer
include('templates/footer.php');
?>

