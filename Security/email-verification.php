<?php
session_start();
if (isset($_GET['email'])){
$_SESSION['verify_email'] = $_GET['email'];}
if (isset($_POST["verify_email"]))
{
    $email = $_POST["email"];
    $verification_code = $_POST["verification_code"];
    // connect with database
    $conn = mysqli_connect("localhost", "root", "", "commentsection");

    // mark email as verified
    $sql = "UPDATE user SET email_verified_at = NOW() WHERE usn = '" . $email . "' AND verification_code = '" . $verification_code . "'";
    $result  = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) == 0)
    {
        echo "<script type='text/javascript'>
        window.location='email-verification.php';
        alert('Verification code failed');
        </script>";
    }

    else {
        echo "<script type='text/javascript'>
        window.location='../view/login.php';
        alert('Verification code success');
        </script>";
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/all.css'>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css'>		
<link rel="stylesheet" href="../css/login.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">
	<div class="screen">
		<div class="screen__content">
                <form method='POST' class='login'>
                <input type="hidden" name="email" value="<?php echo $_SESSION['verify_email']; ?>" >
                <div class='login__field'>
                    <input type='text' class='login__input'name='verification_code' placeholder='Enter verification code' required>
                </div>

                <button class='button login__submit' name='verify_email'>
                    <span class='button__text'>Verify Now</span>
                    <i class='button__icon fas fa-chevron-right'></i>
                </button>
                <a class='button login__submit' style="text-decoration: none" href="../view/login.php">
                    <span class='button__text'>Login</span>
                    <i class='button__icon fas fa-chevron-right'></i>
                </a>
                </form>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
<!-- partial -->
  
</body>
</html>