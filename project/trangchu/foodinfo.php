
      <!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="UTF-8" />
          <meta http-equiv="X-UA-Compatible" content="IE=edge" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>HNFOOD</title>
          <!-- CSS -->
          <link rel="stylesheet" href="css/style.css" />
          <!-- Unicons CSS -->
          <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
          <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
          <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
          <script src="js/script.js" defer></script>
        </head>
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
        <body>
          <!--header</!-->
          <?php include "../topbar/topbar.php" ?>
          <!--end of header</!-->

  <section class = "menu">
        <div class = "menu-container">
          <div class = "menu-btns">
            <button type = "button" class = "menu-btn active-btn" id = "all">Tất cả</button>
            <button type = "button" class = "menu-btn" id = "featured">Sale</button>
            <button type = "button" class = "menu-btn" id = "do_an">Đồ ăn</button>
            <button type = "button" class = "menu-btn" id = "do_uong">Đồ uống</button>
            <button type = "button" class = "menu-btn" id = "banh_kem">Bánh ngọt</button>
            <button type = "button" class = "menu-btn" id = "an_vat">Ăn vặt</button>
            <button type = "button" class = "menu-btn" id = "do_trang_mieng">Đồ tráng miệng</button>  
          </div>
          <div class = "food-items">
          <?php  
          $db_connection =pg_connect("host=localhost dbname=postgres user=postgres password=postgres");

          $item_per_page =!empty($_GET['per_page'])?$_GET['per_page']:6;
          $current_page =!empty($_GET['page'])?$_GET['page']:1;
          $offset =($current_page-1)*$item_per_page;


          $doan = 'Đồ ăn';
          $douong = 'Đồ uống';
          $banhngot = 'Bánh ngọt';
          $anvat = 'Đồ ăn vặt';
          $dotrangmieng = 'Đồ tráng miệng';
          
        
          
          $safeoff = "SELECT * FROM public.dishes WHERE dishes.sale_off > 0 order by dishes.sale_off desc limit ".$item_per_page." offset ".$offset ;
          $safeoffnum = pg_query($db_connection,"SELECT * FROM public.dishes WHERE type = '$doan'") ;
          $safeoffnum =pg_num_rows($safeoffnum);
          $totalpagesaleoff = ceil($safeoffnum / $item_per_page);


          $query_all = "SELECT * FROM public.dishes order by dishes.sale_off desc limit ".$item_per_page." offset ".$offset ;
          $query_doan = "SELECT * FROM public.dishes WHERE type = '$doan' order by dishes.sale_off desc limit ".$item_per_page." offset ".$offset ;
          $query_douong = "SELECT * FROM public.dishes WHERE type = '$douong'  order by dishes.sale_off desc limit ".$item_per_page." offset ".$offset ;
          $query_banhngot = "SELECT * FROM public.dishes WHERE type = '$banhngot' order by dishes.sale_off desc limit ".$item_per_page." offset ".$offset ;
          $query_anvat = "SELECT * FROM public.dishes WHERE type = '$anvat' order by dishes.sale_off desc limit ".$item_per_page." offset ".$offset ;
          $query_dotrangmieng = "SELECT * FROM public.dishes WHERE type = '$dotrangmieng' order by dishes.sale_off desc limit ".$item_per_page." offset ".$offset ;
         
          $show= pg_query($db_connection,$query_all);
          $showdoan = pg_query($db_connection,$query_doan);
          $showdouong = pg_query($db_connection,$query_douong);
          $showdobanhngot = pg_query($db_connection,$query_banhngot);
          $showanvat = pg_query($db_connection,$query_anvat);
          $showdotrangmieng = pg_query($db_connection,$query_dotrangmieng);
         
          $showsafeoff = pg_query($db_connection,$safeoff);
         
          while($row_ = pg_fetch_array($showsafeoff)){
?>
          
            <!-- item -->
            <div class = "food-item featured ">
              <div class = "food-img">
                <img src = "<?php echo 'foods/'.$row_['image']?>" alt = "food image">
              </div>
              <div class = "food-content">
                <h2 class = "food-name"><?php echo $row_['name']; ?></h2>

                <div class = "line"></div>
                <h3 class = "dia_chi">606/52 Đường 3 Tháng 1, P. 14, Quận 10, TP. HCM</h3>
                 <!-- <p class = "food-loai">Loại: <span>Phở</span></p> -->
                <h3 class = "food-price"><?php echo $row_['price'] . " đồng"; ?></h3>
                <ul class = "rating">
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "far fa-star"></i></li>
                </ul>
                <p class = "sale">Sale: <span><?php echo $row_['sale_off'] . "%"; ?></span></p> 
                <a href=" <?php echo '/Project_web/project/restaurant/restaurant.php?stall='.$row_['id_stall'] ?>" class="chi_tiet">Chi tiết</a>

              </div>
            </div>
            <!-- end of item -->
<?php } 

          while($row_1 = pg_fetch_array($showdoan)){
?>
          
            <!-- item -->
            <div class = "food-item do_an">
              <div class = "food-img">
                <img src = "<?php echo 'foods/'.$row_1['image']; ?>" alt = "food image">
              </div>
              <div class = "food-content">
                <h2 class = "food-name"><?php echo $row_1['name']; ?></h2>

                <div class = "line"></div>
                <h3 class = "dia_chi">606/52 Đường 3 Tháng 1, P. 14, Quận 10, TP. HCM</h3>
                 <!-- <p class = "food-loai">Loại: <span>Phở</span></p> -->
                <h3 class = "food-price"><?php echo $row_1['price'] . " đồng"; ?></h3>
                <ul class = "rating">
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "far fa-star"></i></li>
                </ul>
                
              <button class="chi_tiet">Chi tiết</button>
              <a href=" <?php echo '/Project_web/project/restaurant/restaurant.php?stall='.$row_1['id_stall'] ?>" class="chi_tiet">Chi tiết</a>
              </div>
            </div>
            <!-- end of item -->
<?php } ?>

           <?php while($row_2 = pg_fetch_array($show)){  ?>
            <!-- item -->
            <div class = "food-item all">
              <div class = "food-img">
                <img src = "<?php echo 'foods/'.$row_2['image']; ?>" alt = "food image">
              </div>
              <div class = "food-content">
                <h2 class = "food-name"><?php echo $row_2['name']; ?></h2>
                <div class = "line"></div>
                <h3 class = "dia_chi">606/52 Đường 3 Tháng 1, P. 14, Quận 10, TP. HCM</h3>
                <h3 class = "food-price"><?php echo $row_2['price'] . " đồng"; ?></h3>
                <ul class = "rating">
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "far fa-star"></i></li>
                </ul>
                
              <p class = "sale">Sale: <span><?php echo $row_2['sale_off'] . "%"; ?></span></p> 
                
              <a href=" <?php echo '/Project_web/project/restaurant/restaurant.php?stall='.$row_2['id_stall'] ?>" class="chi_tiet">Chi tiết</a>
          
              </div>
            </div>
            <!-- end of item -->
<?php } ?>

            <!-- item -->
           <?php while($row_3 = pg_fetch_array($showdobanhngot)){ ?>

            <div class = "food-item banh_kem">
              <div class = "food-img">
                <img src = "<?php echo 'foods/'.$row_3['image'] ; ?>" alt = "food image">
              </div>
              <div class = "food-content">
                <h2 class = "food-name"><?php echo $row_3['name'] ; ?></h2>
                <div class = "line"></div>
                <h3 class = "dia_chi">606/52 Đường 3 Tháng 2, P. 14, Quận 10, TP. HCM</h3>
                 <p class = "food-loai">Loại: <span>Phở</span></p>
                <h3 class = "food-price"><?php echo $row_3['price'] . " đồng"; ?></h3>
                <ul class = "rating">
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "far fa-star"></i></li>
                  <li><i class = "far fa-star"></i></li>

                </ul>
              <p class = "sale">Sale: <span><?php echo $row_3['sale_off'] . "%"; ?></span></p> 
                
              <a href=" <?php echo '/Project_web/project/restaurant/restaurant.php?stall='.$row_3['id_stall'] ?>" class="chi_tiet">Chi tiết</a>

              </div>
            </div>
            <!-- end of item -->
<?php } ?>
            <!-- item -->
           <?php while($row_4 = pg_fetch_array($showanvat)){ ?>

            <div class = "food-item an_vat">
              <div class = "food-img">
                <img src = "<?php echo 'foods/'.$row_4['image'] ; ?>" alt = "food image">
              </div>
              <div class = "food-content">
                <h2 class = "food-name"><?php echo $row_4['name'] ; ?></h2>
                <div class = "line"></div>
                <h3 class = "dia_chi">606/52 Đường 3 Tháng 2, P. 14, Quận 10, TP. HCM</h3>
                <h3 class = "food-price"><?php echo $row_4['price'] . " đồng"; ?></h3>
                <ul class = "rating">
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "far fa-star"></i></li>
                </ul>
              <p class = "sale">Sale: <span><?php echo $row_4['sale_off'] . "%"; ?></span></p> 
                
              <a href=" <?php echo '/Project_web/project/restaurant/restaurant.php?stall='.$row_4['id_stall'] ?>" class="chi_tiet">Chi tiết</a>
                
              </div>
            </div>
            <!-- end of item -->
<?php } ?>
           
            
            <!-- item -->
           <?php while($row_7 = pg_fetch_array($showdouong)){ ?>

            <div class = "food-item do_uong">
              <div class = "food-img">
                <img src = "<?php echo 'foods/'.$row_7['image']; ?>" alt = "food image">
              </div>
              <div class = "food-content">
                 <h2 class = "food-name"><?php echo $row_7['name'] ; ?></h2>
                <div class = "line"></div>
                <h3 class = "dia_chi">606/52 Đường 3 Tháng 2, P. 14, Quận 10, TP. HCM</h3>
                <h3 class = "food-price"><?php echo $row_7['price'] . " đồng"; ?></h3>
                <ul class = "rating">
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "far fa-star"></i></li>
                </ul>
              <p class = "sale">Sale: <span><?php echo $row_7['sale_off'] . "%"; ?></span></p> 
              <a href=" <?php echo '/Project_web/project/restaurant/restaurant.php?stall='.$row_7['id_stall'] ?>" class="chi_tiet">Chi tiết</a>

              </div>
            </div>
            <!-- end of item -->
<?php } ?>
            <!-- item -->
           <?php while($row_8 = pg_fetch_array($showdotrangmieng)){ ?>

            <div class = "food-item do_trang_mieng">
              <div class = "food-img">
                <img src = "<?php echo 'foods/'.$row_8['image'] ; ?>" alt = "food image">
              </div>
              <div class = "food-content">
                <h2 class = "food-name"><?php echo $row_8['name'] ; ?></h2>
                <div class = "line"></div>
                <h3 class = "dia_chi">606/52 Đường 3 Tháng 2, P. 14, Quận 10, TP. HCM</h3>
        
                <h3 class = "food-price"><?php echo $row_8['price'] . " đồng"; ?></h3>
                <ul class = "rating">
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "fas fa-star"></i></li>
                  <li><i class = "far fa-star"></i></li>
                </ul>
              <p class = "sale">Sale: <span><?php echo $row_8['sale_off'] . "%"; ?></span></p> 
                
              <a href=" <?php echo '/Project_web/project/restaurant/restaurant.php?stall='.$row_8['id_stall'] ?>" class="chi_tiet">Chi tiết</a>

              </div>
            </div>
            <!-- end of item -->
<?php } ?>
            <!-- item -->
           
          </div>
        </div>
      </section>
      <?php include "pagination.php" ?>
       <!-- footer-->
          <?php include "../footer/footer.php" ?>

 <!-- end of footer -->
    </body>
  </html>