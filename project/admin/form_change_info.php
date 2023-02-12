<?php 
   include "../connect_database/connect_db.php";  
   session_start();
 
  
    if (isset($_POST['capnhap'])) {

  echo '<script language="javascript">alert("Successfully uploaded!!"); window.location="admin_update_stall.php";</script>';
  $name_n = $_POST['name_n'];
  $type = $_POST['type'];
  $address = $_POST['address'];
  $time_o = $_POST['time_o'];
  $time_c = $_POST['time_c'];
  $telephone_number = $_POST['telephone_number'];
  $image = $_POST['image'];

  
  $fileName=$_FILES['image']['name'];
  $fileTempt=$_FILES['image']['tmp_name'];
  $folder='../images/';
  $name=time().'_'.$fileName;
  $ext=substr($name,strlen($name)-3,3);
  $ext1=substr($name,strlen($name)-4,4);
  $src = $folder.$name;
  if($ext=="JPG"||$ext=="jpg"||$ext1=="JPEG"||$ext1=="jpeg"||$ext=="GIF"||$ext=="gif"||$ext=="BMP"||$ext=="bmp"||$ext=="PNG"||$ext=="png"){
    move_uploaded_file($fileTempt, $src);
    echo"<script>alert('Successfully uploaded!')</script>";
  }else{
    $alert=1;
  }
  $query ="UPDATE stalls SET name = '$name_n', address = '$address', type = '$type', telephone_num ='$telephone_number', time_o ='$time_o', time_c='$time_c', image ='$src' WHERE id = '$_SESSION[id_modify]'";

  
  $result1 = pg_query($db_connection, $query);
    echo"<script>alert('Successfully uploaded!')</script>";
      
     
    $_SESSION['dangnhap'] = $name_n;
    $row1 = pg_fetch_object($result1);
   
}
$sql = "SELECT *,stalls.address[1] as diachi FROM stalls WHERE id = '$_SESSION[id_modify]'";
$result = pg_query($db_connection, $sql) ;
$row = pg_fetch_object($result);

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
    <div class="title">Cập nhật gian hàng</div>
    <div class="content">
      <form method="POST" enctype="multipart/form-data">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Name</span>
            <input type="text" placeholder="Enter stall's name" name ="name_n" value="<?php  echo"$row->name"; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Type</span>
            <input type="text" placeholder="Enter stall's type"  name="type"value="<?php  echo"$row->type"; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Address</span>
            <input type="text" placeholder="Enter stall's address"  name ="address" value="<?php  echo"$row->diachi"; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Time open</span>
            <input type="text" placeholder="Enter stall's time open" name ="time_o" value="<?php  echo"$row->time_o"; ?>"required>
          </div>
          <div class="input-box">
            <span class="details">Time close</span>
            <input type="text" placeholder="Enter stall's time close" name="time_c" value="<?php  echo"$row->time_c"; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Telephone number</span>
            <input type="text" placeholder="Enter telephone num" name="telephone_number" value="<?php  echo"$row->telephone_num"; ?>"required >
          </div>
          <div class="input-box">
            <span class="details">Image</span>
            <input type="text"  name="image" value="<?php  echo"$row->image"; ?>" >
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