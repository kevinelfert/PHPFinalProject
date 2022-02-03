<?php 
//print page title and include header
echo '<title>Books</title>';
include('templates/header.php');
include('../mysqli_connect.php');

//if user is logged in
if($_SESSION != [])
{
    if($_SESSION['loggedin']==true)
    {
        //print form
        $user = $_SESSION['username'];
        print '
        <form action="books.php" method="POST" class="form--inline">
            <p>Book Title: <input type="text" name="title" required></p>
            <p>Book Author: <input type="text" name="author" required></p>
            <input type="submit" name="submit" value="Add Book!">
        </form>
        ';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            $book_title = $_POST['title'];
            $book_author = $_POST['author'];

            //add book to db
            $query = "INSERT INTO books (user, book_author, book_title) VALUES ('$user', '$book_author', '$book_title')";
            if (mysqli_query($dbc, $query)) 
            {
                print '<p>The book has been added!</p>';
            } 
            else 
            {
                print '<p class="input--error">Could not add the book </p>';
            }
            
            // //close database connection
            // mysqli_close($dbc);
            
        }

        //print list of my books
        print "
        <h2>My Books</h2>
        <ul>
        ";
        //read from db
        
        $query = "SELECT * FROM books WHERE user='$user'";
        $result = mysqli_query($dbc, $query);
        while($books = mysqli_fetch_assoc($result))
        {
            //set up variables
            $author = $books['book_author'];
            $title = $books['book_title'];
            
            //print quotes
            print "<li>$title by $author</li>";
        }
        print "</ul>";

        mysqli_close($dbc);
    }
}
else
{
    //if user is not logged in, print generic list
    print "
    <h2>Example Books</h2>
    <ul>
        <li>Assembly Language for x86 Processors by Kip Irvine</li>
        <li>Java How to Program by Paul and Harvey Deitel</li>
        <li>The Rust Programming Language by Steve Klabnik and Carol Nichols</li>
    </ul>
    ";
}

//include footer
include('templates/footer.php');
?>