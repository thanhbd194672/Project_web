<?php 
   session_start();
include "../connect_database/connect_db.php";
  if(!isset($_SESSION['dangnhap'])){
        header('Location: ../trangchu/foodinfo.php');
    } 
    if(isset($_GET['login'])){
    $dangxuat = $_GET['login'];
     }else{
        $dangxuat = '';
     }
     if($dangxuat=='dangxuat'){
        session_destroy();
        header('Location: ../trangchu/foodinfo.php');
     }
       $avatar_auto='../images/avatar.jpg';
if (isset($_POST['capnhap'])) {
  echo '<script language="javascript">alert("Successfully uploaded!!"); window.location="../trangchu/foodinfo.php";</script>';
  $name_n = $_POST['name_n'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $password = $_POST['password'];
  $address = $_POST['diachi'];
  $anhdaidien = $_POST['anhdaidien'];
  if($_FILES['anhdaidien']['name'] != NULL){
  $fileName=$_FILES['anhdaidien']['name'];
  $fileTempt=$_FILES['anhdaidien']['tmp_name'];
  $folder='../images/';
  $name=time().'_'.$fileName;
  $ext=substr($name,strlen($name)-3,3);
  $ext1=substr($name,strlen($name)-4,4);
  $src = $folder.$name;
  if($ext=="JPG"||$ext=="jpg"||$ext1=="JPEG"||$ext1=="jpeg"||$ext=="GIF"||$ext=="gif"||$ext=="BMP"||$ext=="bmp"||$ext=="PNG"||$ext=="png"){
    move_uploaded_file($fileTempt, $src);
  }else{
    $alert=1;
  }
  $query ="UPDATE users SET username = '$email', password = '$password', name = '$name_n', telephone_num ='$phone', address ='$address', avatar='$src' WHERE username = '$_SESSION[username]'";

  }
else{
  $query ="UPDATE users SET username = '$email', password = '$password', name = '$name_n', telephone_num ='$phone', address ='$address'WHERE username = '$_SESSION[username]'";
}  
  $result1 = pg_query($db_connection, $query);
    $_SESSION['dangnhap'] = $name_n;
    $row1 = pg_fetch_object($result1);

}
$sql = "SELECT * FROM users WHERE username = '$_SESSION[username]'";
$result = pg_query($db_connection, $sql) ;
$row = pg_fetch_object($result);
$_SESSION['img'] = $row->avatar;
if(!isset($_SESSION['img'])|| file_exists($row->avatar)!=true)
{
  $_SESSION['img'] = $avatar_auto;
  
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/userinfo.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <i class="logo"><b>HNFoods</b></i>
  <div class="container">
    <div class="title">Cập nhật thông tin</div>
    <div class="content">
      <form method="POST" enctype="multipart/form-data">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Name</span>
            <input type="text" placeholder="Enter your name" name ="name_n" value="<?php  echo"$row->name"; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" placeholder="Enter your email"  name="email"value="<?php  echo"$row->username"; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="number" placeholder="Enter your number"  name ="phone" value="<?php  echo"$row->telephone_num"; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" placeholder="Enter your password" name ="password" value="<?php  echo"$row->password"; ?>"required>
          </div>
          <div class="input-box">
            <span class="details">Địa chỉ</span>
            <input type="text" placeholder="Enter your Address" name="diachi" value="<?php  echo"$row->address"; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Ảnh đại diện</span>
            <input type="file"  name="anhdaidien" value="<?php  echo"$row->avatar"; ?>" >
          </div>
        </div>
        <div class="button">
          <input type="submit" name= "capnhap" value="Cập nhật">
        </div>
        <div class="signup-link"><a href="../trangchu/foodinfo.php">Quay lại trang chủ</a></div>
      </form>
    </div>
  </div>

</body>
</html>