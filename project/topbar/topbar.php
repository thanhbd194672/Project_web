<?php session_start(); 
    include "../connect_database/connect_db.php";  


    if(isset($_GET['login'])){
      $dangxuat = $_GET['login'];
              }else{
                   $dangxuat = '';
                      if(isset($_SESSION['username'])){
                      $sql = "SELECT * FROM users WHERE username = '$_SESSION[username]'";
                      $result = pg_query($db_connection, $sql) ;
                      $row = pg_fetch_object($result);
                      $img = $row->avatar;
                    }
                   }
      if($dangxuat=='dangxuat'){
        session_destroy();
        header('Location: ../trangchu/foodinfo.php');
     }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
          <meta charset="UTF-8" />
          <meta http-equiv="X-UA-Compatible" content="IE=edge" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>HNFOOD</title>
          <!-- CSS -->
          <link rel="stylesheet" href="../topbar/css/topbar.css?t=[timestamp]" type="text/css"/>
          <!-- Unicons CSS -->
          <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
          <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
          <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
          <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
          <script src="../topbar/js/script.js" defer></script>
        </head>
<body class="header">
	<nav class="nav">
            <i class="uil uil-bars navOpenBtn"></i>
            <a class="logo" href="foodinfo.php"><b>HNFoods</b></a>
            <!-- MENU của bài</!-->
            <ul class="nav-links">
              <i class="uil uil-times navCloseBtn"></i>
              <li><a href="foodinfo.php">Trang chủ</a></li>
              <li><a href="#">Profile</a></li>
              <li><a href="../commitform/commenttest.php">Feedback</a></li>        
              <li><a href="#footer">Join Us</a></li>
            </ul>
            <!--</!-->

           <!-- hiện thị thanh tìm kiếm </!-->
            <i class="uil uil-search search-icon" id="searchIcon"></i>
            <div class="search-box">
              <i class="uil uil-search search-icon"></i>
              <input type="text" placeholder="Search here..." />
            </div>
            <!--</!-->

            <!--phần đăng nhập</!-->
           <div class="main">
             <?php if(!isset($_SESSION['dangnhap'])){  ?>
          <i class="ri-user-fill"  onclick="toggleMenu()"></i>
              <div class="sub-menu-wrap" id = "subMenu">
              <div class="sub-menu">
                <a href="../login/login.php"class="sub-menu-link">
                  <p>Đăng nhập</p>
                  <span>></span>
                </a>
                <a href="../register/register.php" class="sub-menu-link">
                  <p>Đằng ký</p>
                  <span>></span>
                </a>

              </div>
            </div>
      <?php session_destroy();}
      elseif($_SESSION['dangnhap'] != '$admin'){ ?>
          <img src="<?php echo $img?>" alt="" class= "logo1" onclick="toggleMenu()">
            <div class="sub-menu-wrap" id = "subMenu">
              <div class="sub-menu">
           <div class="user-info">
              <img src="<?php echo $img?>" alt="">
                <h2><?php echo $_SESSION['dangnhap'] ?></h2>
           </div>
                <hr>
                <a href="../userinfoupdate/userinfo.php" class="sub-menu-link">
                  <p>Cập nhật thông tin</p>
                </a>
                <a href="" class="sub-menu-link">
                  <p>Đã theo dõi</p> 
                </a>
                <a href="" class="sub-menu-link">
                  <p>Wish list</p> 
                </a>
                <a href="?login=dangxuat" class="sub-menu-link">
                  <p>Đăng xuẩt</p>
                </a>
                 <?php 
    } else{?>
           <img src="../images/avatar.jpg" alt="" class= "logo1" onclick="toggleMenu()">
            <div class="sub-menu-wrap" id = "subMenu">
              <div class="sub-menu">
           <div class="user-info">
              <img src="../images/avatar.jpg" alt="">
                <h2><?php echo $_SESSION['dangnhap'] ?></h2>
           </div>
                <hr>
                <a href="../admin/admin_update_stall.php" class="sub-menu-link">
                  <p>Thêm gian hàng</p>
                </a>
                <a href="../admin/admin_update_stall.php" class="sub-menu-link">
                  <p>Sửa gian hàng</p> 
                </a>
                <a href="" class="sub-menu-link">
                  <p>Thêm món ăn</p> 
                </a>
                <a href="../admin/admin_update_dishes.php" class="sub-menu-link">
                  <p>Sửa món ăn</p> 
                </a>
                <a href="?login=dangxuat" class="sub-menu-link">
                  <p>Đăng xuất</p>
                </a>
    <?php } ?>
        </div>
      </div>
  </div>
  <div class="bx bx-menu" id="menu-icon"></div>
 
            <!--</!-->
  
      </nav>
</body>
</html>