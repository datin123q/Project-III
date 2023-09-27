
<?php
session_start();
include_once("../model/db.php");

//Khai báo utf-8 để hiển thị được tiếng việt
header('Content-Type: text/html; charset=UTF-8');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
function alert2($msg) {
    echo "<script type='text/javascript'>
    window.location='../view/register.php';
    alert('$msg');
    </script>";
}
function emailValid($email)
{
    return (bool)preg_match ("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+\.[A-Za-z]{2,6}$/", $email);
}
if (isset($_POST["registerSubmit"]))
{
    $conn = mysqli_connect("localhost", "root", "", "commentsection");
    $name = "Học sinh";
    $email = $_POST["usn"];
    $password = $_POST["pwd"];
    $epassword = $_POST["epwd"];
    if(!emailValid($email)){
        alert2("Tài khoản phải là email!");
    }
    if(strlen($password)<6){
        alert2("Vui lòng nhập mật khẩu trên 6 ký tự");
    }
    if ($epassword!= $password) {
        alert2("Mật khẩu không chính xác");
        exit;
    }
    $sql = "SELECT * FROM user WHERE usn = '" . $email . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) != 0)
    {
        alert2("Tài khoản đã tồn tại");
        exit;
    }
    //Instantiation and passing `true` enables exceptions
    else{
    $mail = new PHPMailer(true);

    try {
        //Enable verbose debug output
        $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;

        //Send using SMTP
        $mail->isSMTP();

        //Set the SMTP server to send through
        $mail->Host = 'smtp.gmail.com';

        //Enable SMTP authentication
        $mail->SMTPAuth = true;

        //SMTP username
        $mail->Username = 'indat0001@gmail.com';

        //SMTP password
        $mail->Password = 'otdbqtnowdkcrhpt';

        //Enable TLS encryption;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('indat0001@gmail.com', 'ProjectIII');

        //Add a recipient
        $mail->addAddress($email, $name);

        //Set email format to HTML
        $mail->isHTML(true);

        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        $mail->Subject = 'Email verification';
        $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

        $mail->send();
        // echo 'Message has been sent';

        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

        // connect with database

        // insert in users table
        $sql2 = "INSERT INTO user(name, usn, pwd, verification_code, mail, email_verified_at, role) VALUES ('" . $name . "', '" . $email . "', '" . $encrypted_password . "', '" . $verification_code . "','".$password."', NULL, 0)";
        mysqli_query($conn, $sql2);

        header("Location: email-verification.php?email=" . $email);
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
}
?>