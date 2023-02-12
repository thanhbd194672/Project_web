<?php 
 $queries = array();
 parse_str($_SERVER['QUERY_STRING'], $queries);

 if(isset($queries['dish'])){

   //Cần query ?stall=1 ...
   $dish_id = $queries['dish'];
 }
   include "../connect_database/connect_db.php";  
   session_start();
 
  
    if (isset($_POST['capnhap'])) {
  $sql = "SELECT * FROM dishes WHERE id = '$dish_id'";
  $result_p = pg_query($db_connection, $sql) ;
  $row_p = pg_fetch_object($result_p);
  echo '<script language="javascript">alert("Successfully uploaded!!"); window.location="admin_update_dishes.php";</script>';

  $name_n = $_POST['name_n'];
  $type = $_POST['type'];
  $saleoff = $_POST['saleoff'];
  $price = $_POST['price'];
  $image = $_POST['image'];
  
  if($_FILES['image']['name'] != NULL){
  $fileName=$_FILES['image']['name'];
  $fileTempt=$_FILES['image']['tmp_name'];
  $folder='../trangchu/foods/stall'.$row_p->id_stall.'/';
  $name=$fileName;
  $ext=substr($name,strlen($name)-3,3);
  $ext1=substr($name,strlen($name)-4,4);
  $src = 'stall'.$row_p->id_stall.'/'.$fileName;
  if($ext=="JPG"||$ext=="jpg"||$ext1=="JPEG"||$ext1=="jpeg"||$ext=="GIF"||$ext=="gif"||$ext=="BMP"||$ext=="bmp"||$ext=="PNG"||$ext=="png"){
    move_uploaded_file($fileTempt, $folder.$name);
  }else{
    $alert=1;
  }
  
  $query ="UPDATE dishes SET name = '$name_n', sale_off = $saleoff, type = '$type', price =$price, image ='$src' WHERE id = '$dish_id'";
  }
  else{
    $query ="UPDATE dishes SET name = '$name_n', sale_off = $saleoff, type = '$type', price =$price WHERE id = '$dish_id'";

  }
  
  $result1 = pg_query($db_connection, $query);
    echo"<script>alert('Successfully uploaded!')</script>";
      
     
   
    $row1 = pg_fetch_object($result1);
   
}
$sql = "SELECT * FROM dishes WHERE id = '$dish_id'";

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
            <input type="text" placeholder="Enter dish's name" name ="name_n" value="<?php  echo"$row->name"; ?>" required>
          </div>
          <div class="input-box">
            <span class="details">Type</span>
            <input type="text" placeholder="Enter dish's type"  name="type"value="<?php  echo"$row->type"; ?>" required>
          </div>
                
             
          <div class="input-box">
            <span class="details">Sale off</span>
            <input type="number" placeholder="Enter dish's saleoff"  name ="saleoff" value="<?php  echo $row->sale_off; ?>" required>
          </div>

     
          <div class="input-box">
            <span class="details" id="totalAmt">price</span>
            <input type="number" placeholder="Enter dish's price" name ="price" value="<?php  echo"$row->price"; ?>"required>
          </div>
        
          <div class="input-box">
            <span class="details">Image</span>
            <input type="file"  name="image" value="<?php  echo"$row->image"; ?>" >
          </div>
         
        </div>
        <div class="button">
          <input type="submit" name= "capnhap" value="Cập nhật">
        </div>
        <div class="signup-link"><a href="admin_update_dishes.php">Quay lại trang chủ</a></div>
      </form>
    </div>
  </div>

</body>
</html>