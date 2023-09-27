<?php

function setComments($conn){
    if(isset($_POST['commentSubmit'])){
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        $aid = $_SESSION['aid'];
        if(!empty($message)){
        $sql = "INSERT into comments (uid, date, message, aid ) VALUES ('$uid', '$date', '$message', '$aid')";
        $result = $conn->query($sql);
        mark($conn, $uid, $aid);
        }
    }
    if(isset($_POST['commentSubmit2'])){
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        $pid = $_SESSION['pid'];
        if(!empty($message)){
        $sql = "INSERT into comment_chung (uid, date, message, pid ) VALUES ('$uid', '$date', '$message', '$pid')";
        $result = $conn->query($sql);
        mark($conn, $uid, $aid);
        }
    }
}
function deleteComment($conn){
    if(isset($_POST['deleteSubmit'])){
        $cid = $_POST['cid'];
        $sql = "DELETE from comments WHERE cid = '$cid'";
        $result = $conn->query($sql);
        echo "<script type='text/javascript'>
        window.location='../view/student.php';
        alert('Xóa bình luận thành công!!');
        </script>";
    }
}
function deleteComment2($conn){
    if(isset($_POST['deleteSubmit'])){
        $ccid = $_POST['ccid'];
        $sql = "DELETE from comment_chung WHERE ccid = '$ccid'";
        $result = $conn->query($sql);
        echo "<script type='text/javascript'>
        window.location='../view/student.php';
        alert('Xóa bình luận thành công!!');
        </script>";
    }
}
function getComments($conn) {
    if(isset($_SESSION['aid'])){
        $aid = $_SESSION['aid'];
        $sql = "SELECT cid, comments.uid, name, date, message from comments, user WHERE comments.uid = user.uid and comments.aid= '$aid'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            echo "<div class = 'comment-box'> <p>";
            echo $row['name']."<br>";
            echo $row['date']."<br>";
            echo nl2br($row['message']."<br><br>");
            echo "</p>";
            if($row['uid'] == $_SESSION['uid']){
                echo "
                    <form class= 'delete-form' method = 'POST' action = '".deleteComment($conn)."'>
                        <input type='hidden' name='cid' value='".$row['cid']."'>
                        <button name ='deleteSubmit'>Delete</button>
                    </form>
                    </div>";
            }else echo "</div>";
        }
    }
}
function getComments2($conn) {
    if(isset($_SESSION['pid'])){
        $pid = $_SESSION['pid'];
        $sql = "SELECT ccid, comment_chung.uid, name, date, message from comment_chung, user WHERE comment_chung.uid = user.uid and comment_chung.pid= '$pid'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            echo "<div class = 'comment-box'> <p>";
            echo $row['name']."<br>";
            echo $row['date']."<br>";
            echo nl2br($row['message']."<br><br>");
            echo "</p>";
            if($row['uid'] == $_SESSION['uid']){
                echo "
                    <form class= 'delete-form' method = 'POST' action = '".deleteComment2($conn)."'>
                        <input type='hidden' name='ccid' value='".$row['ccid']."'>
                        <button name ='deleteSubmit'>Delete</button>
                    </form>
                    </div>";
            }else echo "</div>";
        }
    }
}
?>