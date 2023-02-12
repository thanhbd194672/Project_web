<?php 
 $queries = array();
 parse_str($_SERVER['QUERY_STRING'], $queries);

 if(isset($queries['stall'])){

   //Cần query ?stall=1 ...
   $stall_id = $queries['stall'];
 }
   include "../connect_database/connect_db.php";  
   session_start();
 
  
    if (isset($_POST['capnhap'])) {

  echo '<script language="javascript">alert("Successfully uploaded!!"); window.location="admin_update_stall.php";</script>';

  $name_n = $_POST['name_n'];
  $type = $_POST['type'];
  $address = "{";
  $x=1;
  while($_POST['address'."$x"]){
    $addressp = $_POST['address'."$x"];
    $address = $address . "\"$addressp\",";
    $x+=1;
  }
  $address = substr($address,0,-1);

  $address = $address."}";
  
  $time_o = $_POST['time_o'];
  $time_c = $_POST['time_c'];

  $telephone_number = "{";
  $y=1;
  while($_POST['telephone_number'."$y"]){
    $tele_num = $_POST['telephone_number'."$y"];
    $telephone_number = $telephone_number . "\"$tele_num\",";
    $y +=1;
  }
  $telephone_number= substr($telephone_number,0,-1);
  $telephone_number = $telephone_number."}";

  $image = $_POST['image'];
  
  
    $fileName=$_FILES['image']['name'];
    $fileTempt=$_FILES['image']['tmp_name'];
    $folder='../trangchu/stalls/';
    $name=$fileName;
    $ext=substr($name,strlen($name)-3,3);
    $ext1=substr($name,strlen($name)-4,4);
    $src = $name;
    if($ext=="JPG"||$ext=="jpg"||$ext1=="JPEG"||$ext1=="jpeg"||$ext=="GIF"||$ext=="gif"||$ext=="BMP"||$ext=="bmp"||$ext=="PNG"||$ext=="png"){
      move_uploaded_file($fileTempt, $folder.$name);
    }else{
      $alert=1;
    }
  $query ="UPDATE stalls SET name = '$name_n', address = '$address',telephone_num = '$telephone_number', type = '$type', time_o ='$time_o', time_c='$time_c', image ='$src' WHERE id = '$stall_id'";

  
  $result1 = pg_query($db_connection, $query);
    echo"<script>alert('Successfully uploaded!')</script>";
    $row1 = pg_fetch_object($result1);
   
}
$sql = "SELECT * FROM stalls WHERE id = '$stall_id'";
$result = pg_query($db_connection, $sql) ;
$row = pg_fetch_object($result);
$q_address = "SELECT address_c from public.stalls, unnest (stalls.address) as address_c where stalls.id = ".$stall_id." ;";
$address_q = pg_query($db_connection,$q_address);
$sdt = "SELECT sdt from public.stalls, unnest (stalls.telephone_num) as sdt where stalls.id = ".$stall_id." ;";
$q_sdt = pg_query($db_connection,$sdt);
$i = 0;
$j = 0;
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
          <?php while($adr = pg_fetch_array($address_q)){$i += 1 ?>
                
             
          <div class="input-box">
            <span class="details">Address</span>
            <input type="text" placeholder="Enter stall's address"  name ="address<?php echo $i; ?>" value="<?php  echo $adr['address_c']; ?>" required>
          </div>

          <?php } ?>

          <div class="input-box">
            <span class="details">Time open</span>
            <input type="text" placeholder="Enter stall's time open" name ="time_o" value="<?php  echo"$row->time_o"; ?>"required>
          </div>
          <div class="input-box">
            <span class="details">Time close</span>
            <input type="text" placeholder="Enter stall's time close" name="time_c" value="<?php  echo"$row->time_c"; ?>" required>
          </div>
          <?php while($sdt_num = pg_fetch_array($q_sdt)){$j += 1 ?>
          <div class="input-box">
            <span class="details">Telephone number</span>
            <input type="text" placeholder="Enter telephone num" name="telephone_number<?php echo $j; ?>" value="<?php  echo $sdt_num['sdt']; ?>"required >
          </div>
          <?php } ?>
 
          <div class="input-box">
            <span class="details">Image</span>
            <input type="file"  name="image" value="<?php  echo"$row->image"; ?>" >
          </div>
         
        </div>
        <div class="button">
          <input type="submit" name= "capnhap" value="Cập nhật">
        </div>
        <div class="signup-link"><a href="admin_update_stall.php">Quay lại trang chủ</a></div>
      </form>
    </div>
  </div>

</body>
</html>