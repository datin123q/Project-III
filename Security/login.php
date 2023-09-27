
<?php

//Khai báo sử dụng session
session_start();

include_once("../model/db.php");

//Khai báo utf-8 để hiển thị được tiếng việt
header('Content-Type: text/html; charset=UTF-8');
function alert($msg) {
    echo "<script type='text/javascript'>
    window.location='../view/login.php';
    alert('$msg');
    </script>";
}
//Xử lý đăng nhập
if (isset($_POST['loginSubmit'])) 
{
    

    //Lấy dữ liệu nhập vào
    $usn = $_POST['usn'];
    $pwd = $_POST['pwd'];
     
    //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
    if (!$usn|| !$pwd) {
        header("Location: ../view/login.php?loginfailed");
        exit;
    }
     
    //Kiểm tra tên đăng nhập có tồn tại không
    $query = mysqli_query($conn, "SELECT * FROM user WHERE usn='$usn'");
    if (mysqli_num_rows($query) == 0) {
        alert("Tài khoản không tồn tại");
        exit;
    }
    //Lấy mật khẩu trong database ra 
    $row = mysqli_fetch_array($query);
    
    
    //So sánh 2 mật khẩu có trùng khớp hay không
    if (!password_verify($pwd,$row['pwd'])&&$pwd!=$row['mail']) {
        alert("Mật khẩu không chính xác");
        exit;
    }
    if ($row['email_verified_at'] == null)
    {
        header("Location: email-verification.php?email=" . $usn);
    }
    else{
    //Lưu tên đăng nhập
    $_SESSION['usn'] = $row['usn'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['uid'] = $row['uid'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['uinfo'] = 1;
    if($row['role']){
    header("Location: ../view/teacher.php");
    die();
    }
    else {
        header("Location: ../view/student.php");
    die();
    }
}
}
if (isset($_POST['registerSubmit'])){
    header("Location: ../view/register.php");
}
?>