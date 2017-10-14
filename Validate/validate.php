<?php
//put smtp email code below
require '../PHPMail/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);
$mail->isSMTP(); // Set mailer to use SMTP
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
//ADD YOUR EMAIL ADDRESS
$mail->Username = '@gmail.com'; // SMTP username is your gmail address
//ADD YOUR EMAIL PASSWORD
$mail->Password = ""; // SMTP password is your gmail password
$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587; // TCP port to connect to
session_start();
/* Check all form inputs using check_input function */
//ADD YOUR EMAIL PASSWORD
$yourname = check_input($_POST['yourname'], "YOUR FULL NAME");
//SUBJECT WEEK 8 IF FIELD LEFT EMPTY
$subject  = check_input($_POST['subject'], 'Week 8');
$email    = check_input($_POST['email']);
$website  = check_input($_POST['website']);
$likeit   = check_input($_POST['likeit']);
$how_find = check_input($_POST['how']);
$comments = check_input($_POST['comments'], "Enter comments");
$color = check_input($_POST['colors'], "Enter Favorite Color");

/* If e-mail is not valid show error message */
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
{
   show_error("E-mail address not valid");
}

/* If URL is not valid set $website to empty */
if (!preg_match("/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i", $website))
{
   $website = '';
}

$message = "Hello!<br><br>

Your contact form has been submitted by:<br>

Name: $yourname<br>
E-mail: $email<br>
URL: $website<br>
<br>
Like the website? $likeit<br>
How did he/she find it? $how_find<br>
<br>
Comments:<br>
$comments<br>
";

// Change to YOUR EMAIL ADDRESS
$mail->SetFrom('ckonkol@gmail.com', 'Chuck Konkol');
//Body of Email
$body = $message;
//Subject of Email
$mail->Subject = $subject;
//Alternate Body
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
//Convert to HTML body
$mail->MsgHTML($body);
$mail->isHTML(true);  // Set email format to HTML
 //to field
$mail->AddAddress($email,$yourname);
//Send Email
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
/* Redirect visitor to the thank you page */
header('Location: thanks.html');
exit();
}
# $errors["email"]="Email Address is not valid";

/* Functions we used */
function check_input($data, $problem='')
{
	$name = $data;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}

function show_error($myError)
{
?>
    <html>
    <body>

    <b>Please correct the following error:</b><br />
    <?php echo $myError; ?>

    </body>
    </html>
<?php
exit();
}
?>