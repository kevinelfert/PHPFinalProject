<?php
//print page title and include header
echo '<title>Stories</title>';
include('templates/header.php');

//set timezone
date_default_timezone_set('America/Chicago');

//if user is not logged in
if ($_SESSION == [])
{
    header('Location: login.php');
}

//set up variables
$username = $_SESSION['username'];
$search_dir = "../users/$username/";
$contents = scandir($search_dir);

//print table
print "
<h1>Stories Uploaded</h1>
<table>
    <tr>
        <th>Name</th>
        <th>Last Modified</th>
    </tr>
";

//loop through directory
foreach($contents as $item)
{
    if ( (is_file($search_dir . '/' . $item)) AND ((substr($item, 0, 1) != '.') AND ($item!="books.csv")) )
    {
        $last_mod = date('m/d/Y g:i:sa', filemtime($search_dir . '/' . $item));
        //add table row
        print "
        <tr>
            <td>$item</td>
            <td>$last_mod</td>
        </tr>
        ";
    } 
}
print "</table>";

//include footer
include('templates/footer.php');
?>