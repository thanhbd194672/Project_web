 <!--header</!-->
          <?php include "../topbar/topbar.php" ?>
          <!--end of header</!-->
      <!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="UTF-8" />
          <meta http-equiv="X-UA-Compatible" content="IE=edge" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>HNFOOD</title>
          <!-- CSS -->
          <link rel="stylesheet" href="css/profile.css" />
          <link href="css/profile.css?t=[timestamp]" type="text/css" rel="stylesheet">
          <!-- Unicons CSS -->
          <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
          <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
          <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
          <script src="js/profile.js" defer></script>
        </head>
         
  <body >
          <?php  
                include "../connect_database/connect_db.php";       
              $username = $_SESSION['username'];
              
              $query = "SELECT * FROM public.users WHERE username = '$username' ";
              $result = pg_query($db_connection, $query) ;
              $row = pg_fetch_object($result);
              // stall
              $follow_stall = $row->follow_stall;
              $follow_stall = chop($follow_stall , $follow_stall[strlen($follow_stall) - 1]);
              $follow_stall = ltrim($follow_stall , $follow_stall[0]);
              $stall_list = explode(",",$follow_stall);
              // dish
              $favorite_list = $row->favorite_list;
              $favorite_list = chop($favorite_list , $favorite_list[strlen($favorite_list) - 1]);
              $favorite_list = ltrim($favorite_list , $favorite_list[0]);
              $dish_list = explode(",",$favorite_list);
              
              
          ?>
         
    <div class="container">
      <!-- profile -->
        <div class="box">
          <div class="image">
            <img src="<?php echo $_SESSION['img'] ?>">
            </div>
            <div class="name_job"><?php echo strtoupper($row->name);
            ?></div>
            
            <p>E-MAIL: <?php echo strtoupper($row->username) ;
            ?></p>
            <p>Liên lạc: <?php echo $row->telephone_num ?></p>
            <p>Địa chỉ: <?php echo $row->address ?></p>
            <div class="btns">
              <a href="../userinfoupdate/userinfo.php"><button> Chỉnh sửa </button></a>
          </div>
        </div>
      </div>  
      <!-- end of profile -->

      <!-- menu -->
      <div class="container">
        <div class="menu">
            <div class = "menu-container">
                <div class = "menu-btns">
                  <button type = "button" class = "menu-btn active-btn" id = "stall">Cửa hàng yêu thích</button>
                  <button type = "button" class = "menu-btn" id = "dish">Món ăn yêu thích</button>
                </div>
              
              <!-- favorite stall -->
              <div class = "food-items">
                  <!-- item -->
                    <?php 
                      for($count = 0 ; $count < sizeof($stall_list) ; $count++)
                      {
                        $stall_query = "SELECT name , address[1] , time_o , time_c , telephone_num[1], image FROM public.stalls WHERE stalls.id =" . $stall_list[$count] ;
                        $stall = pg_query($db_connection, $stall_query);
                        $row_1 = pg_fetch_object($stall);
                    ?>
                    <div class = "food-item stall ">
                      <div class = "food-img">
                        <img src = "<?php echo '../trangchu/stalls/'.$row_1->image?>" alt = "food image">
                      </div>
                      <div class = "food-content">
                        <h2 class = "food-name"><?php echo $row_1->name; ?></h2>
                        <h3 class = "time">Mở cửa :<?php echo " ".$row_1->time_o ." - ". $row_1->time_c; ?></h3>
                        <div class = "line"></div>
                        <h3 class = "dia_chi"><?php echo $row_1->address?></h3>

                        <strong class = "category"><?php echo "Liên lạc : " . $row_1->telephone_num?></strong>
                        <!-- <p class = "food-loai">Loại: <span>Phở</span></p> -->
                      <a href=" <?php echo '../restaurant/restaurant.php?stall='.$stall_list[$count]?>" class="chi_tiet">Chi tiết</a>

                      </div>
                    </div>
                    <?php
                      }
                    ?>
                    <!-- end of item -->
              </div>

              <!-- end of favorite dish -->
              
              <!-- favorite dish -->
              <div class = "food-items">
                  <?php 
                    for($count = 0 ; $count < sizeof($dish_list) ; $count++)
                    {
                      $dish_query = "SELECT dishes.*,stalls.address[1], stalls.name as name2 FROM public.dishes join stalls on (stalls.id = dishes.id_stall) WHERE dishes.id =" . $dish_list[$count] ;
                      $dish = pg_query($db_connection, $dish_query);
                      $row_2 = pg_fetch_object($dish);
                  ?>
                  <div class="food-item dish">
                    <div class = "food-img">
                      <img src = "<?php echo '../trangchu/foods/'.$row_2->image?>" alt = "food image">
                    </div>
                    <div class = "food-content">
                      <h2 class = "food-name"><?php echo $row_2->name; ?></h2>
                      <h3 class = "food-price"><?php echo $row_2->name2 ; ?></h3>
                      <h3 class = "dia_chi"><?php echo $row_2->address; ?></h3>
                      <h3 class = "food-price"><?php echo $row_2->price . " đồng"; ?></h3>
                      <p class = "sale">Sale: <span><?php echo $row_2->sale_off . "%"; ?></span></p> 
                      <a href=" <?php echo '../restaurant/restaurant.php?stall='.$row_2->id_stall ?>" class="chi_tiet">Chi tiết</a>
                    </div>
                  </div>
                  <?php } ?>
              </div>
              <!-- end of favorite dish -->

            
          </div>
        </div> 
      </div>



      <body>
          </html>
          
       <!-- footer-->
          <?php include "../footer/footer.php" ?>

 <!-- end of footer -->
