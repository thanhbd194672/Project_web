<?php 

   include "../connect_database/connect_db.php";  
   session_start();
 
  
    if (isset($_POST['capnhap'])) {
 
  echo '<script language="javascript">alert("Successfully uploaded!!"); window.location="admin_update_dishes.php";</script>';
  $id_quan = intval($_POST['name_stall']);
  $name_n = $_POST['name_n'];
  $type = $_POST['type'];
  $saleoff = $_POST['saleoff'];
  $price = $_POST['price'];
  $image = $_POST['image'];
  
    $fileName=$_FILES['image']['name'];
    $fileTempt=$_FILES['image']['tmp_name'];
    $folder='../trangchu/foods/stall'.$_POST['name_stall'].'/';
    $name=$fileName;
    $ext=substr($name,strlen($name)-3,3);
    $ext1=substr($name,strlen($name)-4,4);
    $src = 'stall'.$_POST['name_stall'].'/'.$fileName;
    if($ext=="JPG"||$ext=="jpg"||$ext1=="JPEG"||$ext1=="jpeg"||$ext=="GIF"||$ext=="gif"||$ext=="BMP"||$ext=="bmp"||$ext=="PNG"||$ext=="png"){
      move_uploaded_file($fileTempt, $folder.$name);
    }else{
      $alert=1;
    }
  
  $query ="INSERT INTO public.dishes(id_stall,name, type, sale_off, price,image) VALUES ($id_quan,'$name_n', '$type',$saleoff, $price,'$src');";
 
  

  
  $result1 = pg_query($db_connection, $query);
    echo"<script>alert('Successfully uploaded!')</script>";
      
     
  
    $row1 = pg_fetch_object($result1);
   
}
  $sql_s = "SELECT stalls.name,stalls.id FROM stalls ";
  $result_s = pg_query($db_connection, $sql_s) ;
$i = 0;
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
    <div class="title">Cập nhật món ăn</div>
    <div class="content">
      <form method="POST" enctype="multipart/form-data">
        <div class="user-details">

        <div class="input-box">
            <span class="details">Stall</span>
            <select class= "details" name = "name_stall">
                <?php while($row_s = pg_fetch_object($result_s)) { ?>
                    <option value="<?php echo $row_s->id ?>"><?php echo $row_s->name ?></option>
                <?php } ?>
            </select>
          </div>


          <div class="input-box">
            <span class="details">Name</span>
            <input type="text" placeholder="Enter dish's name" name ="name_n"  required>
          </div>
          <div class="input-box">
            <span class="details">Type</span>
            <input type="text" placeholder="Enter dish's type"  name="type" required>
          </div>
                
             
          <div class="input-box">
            <span class="details">Sale off</span>
            <input type="number" placeholder="Enter dish's saleoff"  name ="saleoff"  required>
          </div>

     
          <div class="input-box">
            <span class="details" id="totalAmt">price</span>
            <input type="number" placeholder="Enter dish's price" name ="price"required>
          </div>
        
          
          <div class="input-box">
            <span class="details">Image</span>
            <input type="file"  name="image"  required>
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