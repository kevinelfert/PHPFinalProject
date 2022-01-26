<?php
//print page title and include header, config, and php mailer
echo '<title>Contact Me</title>';
include('templates/header.php');
include '../config.php';
require 'phpmailer/PHPMailerAutoload.php';

//check if user is logged in
if($_SESSION != [])
{
    if($_SESSION['loggedin']==false)
    {
        print "User Must Be Logged In";
    }
    else 
    {
        //email form
        print '<h2>Send Me an Email!</h2>
        <form method="POST" action="email.php" class="form--inline">
            <p>Email Address: <input type="email" name="email" required></p>
            <p>Subject: <input type="text" name="subject" required></p>
            <p>Message: <textarea name="message" id="message" rows="5" required></textarea></p>
        
            <input type="submit" name="submit" value="Submit">
        </form>';

        //handle email form
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //set up variables for later use
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            //set up php mailer and send email
            $mail = new PHPMailer;                            
            $mail->isSMTP(); 
            $mail->SMTPAuth = true;
            $mail->Host = $host;                              
            $mail->Username = $username;              
            $mail->Password = $password;
            $mail->Sender = $email;
            $mail->SMTPSecure = $SMTPsecure;                       
            $mail->Port = $port;                                 
            $mail->addAddress($username); 

            $mail->FromName = $email;            
            $mail->Subject = $subject;              
            $mail->Body = $message;          
            
            //print errors if any
            if(!$mail->send()) 
            {
                print '<h3 class="input--error">ERROR! Unable to send Email<h3>';
            } 
            else 
            {
                print '<h3 class="input--success">Email Sent Successfully</h3>';
            } 
        }
    }
}
else
{
    header('Location: login.php');
}

//include footer
include('templates/footer.php');
?>