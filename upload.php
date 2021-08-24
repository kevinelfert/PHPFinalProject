<?php
//print page title and include header
echo '<title>Upload</title>';
include('templates/header.php');

//if user is not logged in
if ($_SESSION == [])
{
    header('Location: login.php');
}

//handle form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{ 
	//set up variables
	$username = $_SESSION['username'];
	$filename = $_FILES['file']['name'];
	$extension = pathinfo($filename, PATHINFO_EXTENSION);
	//extension checking
	if ($extension == "txt" || $extension == "doc" || $extension == "docx" || $extension == "pdf")
	{
		//upload the file
		if (move_uploaded_file ($_FILES['file']['tmp_name'], "../users/$username/{$_FILES['file']['name']}")) 
		{
	
			print '<p class="input--success">Your file has been uploaded.</p>';
		}
	}
	else 
	{
		print '<p class="input--error">Error: Your file does not have a valid extension</p>';
	}	
}
?>

<!-- upload form -->
<p>Upload a story file. Please note your file must have a file extention of pdf, doc, docx, or txt.</p>
<form action="upload.php" enctype="multipart/form-data" method="POST"  >
    <p><input type="file" name="file" accept=".pdf, .doc, .docx, .txt"></p>
    <input type="submit" value="Upload This File">
</form>

<?php
//include footer
include('templates/footer.php');
?>