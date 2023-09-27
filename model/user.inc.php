<?php
function getUserinfo($conn) {
    $uid = $_SESSION['uid'];
    $sql = "SELECT * from user WHERE uid = '$uid' ";
    $result = $conn->query($sql);
    echo"<div class='userform1' >";
    while($row = $result->fetch_assoc()){
            echo "
            <h1 >THÔNG TIN</h1>
            <form method = 'POST' action = '".updateinfo($conn)."'>
              <ul>
                <li>
                  <p class='left'>
                    <label for='first_name'>Tài khoản:</label>
                    <input type='text' name='username' disabled='disabled' value='".$row['usn']."' />
                  </p>
                </li>
                <li>
                  <p class='left'>
                    <label for='first_name'>Mật khẩu:</label>
                    <input type='text' name='pwd' disabled='disabled' value='".$row['mail']."' />
                  </p>
                </li>
                <li>
                  <p class='left'>
                    <label for='first_name'>Họ và tên:</label>
                    <input type='text' name='name' required value='".$row['name']."' />
                  </p>
                </li>
                <li>
                  <p class='left'>
                    <label for='first_name'>MSSV:</label>
                    <input type='text' name='mssv' required value='".$row['MSSV']."' />
                  </p>
                </li>
                <li>
                  <p class='left'>
                    <label for='first_name'>Số điện thoại:</label>
                    <input type='text' name='sdt' required value='".$row['phone']."' />
                  </p>
                </li>
              <li>
              <p class='left'>
                <label for='first_name'>Ngày sinh:</label>
                <input type='date' required name='birthday' value='".$row['birth']."' />
              </p>
            </li>
              </ul>
              <button type = 'submit' name = 'updateinfo'>Update</button>
            </form>  ";
    }
    echo"</div>";
}
function setUser($conn){
    if(isset($_POST['setuinfo'])){
        $_SESSION['uinfo'] = $_POST['uinfo']; 
        if(isset($_SESSION['aid'])){
            unset($_SESSION['aid']);
        }
        if(isset($_SESSION['dssv'])){
          unset($_SESSION['dssv']);
        }
    }
}
function updateinfo($conn){
    if(isset($_POST['updateinfo'])){
        $pwd =$_POST['pwd'];
        $name =$_POST['name'];
        $mssv =$_POST['mssv'];
        $sdt =$_POST['sdt'];
        $birthday =$_POST['birthday'];
        $uid = $_SESSION['uid'];
        $sql = "UPDATE user
        SET pwd = '$pwd',
        name = '$name',
        MSSV = '$mssv',
        phone = '$sdt',
        birth = '$birthday'
        WHERE uid = '$uid';";
        $result = $conn->query($sql);
        $_SESSION['name'] = $name;
      echo "<script type='text/javascript'>
        window.location='../view/student.php';
        alert('Đổi thông tin thành công!!');
        </script>";
    }
}

function setdssv($conn){
  if(isset($_POST['dssv'])){
    $_SESSION['dssv'] = 1; 
    if(isset($_SESSION['aid'])){
        unset($_SESSION['aid']);
    }
    if(isset($_SESSION['uinfo'])){
      unset($_SESSION['uinfo']);
    }

}
}

function getDSSV($conn){
  if(isset($_SESSION['dssv'])){
    $sql  = "Select * from user,project, user_ass,assignments WHERE  user.role =0 and user.uid=user_ass.uid and user_ass.aid = assignments.aid and assignments.pid = project.pid ";
    $sql2= "SELECT * from user WHERE  user.role =0";
    $result2 = $conn->query($sql2);
    echo"<div style='width: 800px; background-color:#fff; margin-top:20px; margin-left:80px'>";
    echo"<div style='text-align: center; font-size:19px'>Danh sách sinh viên</div>";
    while($row2 = $result2->fetch_assoc()){
        echo"<button class='workGv'><span>".$row2['name']."-".$row2['MSSV']."</span>";
        echo"</button>";
        $result = $conn->query($sql); 
        $n =0;
        echo"<div class='panel'>";
        echo"<table style='width: 100%;
        border-collapse: collapse;border: 1px solid;'><tbody>";
        
        while($row = $result->fetch_assoc()){
            if($row['uid'] == $row2['uid']){
                $n = 1;
              echo"<tr>";
              echo"
              <td>".$row['ptitle']."</td>
              <td>".$row['title']."</td>
              <td> Điểm:".$row['result']."/10</td><td>";
              if(is_null($row['date'])){
                echo"Chưa nộp";
              }
              echo"</td></tr>";
            }
        }
        if($n ==0){
            echo "Chưa có bài tập nào";
        }
        echo"</tbody></table>";
        echo"</div>";
    }
    echo"<button class='workGv'onclick='openForm4()'>+Thêm Sinh Viên</button>";
    echo"</div>";
    echo"<script>
    var acc = document.getElementsByClassName('workGv');
    var i;
    
    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener('click', function() {
        this.classList.toggle('active');
        var panel = this.nextElementSibling;
        if (panel.style.display === 'block') {
          panel.style.display = 'none';
        } else {
          panel.style.display = 'block';
        }
      });
    }
    function selects(){  
                    var ele=document.getElementsByName('color[]');  
                    for(var i=0; i<ele.length; i++){  
                        if(ele[i].type=='checkbox')  
                            ele[i].checked=true;  
                    }  
                }  
    function deSelect(){  
                    var ele=document.getElementsByName('color[]');  
                    for(var i=0; i<ele.length; i++){  
                        if(ele[i].type=='checkbox')  
                            ele[i].checked=false;  
                          
                    }  
                }      
    </script>";
            }
}
function getUserName($conn){
  $aid =$_SESSION['aid'];
  $uid = $_SESSION['uid'];
  $sql = "SELECT * from user, user_pro, assignments WHERE role = 0 and user_pro.uid=user.uid and assignments.aid='$aid' and user_pro.pid= assignments.pid and user.uid!='$uid'";
  $result = $conn->query($sql);
  echo"<form action='".addUserAss($conn)."' method='POST' class='formContainer'>";
  echo"<div style='float:left'>Chọn sinh viên:</div><br>";
  while($row = $result->fetch_assoc()){
      echo"
          <div style='float:left'>".$row['name']."-".$row['MSSV']."</div><input type='checkbox' name='checkbox-user[]' style= 'float:right'value='".$row['uid']."'>
          <br>
           ";
  }
  echo"
  <button type='button' onclick='selects()'>Chọn tất cả</button>
  <button type='button' onclick='deSelect()'>Bỏ chọn</button><br>
  <button type='submit' name='adduser'>Thêm</button>
  <button type='button' onclick='closeForm()'>Đóng</button>";
  echo"</form>";
}
function addUserAss($conn){
  if(isset($_POST['adduser'])){
    $aid = $_SESSION['aid'];
    $uids = $_POST['checkbox-user'];
    foreach ($uids as $uid){ 
      $sql2 = "SELECT * from user_ass WHERE aid='$aid'";
      $result2 = $conn->query($sql2);
      $n = 0;
      while($row = $result2->fetch_assoc()){
        if($uid ==$row['uid']){
          $n = 1;
        }
      }
      if($n == 0){
        $sql = "INSERT into user_ass (uid, aid, result, date, mark ) VALUES ('$uid', '$aid', 0, NULL, 1)";
        $result = $conn->query($sql);
        echo "<meta http-equiv='refresh' content='0'>";
      }
    }
  }
}
function addtogr($conn){
  echo"<form action='".addgr($conn)."' method='POST' class='formContainer4'>";
  echo"Mã Group: <input type='text' required name ='pcode'</input><br><br>";
  echo"
  <button type='submit' name='addgr'>Thêm</button>
  <button type='button' onclick='closeForm4()'>Close</button>";
  echo"</form>";
}
function addgr($conn){
  if(isset($_POST['addgr'])){
      $uid = $_SESSION['uid'];
      $pcode = $_POST['pcode'];
      $sql = "SELECT * FROM project WHERE pcode = '$pcode'";
      $result = $conn->query($sql);
      while($row = $result->fetch_assoc()){
      $pid = $row['pid'];
      $sql2 = "INSERT into user_pro (uid, pid, owner) VALUES ( '$uid', '$pid',0)";
      $result2 = $conn->query($sql2);
      }
      echo "<script type='text/javascript'>
      window.location='../view/student.php';
      alert('Thêm vào nhóm thành công!!');
      </script>";
  }
}
?>