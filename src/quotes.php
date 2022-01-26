<?php 
//print page title and include header and db connection
echo '<title>Quotes</title>';
include('templates/header.php');
include('../mysqli_connect.php');

//print header
print "<h1>Quotes</h1>";

//if user is logged in add option to add quote
if($_SESSION != [])
{
    if($_SESSION['loggedin'] == true)
    {
        print '<h2><a href="add_quote.php"><span style="color:blue">Add New Quote</span></a></h2>';
    }
}

//query
$query = "SELECT * FROM quotes";
$result = mysqli_query($dbc, $query);
while($quotes = mysqli_fetch_assoc($result))
{
    //set up variables
    $quote = $quotes['text'];
    $author = $quotes['author'];
    $favorite = $quotes['favorite'];
    $id = $quotes['id'];
    
    //print quotes
    print "
    <pre>
    \"$quote\" ";
    
    if($favorite == 'Y')
    {
        print '<span style="color:red">Favorite!</span>';
    }

    print "
    - $author
    ";
    //if user is logged in add option to edit or delete quote
    if($_SESSION != [])
    {
        if($_SESSION['loggedin']==true)
        {
            print "<a href=\"update_quote.php?id=$id\">Edit</a> <a href=\"delete_quote.php?id=$id\">Delete</a>";
        }
    }
    print "</pre>";
}

//close database connection 
mysqli_close($dbc);

//include footer
include('templates/footer.php');
?>