<?php
function getNameAssignments($conn) {
    $uid = $_SESSION['uid'];
    $sql2 = "SELECT * from project, user_pro WHERE user_pro.uid = '$uid' and user_pro.pid= project.pid";
    $sql = "SELECT *from assignments,user_ass WHERE user_ass.uid = '$uid' and user_ass.aid= assignments.aid ";
    $result2 = $conn->query($sql2);
    while($row2 = $result2->fetch_assoc()){
            echo "
            <ul class='list-unstyled components mb-5'>
                <li class='active'>
                    <a href='#".$row2['ptitle']."' data-toggle='collapse' aria-expanded='false' class='dropdown-toggle'>".$row2['ptitle']."-".$row2['pcode']."</a>
                <ul class='collapse list-unstyled' id='".$row2['ptitle']."'>";
                $result = $conn->query($sql);
                echo "  
                                <li>
                                    <form method = 'POST' action = '".setAssignmentid($conn)."'>
                                        <input type='hidden' name='pid' value='".$row2['pid']."'>
                                        <input type='hidden' name='upid' value='".$row2['upid']."'>
                                        <button class='ass_button' name = 'setchung' style='
                                            width: 160px;
                                            background-color: #866ec7; 
                                            color: #fff;
                                            border: none;
                                            text-align: center;
                                            text-decoration: none;
                                            cursor: pointer'>
                                            <span>Chung</span>

                                        </button>
                                    </form>
                                </li>";
                while($row = $result->fetch_assoc()){
                    if($row['pid'] == $row2['pid']){
                        echo "  
                                <li>
                                    <form method = 'POST' action = '".setAssignmentid($conn)."'>
                                        <input type='hidden' name='aid' value='".$row['aid']."'>
                                        <button class='ass_button' name = 'setassid' style='
                                            width: 160px;
                                            background-color: #866ec7; 
                                            color: #fff;
                                            border: none;
                                            text-align: center;
                                            text-decoration: none;
                                            cursor: pointer'>
                                            <span>".$row['title']."</span>
                                            ".isMark($conn, $uid, $row['aid'])."
                                        </button>
                                    </form>
                                </li>";
                    }
                    
                }
                if($row2['owner']){echo "
                <div>
                        <li class='nav-item'>

                            <button onclick='openForm3(".$row2['pid'].")' style='background-color:#866ec7 ; border: none; width:160px ; color: #FFF;' name = 'addass' style='border: none;'>
                                <span>+ Thêm bài tập</span>
                            </button>
                        </li>
                </div>";}
                echo"                                
                </ul>
                </li>
              </ul>";
              echo"<div class='loginPopup3'>
              <div class='formPopup3' id='".$row2['pid']."'>
                  <form method = 'POST' class='formContainer3' action = '".addass($conn)."'>
                    <ul>
                      <li>
                          <label>Tiêu đề: </label>
                          <input type='text' name='title'required>
                      </li>
                      <br>
                      <li>
                          <label>Nội dung:</label><br><br>
                          <textarea name= 'content' required> </textarea>
                      </li>
                      <br>
                      <li>
                          <label>Thời gian kết thúc</label>
                          <input type='date'  name='ftime' required>
                      </li>
                    </ul>
                    <input type='hidden' name='pid' value='".$row2['pid']."'>
                    <input type='hidden' name='stime' value='".date('Y-m-d H:i:s')."'>
                    <Button type='submit' name='addass'>Thêm </button>
                    <button type='button' onclick='closeForm3(".$row2['pid'].")'>Đóng</button>';
                  <br>  
                </form>
                
              </div>
            </div>";
    }
    echo "
    <div>
                <button onclick='openForm2()' style='background-color:#866ec7 ; border: none; width:160px ; color: #FFF;text-align: left;font-size:18px' name = 'addpro'>
                    + Tạo nhóm
                </button>
    </div>";
    echo "
    <div>
                <button onclick='openForm4()' style='background-color:#866ec7 ; border: none; width:160px ; color: #FFF;text-align: left;font-size:18px' name = 'addpro'>
                    + Thêm vào nhóm
                </button>
    </div>";
}
function isMark($conn, $uid, $aid){
    $sql = "SELECT* from user_ass WHERE uid='$uid' and aid = '$aid'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        if($row['mark']==1){
            echo"<i class='fa fa-exclamation-circle' style='color:yellow ;'></i>";
        }
    }
}

function mark($conn, $uid, $aid){
    $sql = " UPDATE user_ass SET mark =1 WHERE uid<>'$uid' and aid = '$aid'";
    $result = $conn->query($sql);
}
function unmark($conn, $uid, $aid){
    $sql = " UPDATE user_ass SET mark =0 WHERE uid='$uid' and aid = '$aid'";
    $result = $conn->query($sql);
}

function getNameAssignmentsGv($conn) {   
    $uid = $_SESSION['uid'];
    $sql2 = "SELECT * from project ";
    $sql = "SELECT *from assignments ";
    $result2 = $conn->query($sql2);
    while($row2 = $result2->fetch_assoc()){
            echo "
            <ul class='list-unstyled components mb-5'>
                <li class='active'>
                    <a href='#".$row2['ptitle']."' data-toggle='collapse' aria-expanded='false' class='dropdown-toggle'>".$row2['ptitle']."</a>
                <ul class='collapse list-unstyled' id='".$row2['ptitle']."'>";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    if($row['pid'] == $row2['pid']){
                        echo "  
                                <li>
                                    <form method = 'POST' action = '".setAssignmentid($conn)."'>
                                        <input type='hidden' name='aid' value='".$row['aid']."'>
                                        <button class='ass_button' name = 'setassid' style='
                                            width: 160px;
                                            background-color: #866ec7; 
                                            color: #fff;
                                            border: none;
                                            text-align: center;
                                            text-decoration: none;
                                            cursor: pointer'>
                                            <span>".$row['title']."</span>
                                            ".isMark($conn, $uid, $row['aid'])."
                                        </button>
                                    </form>
                                </li>";
                    }
                    
                }
                echo "
                <div>
                        <li class='nav-item'>

                            <button onclick='openForm3(".$row2['pid'].")' style='background-color:#866ec7 ; border: none; width:160px ; color: #FFF;' name = 'addass' style='border: none;'>
                                <span>+ Thêm</span>
                            </button>
                        </li>
                </div>";
                echo"                                
                </ul>
                </li>
              </ul>";
              echo"<div class='loginPopup3'>
              <div class='formPopup3' id='".$row2['pid']."'>
                  <form method = 'POST' class='formContainer3' action = '".addass($conn)."'>
                    <ul>
                      <li>
                          <label>Tiêu đề: </label>
                          <input type='text' name='title'required>
                      </li>
                      <br>
                      <li>
                          <label>Nội dung:</label><br><br>
                          <textarea name= 'content' required> </textarea>
                      </li>
                      <br>
                      <li>
                          <label>Thời gian kết thúc</label>
                          <input type='date'  name='ftime' required>
                      </li>
                    </ul>
                    <input type='hidden' name='pid' value='".$row2['pid']."'>
                    <input type='hidden' name='stime' value='".date('Y-m-d H:i:s')."'>
                    <Button type='submit' name='addass'>Thêm </button>
                    <button type='button' onclick='closeForm3(".$row2['pid'].")'>Đóng</button>';
                  <br>  
                </form>
                
              </div>
            </div>";
    }
    echo "
    <div>
                <button onclick='openForm2()' style='background-color:#866ec7 ; border: none; width:160px ; color: #FFF;text-align: left;font-size:18px' name = 'addpro'>
                    + Thêm 
                </button>
    </div>";
    echo "
    <div>
                <form method = 'POST' action = '".setdssv($conn)."'>
                <button style='background-color:#866ec7 ; border: none; width:160px ; color: #FFF;text-align: left;font-size:16px; margin-left:-10px' name = 'dssv'>
                    Danh sách SV 
                </button>
            </form>
    </div>";
}
function addass($conn){
    if(isset($_POST['addass'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $stime = $_POST['stime'];
        $ftime = $_POST['ftime'];
        $pid = $_POST['pid'];
        $sql = "INSERT into assignments (title, content, stime, ftime, pid ) VALUES ('$title', '$content', '$stime', '$ftime', '$pid')";
        $sql2 = "SELECT * from assignments WHERE pid = '$pid'";
        $result2 = $conn->query($sql2);
        $n = 0;
        while($row2 = $result2->fetch_assoc()){
            if(!strcmp($title, $row2['title'])){
                $n = 1;
            }
        }
        if($n ==0){
            $result = $conn->query($sql);
        }
        $sql3 = "SELECT * FROM assignments ORDER BY aid DESC LIMIT 1";
        $result3 = $conn->query($sql3);
        while($row3 = $result3->fetch_assoc()){
            $uid = $_SESSION['uid'];
            $aid= $row3['aid'];
            $sql5= "SELECT * from user_ass WHERE uid='$uid' and aid ='$aid'";
            $result5 = $conn->query($sql5);
            $n = 0;
            while($row5 = $result5->fetch_assoc()){
                $n=1;
            }
            if($n ==0)
            $sql4 = "INSERT into user_ass (uid, aid,result, mark  ) VALUES ('$uid', '$aid', 0, 0)";
            $result4 = $conn->query($sql4);
        }
        echo "<meta http-equiv='refresh' content='0'>";
    }

}
function setAssignmentid($conn){

    if(isset($_POST['setassid'])){
        $_SESSION['aid'] = $_POST['aid'];
        $aid = $_SESSION['aid'];
        $uid = $_SESSION['uid'];
        $sql = "SELECT * from user_ass WHERE aid = '$aid' and uid = '$uid'";
        $result = $conn->query($sql);
            if($row = $result->fetch_assoc()){
                $_SESSION['wid']= $row['wid'];
            }
        $sql2 = "SELECT * from user_pro,assignments WHERE user_pro.uid= '$uid' and assignments.aid='$aid' and user_pro.pid= assignments.pid";
        $result2 = $conn->query($sql2);
            if($row2 = $result2->fetch_assoc()){
                $_SESSION['owner']= $row['owner'];
                $_SESSION['pid']= $row['pid'];
            }
        if(isset($_SESSION['uinfo'])){
            unset($_SESSION['uinfo']);
        }
        if(isset($_SESSION['dssv'])){
            unset($_SESSION['dssv']);
        }
        unmark($conn, $uid, $aid);
    }
    if(isset($_POST['setchung'])){
        if(isset($_SESSION['aid'])){
            unset($_SESSION['aid']);
        }
        if(isset($_SESSION['uinfo'])){
            unset($_SESSION['uinfo']);
        }
        if(isset($_SESSION['dssv'])){
            unset($_SESSION['dssv']);
        }
        $_SESSION['pid'] = $_POST['pid'];
        $_SESSION['upid'] = $_POST['upid'];
        $pid = $_SESSION['pid'];
        $upid = $_SESSION['upid'];
    }
}
function getAssignments($conn){

    if(isset($_SESSION['aid'])){
        $aid = $_SESSION['aid'];
        $uid = $_SESSION['uid'];
        $sql = "SELECT * from assignments WHERE aid = '$aid'";
        $result = $conn->query($sql);
            if($row = $result->fetch_assoc()){
                echo "<div class = 'assignment-box'>";
                echo"<h2 class='mb-4'>".$row['title']."</h2>";
                echo"<div style='font-size:12px; margin-top:-25px'>Đến hạn ".$row['ftime']."</div><br>";
                echo"Hướng dẫn";
                echo "<h5>".nl2br($row['content']."<br><br>")."</h5>";
            }
        $sql2 = "SELECT * from ass_file WHERE aid = '$aid'";
        $result = $conn->query($sql2);
        echo"Tài liệu<br>";
        while($row2 = $result->fetch_assoc()){
            echo"<a href='../model/download.php?file=".$row2['file']."'>".$row2['file']."</a><br>";
            
        }
        $sql3 = "SELECT * from assignments, user_pro WHERE user_pro.uid = '$uid' and assignments.pid= user_pro.pid and assignments.aid='$aid'";
        $result3 = $conn->query($sql3);
        while($row3 = $result3->fetch_assoc()){
        if($row3['owner']==0){
        echo"Bài tập đã nộp<br>";
        echo"".getmyWork($conn)."";
        }
        if($row3['owner']==1){
            echo "<form action='".addTL($conn)."' method='post' enctype='multipart/form-data'>
                            <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                            <input type='file' required name='file' >
                            <button type='submit' name='addTL'> Thêm tài liệu</button>
                            </form>";
        }
        }
        echo "</div>";

    }
}

?>