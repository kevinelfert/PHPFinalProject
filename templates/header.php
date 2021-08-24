<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" media="screen" href="css/concise.min.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="css/masthead.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<header container class="siteHeader">
  <div row>
    <h1 column=4 class="logo"><a href="index.php">Welcome to the Fan Club!</a></h1>
    <nav column="8" class="nav">
      <ul>
        <li><a href="books.php">Books</a></li>
        <li><a href="quotes.php">Quotes</a></li>

        <?php 
          //check if user is logged in
          session_start();
          if($_SESSION != [])
          {
            if($_SESSION['loggedin']==true)
            {
              //if user is logged in, print navigation options
              print '<li><a href="stories.php">Stories</a></li>';
              print '<li><a href="upload.php">Upload</a></li>';
              print '<li><a href="email.php">Contact</a></li>';
              //if user is admin, print admin options
              if($_SESSION['admin'] == 'Y')
              {
                print '<li><a href="admin.php">Admin</a></li>';
              }
              print '<li><a href="logout.php">Logout</a></li>';
            }
            
          }
          //else print login and register links
          else 
          {
            print '<li><a href="register.php">Register</a></li>';print '<li><a href="login.php">Login</a></li>';
          }
          
        ?>
     </ul>
    </nav>
  </div>
</header>

  <main container class="siteContent">