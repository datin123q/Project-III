<?php include_once("layout.php");
if($_SESSION['role']==1){
    header("Location: teacher.php");
    die();
    }
 ?>
<!doctype html>
<html lang="en">
  <head>
  	<title>PROJECT 1</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
				<div class="p-4 pt-5">
                    <?php
                    echo"<form method = 'POST' action = '".setUser($conn)."'>
                        <input type='hidden' name='uinfo' value='1'>
                        <button style='background-color:#866ec7 ; border: none; width:160px ; color: #FFF;' class='nav-link collapsed' name = 'setuinfo' style='border: none;'>
                            <span>".$_SESSION['name']."</span>
                        </button>
                    </form>";
                    ?>
                  <?php
                getNameAssignments($conn);
                ?>

                    <a href="login.php" style="color: #FFF;">Log out</a>

	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->

        <!-- <h2 class="mb-4">Sidebar #02</h2>

      </div>
		</div> -->
        <div class='container'>
            <div class='container-body'>
                <div class ='assignment'>
                    <?php
                        if(isset($_SESSION['uinfo'])){
                            getUserinfo($conn);
                        }
                        if(isset($_SESSION['aid'])){
                        getAssignments($conn);

                        echo "<form method= 'POST' action='".setComments($conn)."'>
                            <input type='hidden' name='uid' value='".$_SESSION['uid']."'>
                            <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                            <textarea name= 'message'> </textarea></br>
                            <button type='submit' style='margin-left: 88%;' name = 'commentSubmit'>Bình luận</button>
                        
                        </form> ";
                        getComments($conn);
                    }
                    if(!isset($_SESSION['uinfo'])&&!isset($_SESSION['aid'])&&!isset($_SESSION['dssv'])){
                        echo "<form method= 'POST' action='".setComments($conn)."'>
                            <input type='hidden' name='uid' value='".$_SESSION['uid']."'>
                            <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                            <textarea name= 'message'> </textarea></br>
                            <button type='submit' style='margin-left: 88%;' name = 'commentSubmit2'>Gửi</button>
                        
                        </form> ";
                        getComments2($conn);
                    }
                        ?>
                    </div>
                <div class='submit'>
                    <?php
                    if(isset($_SESSION['aid'])){
                        $uid = $_SESSION['uid'];
                        $aid = $_SESSION['aid'];
                        $sql3 = "SELECT * from assignments, user_pro WHERE user_pro.uid = '$uid' and assignments.pid= user_pro.pid and assignments.aid='$aid'";
                        $result3 = $conn->query($sql3);
                        while($row3 = $result3->fetch_assoc()){
                        if($row3['owner']==0){
                            echo"
                            <table class ='work-box'>
                            <tr>
                                <td>";
                                    echo "<form action='".submitWork($conn)."' method='post' enctype='multipart/form-data'>
                                    <input type='hidden' name='date' value='".date('Y-m-d')."'>
                                    <input type='file' name='file' >
                                    <button type='submit' name='submitW'> Nộp bài</button>
                                    </form>";
                                    echo"
                                </td>
                            </tr>
                            <tr>
                                <td>";
                                    getWork($conn);
                                    echo"
                                </td>
                            </tr>
                        </table>";}
                        else getWorkGv($conn);
                        }
                            }
                            if(!isset($_SESSION['uinfo'])&&!isset($_SESSION['aid'])&&!isset($_SESSION['dssv'])){
                                echo" <h3>Tài liệu chung</h3></br>
                            <table class ='work-box'>
                            <tr>
                                <td>";
                                getWorkChung($conn);
                                    echo"
                                </td>
                            </tr>
                            <tr>
                                <td>";
                                echo "<form action='".submitWork($conn)."' method='post' enctype='multipart/form-data'>
                                <input type='hidden' name='date' value='".date('Y-m-d')."'>
                                <input type='file' name='file' >
                                <button type='submit' name='submitW2'> Tải lên</button>
                                </form>";
                                    echo"
                                </td>
                            </tr>
                        </table>";
                                
                            }
                    ?>
                </div>
                <div class="loginPopup">
                    <div class="formPopup" id="popupForm">
                      
                      <?php
                        
                      getUserName($conn);
                        
                        ?>

                    </div>
                  </div>
                <div class="loginPopup2">
                    <div class="formPopup2" id="popupForm2">
                      
                      <?php
                        
                      getProName($conn);
                        
                        ?>

                    </div>
                  </div> 
                  <div class="loginPopup4">
                    <div class="formPopup4" id="popupForm4">
                      
                      <?php
                        
                        addtogr($conn)
                        
                        ?>

                    </div>
                  </div> 
            </div>
        </div>

        <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/main2.js"></script>
  </body>
</html>