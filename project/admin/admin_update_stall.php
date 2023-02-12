
<!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="UTF-8" />
          <meta http-equiv="X-UA-Compatible" content="IE=edge" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>HNFOOD</title>
          <!-- CSS -->
          <link rel="stylesheet" href="css/style.css?t=[timestamp]" type="text/css" />
          <!-- Unicons CSS -->
          <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
          <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
          <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
          <script src="js/script.js" defer></script>
          <style>
          #pagination{
                text-align: right;
                margin-top: 15px;
                margin-bottom:15px ;
            }
            .page-item{
                border: 1px solid #ccc;
                padding: 5px 9px;
                color: white;
            }
            .current-page{
                background: #000;
                color: white;
            }
        </style>
<style>

            #pagination{
                text-align: right;
                margin-top: 15px;
                margin-bottom:15px ;
            }
            .page-item{
                border: 1px solid #ccc;
                padding: 5px 9px;
                color: white;
            }
            .current-page{
                background: #000;
                color: white;
            }
        </style>
        </head>
        <body>
          <!--header</!-->
          <?php include "../topbar/topbar.php" ?>
          <!--end of header</!-->

      <section class = "menu">
        <div class = "menu-container">
         
          <div class = "food-items">
          <?php  
          include "../connect_database/connect_db.php";  
          $item_per_page =!empty($_GET['per_page'])?$_GET['per_page']:6;
          $current_page =!empty($_GET['page'])?$_GET['page']:1;
          $offset =($current_page-1)*$item_per_page;
          
          
          $query_all = "SELECT * FROM  stalls";
          $show= pg_query($db_connection,$query_all);
          while($row_ = pg_fetch_array($show)){
          $q_address = "SELECT address_c from public.stalls, unnest (stalls.address) as address_c where stalls.id = ".$row_['id']." ;";
          $address = pg_query($db_connection,$q_address);
          
?>
          
            <!-- item -->
            <div class = "food-item featured ">
              <div class = "food-img">
                <img src = "<?php echo '../trangchu/stalls/'.$row_['image']?>" alt = "food image">
              </div>
              <div class = "food-content">
                <h2 class = "food-name"><?php echo $row_['name']; ?></h2>
                <div class = "line"></div>
                <?php while($adr = pg_fetch_array($address)){ ?>
                <h3 class = "dia_chi"><?php echo $adr['address_c']?></h3>
             <?php } ?>
               
             <a href=" <?php echo '/PJ_Web/Project_web/project/admin/form_change_info.php?stall='.$row_['id'] ?>" class="chi_tiet">Sửa</a>
              </div>
            </div>
            <!-- end of item -->
<?php } ?>
           
          </div>
        </div>
      </section>
      <?php include "pagination.php" ?>
       <!-- footer-->
          <?php include "../footer/footer.php" ?>

 <!-- end of footer -->
    </body>
  </html>
