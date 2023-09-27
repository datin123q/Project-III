<?php
function getProName($conn){
    echo"<form action='".addPro($conn)."' method='POST' class='formContainer2'>";
    echo"Tên Nhóm: <input type='text' required name ='proname'</input><br><br>";
    echo"
    <button type='submit' name='addpro'>Thêm</button>
    <button type='button' onclick='closeForm2()'>Close</button>";
    echo"</form>";
  }
function addPro($conn){
    if(isset($_POST['addpro'])){
        $pcode = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $uid = $_SESSION['uid'];
        $ptitle = $_POST['proname'];
        $sql = "INSERT into project (ptitle, pcode ) VALUES ('$ptitle', '$pcode')";
        $result = $conn->query($sql);
        $sql3 = "SELECT * FROM project ORDER BY pid DESC LIMIT 1";
        $result2 = $conn->query($sql3);
        while($row = $result2->fetch_assoc()){
            $pid= $row['pid'];
            $sql2 = "INSERT into user_pro (uid, pid,owner  ) VALUES ('$uid', '$pid', 1)";
            $result3 = $conn->query($sql2);
        }
        echo "<script type='text/javascript'>
        window.location='../view/student.php';
        alert('Tạo nhóm thành công!!');
        </script>";
    }
}
function addTL($conn){
    if(isset($_POST['addTL'])){
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $path = "../files/".$fileName;
        $uid= $_SESSION['uid'] ;
        $aid= $_SESSION['aid'] ;
        $wid = $_SESSION['wid'];
        $date = $_POST['date'];
        // $query = "INSERT INTO filedownload(filename) VALUES ('$fileName')";
        // $query = "INSERT INTO user_ass (wid, uid, aid, result, file, date) VALUES (NULL, '$uid', '$aid', 0, '$fileName', '$date');";
        $query = "INSERT INTO ass_file (aid, file) VALUES ('$aid', '$fileName');";
        if($fileName != ''){
        $run = mysqli_query($conn,$query);
            if($run){
                move_uploaded_file($fileTmpName,$path);
                echo "success";
            }
            else{
                echo "error".mysqli_error($conn);
            }
        }
        mark($conn, $uid, $aid);
        echo "<meta http-equiv='refresh' content='0'>"; 
    }
}
?>