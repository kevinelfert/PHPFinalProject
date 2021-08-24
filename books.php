<?php 
//print page title and include header
echo '<title>Books</title>';
include('templates/header.php');

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
            //write book to file using append
            $file_to_write = fopen("../users/$user/books.csv", "a");

            $book = array();
            $book['title'] = $_POST['title'];
            $book['author'] = $_POST['author'];

            //demilit with "|"
            fputcsv($file_to_write, $book, '|');
        }

        //print list of my books
        print "
        <h2>My Books</h2>
        <ul>
        ";
        //read from file
        $file_to_read = fopen("../users/$user/books.csv", "r");
        while (!feof($file_to_read))
        {
            $get_book = fgets($file_to_read);
            $book_array = explode("|", $get_book);
            if($book_array[0]!="" && $book_array[1]!="")
            {
                //remove quotations
                $title = str_replace('"', "", $book_array[0]);
                $author = str_replace('"', "", $book_array[1]);
                print "<li>$title by $author</li>";
            }
        }
        print "</ul>";
    }
}
else
{
    //if user is not logged in, print generic list
    print "
    <h2>Example Books</h2>
    <ul>
        <li>The Catcher in the Rye</li>
        <li>Nine Stories</li>
        <li>Franny and Zooey</li>
        <li>Raise High the Roof Beam, Carpenters and Seymour: An Introduction</li>
    </ul>
    ";
}

//include footer
include('templates/footer.php');
?>