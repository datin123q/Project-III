<?php
   date_default_timezone_set('Asia/Ho_Chi_Minh');
   include '../Security/register.php';
   include '../model/db.php';

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/all.css'>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css'>		
<link rel="stylesheet" href="../css/login.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">
	<div class="screen">
		<div class="screen__content">
                <form method='POST' class='login' action='../Security/register.php'>
                <div class='login__field'>
                    <i class='login__icon fas fa-user'></i>
                    <input type='text' class='login__input'name='usn' placeholder='User name / Email' required>
                </div>
                <div class='login__field'>
                    <i class='login__icon fas fa-lock'></i>
                    <input type='password' class='login__input' name='pwd' placeholder='Password' required>
                </div>
                <div class='login__field'>
                    <i class='login__icon fas fa-lock'></i>
                    <input type='password' class='login__input' name='epwd' placeholder='Enter the password' required>
                </div>
                <button class='button login__submit' name='registerSubmit'>
                    <span class='button__text'>Register</span>
                    <i class='button__icon fas fa-chevron-right'></i>
                </button>
                <a class='button login__submit' style="text-decoration: none" href="login.php">
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
