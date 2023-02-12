
<!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="UTF-8" />
          <meta http-equiv="X-UA-Compatible" content="IE=edge" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>HNFOOD</title>
          <!-- CSS -->
          <link rel="stylesheet" href="css/restaurant.css" />
          <link rel="stylesheet" href="../trangchu/css/style.css" />
          <script src="https://kit.fontawesome.com/d805e5e97f.js" crossorigin="anonymous"></script>
          <script src="js/script.js" defer></script>
        </head>
        <body>
          <!--header</!-->
          <?php include "../topbar/topbar.php" ?>
          <?php include "controller/user_info.php" ?>
          <!--end of header</!-->
          <?php
            $queries = array();
            parse_str($_SERVER['QUERY_STRING'], $queries);

            if(isset($queries['stall'])){

              $stall_id = $queries['stall'];
              $db_connection =pg_connect("host=localhost dbname=postgres user=postgres password=postgres");

              $doan = 'Đồ ăn';
              $douong = 'Đồ uống';
              $banhngot = 'Bánh ngọt';
              $anvat = 'Đồ ăn vặt';
              $dotrangmieng = 'Đồ tráng miệng';
              
              $query_safeoff = "SELECT * FROM public.dishes WHERE dishes.sale_off > 0 and dishes.id_stall = $1 order by dishes.sale_off desc";
              $query_stall = "SELECT * FROM public.stalls WHERE stalls.id = $1";
              $query_all = "SELECT * FROM public.dishes WHERE dishes.id_stall = $1 order by dishes.sale_off desc" ;
              $query_doan = "SELECT * FROM public.dishes WHERE dishes.type = $1 and dishes.id_stall = $2 order by dishes.sale_off desc";
              $query_douong = "SELECT * FROM public.dishes WHERE dishes.type = $1 and dishes.id_stall = $2 order by dishes.sale_off desc";
              $query_banhngot = "SELECT * FROM public.dishes WHERE dishes.type = $1 and dishes.id_stall = $2 order by dishes.sale_off desc";
              $query_anvat = "SELECT * FROM public.dishes WHERE dishes.type = $1 and dishes.id_stall = $2 order by dishes.sale_off desc";
              $query_dotrangmieng = "SELECT * FROM public.dishes WHERE dishes.type = $1 and dishes.id_stall = $2 order by dishes.sale_off desc";
              $query_price = "SELECT min(dishes.price), max(dishes.price) FROM public.dishes WHERE dishes.id_stall = $1";
              $query_comment = "SELECT comment.*, users.name FROM comment, users WHERE comment.id_stall = $1 and users.username = comment.username";
              
              $result0 = pg_prepare($db_connection, "query_saleoff", $query_safeoff);
              $result1 = pg_prepare($db_connection, "query_stall", $query_stall);
              $result2 = pg_prepare($db_connection, "query_all", $query_all);
              $result3 = pg_prepare($db_connection, "query_doan", $query_doan);
              $result4 = pg_prepare($db_connection, "query_douong", $query_douong);
              $result5 = pg_prepare($db_connection, "query_banhngot", $query_banhngot);
              $result6 = pg_prepare($db_connection, "query_anvat", $query_anvat);
              $result7 = pg_prepare($db_connection, "query_dotrangmieng", $query_dotrangmieng);
              $result8 = pg_prepare($db_connection, "query_price", $query_price); 
              $result9 = pg_prepare($db_connection, "query_comment", $query_comment); 
              
              $showsafeoff = pg_execute($db_connection, "query_saleoff", array($stall_id));
              $stall= pg_execute($db_connection, "query_stall", array($stall_id));
              $show = pg_execute($db_connection, "query_all", array($stall_id));
              $showdoan = pg_execute($db_connection, "query_doan", array($doan, $stall_id));
              $showdouong = pg_execute($db_connection,"query_douong", array($douong, $stall_id));
              $showdobanhngot = pg_execute($db_connection, "query_banhngot", array($banhngot, $stall_id));
              $showanvat = pg_execute($db_connection, "query_anvat", array($anvat, $stall_id));
              $showdotrangmieng = pg_execute($db_connection,"query_dotrangmieng", array($dotrangmieng, $stall_id));
              $price_min_max = pg_execute($db_connection,"query_price", array($stall_id));
              $comments = pg_execute($db_connection,"query_comment", array($stall_id));
              
              $order = array("featured", "do_an", "all", "banh_kem", "an_vat", "do_uong", "do_trang_mieng");
              $list_to_show = array($showsafeoff, $showdoan, $show, $showdobanhngot, $showanvat, $showdouong, $showdotrangmieng);
              
              $stall_info = pg_fetch_array($stall);
          
              if(!$stall_info){
                include "./err_restaurant.php";
                exit(0);
              }

              $price_min_max_info = pg_fetch_array($price_min_max);
              if(!$price_min_max_info){
                include "./err_restaurant.php";
                exit(0);
              }
              ?>

<div class="restaurant-container">
      <div class="restaurant-floor">
        <div class="restaurant-res-container">
          <div class="restaurant-image">
            <img
              alt="image"
              src="<?php echo '../trangchu/stalls/'.$stall_info['image'] ?>"
            />
          </div>
          <div class="restaurant-info">
            <h1 class="restaurant-name"><?php echo $stall_info['name']?></h1>
            <div class="restaurant-address">
            <?php 
                $addresses = explode('","', substr($stall_info['address'], 2, -2));
                foreach ( $addresses as $value) {
                  echo $value;
                  break;
                }
              ?>
            </div>

            <div class="restaurant-rating">
              <div class="stars">
                <?php
                  $rating = round($stall_info['rating'] / 5, 1) * 5;
                  $star_count = 5;
                  while($rating > 0){
                    if($rating >= 1){
                      echo '<span class="full"><i class="fa-solid fa-star"></i></span>';
                    } else {
                      echo '<span class="half"><i class="fa-solid fa-star-half-stroke"></i></span>';
                    }
                    $rating -= 1;
                    $star_count -= 1;
                  }
                  while($star_count > 0){
                    echo '<span class="half"><i class="fa-regular fa-star"></i></span>';
                    $star_count -= 1;
                  }
                ?>
              </div>
              <div class="rate"><?php echo round($stall_info['rating'], 1);?></div>
              <div class="votes"><?php echo $stall_info['like_stall']?></div>
            </div>
            <div class="restaurant-time">
              <i class="fa-regular fa-clock" style="color: rgb(0 0 0);"></i>
              <?php echo substr($stall_info['time_o'], 0, -3)." - ".substr($stall_info['time_c'], 0, -3) ?></div>

            <div class="restaurant-price">
              <i class="fa-solid fa-dollar-sign" style="color: rgb(0 0 0);"></i>
              <?php echo $price_min_max_info[0]." - ".$price_min_max_info[1] ?> đ</div>
            
            <?php if(isset($_SESSION['dangnhap'])) {?>
            <div class="feedback">
              <button class="comment-button" id="comment-button">Bình luận</button>
              <button class="like-button">
                <?php 
                if(in_array($stall_id, $_SESSION['follow_stall']))
                { $to_follow = 0;
                  ?><i class="fa-solid fa-heart"></i> 
                <?php } else { $to_follow = 1; ?> <i class="fa-regular fa-heart"></i> <?php } ?>
              </button>
            </div>
            <?php } ?>
          </div>
        </div>

        <?php include "comment.php";?>

        <div class="restaurant-menu">
          <div class = "restaurant-menu-type">
            <div class = "menu-container-col">
              <div class = "menu-btns-col">
                <button type = "button" class = "menu-btn active-btn" id = "all">Tất cả</button> 
              <?php 
                if(pg_num_rows($showdoan) > 0) {?> 
                  <button type = "button" class = "menu-btn" id = "do_an">Đồ ăn</button>
                <?php
                }
              ?>

              <?php 
                if(pg_num_rows($showdouong) > 0) {?> 
                  <button type = "button" class = "menu-btn" id = "do_uong">Đồ uống</button>
                <?php
                }
              ?>

              <?php 
                if(pg_num_rows($showsafeoff) > 0) {?> 
                  <button type = "button" class = "menu-btn" id = "featured">Sale</button>
                <?php
                }
              ?>

              <?php 
                if(pg_num_rows($showdobanhngot) > 0) {?> 
                  <button type = "button" class = "menu-btn" id = "banh_kem">Bánh ngọt</button>
                <?php
                }
              ?>

              <?php 
                if(pg_num_rows($showdotrangmieng) > 0) {?> 
                  <button type = "button" class = "menu-btn" id = "do_trang_mieng">Đồ tráng miệng</button> 
                <?php
                }
              ?>

              <?php 
                if(pg_num_rows($showanvat) > 0) {?> 
                  <button type = "button" class = "menu-btn" id = "an_vat">Ăn vặt</button>
                <?php
                }
              ?>

                
              </div>
            </div>
          </div>

          <div class="restaurant-dish">
            <div class="search-dish-bar">
              <i class="fa-solid fa-magnifying-glass awesome-icon" style=""></i>
              <input
                type="text"
                placeholder="Tìm Món"
                name="Tim kiem"
                id="search-bar"
              />
            </div>
            <div class="restaurant-dish-list">
              
              <?php 
              $traverse = 0;
              $items_id = array();
              foreach($list_to_show as $show_one) {
                $type = $order[$traverse];
                $traverse++;
                while($row_ = pg_fetch_array($show_one)){
                  if($type == "all" && isset($_SESSION['dangnhap'])){
                    if(in_array($row_['id'], $_SESSION['favorite_list'])) $items_id[$row_['id']] = 1;
                    else $items_id[$row_['id']] = 0;
                  }
              ?>

              <div class="<?php echo 'dish '.$type ?>">
                <div class="dish-image">
                  <img
                    alt="image"
                    src= "<?php echo '../trangchu/foods/'.$row_['image']?> "
                  />   
                </div>
                
                <div class="dish-name">
                  <?php echo $row_['name']; ?>
                </div>
                <div class="dish-price">
                  <?php echo $row_['price']; ?> đ
                </div>
                <?php 
                if(isset($_SESSION['dangnhap'])) {?>
                <button class="dish-like <?php echo $row_['id'] ?>">
                  <?php if(!in_array($row_['id'], $_SESSION['favorite_list'])) {?> <i class="fa-regular fa-thumbs-up"></i>
                  <?php } else { ?> <i class="fa-sharp fa-solid fa-thumbs-up"></i>
                </button>
                <?php }}?>
              </div>

              <?php }}?>
            </div>
            
          </div>
          <!-- <div class="restaurant-comment"> -->
            <div class="comment-session">
		        <?php while($row = pg_fetch_array($comments)){?>
              <div class="post-comment">
                <div class="list">
                <div class="user">
                <!-- <div class="image"><img src="" alt="image"></div> -->
                <div class="user-meta">
                  <div class="name"><?php echo $row['name']; ?></div>
                  <?php if(isset($row['star'])) {?>
                    <div class="day"> Đánh giá: <?php echo $row['star']; ?> <i class = "fas fa-star" style="color: orange;"></i></div>
                    <?php } else { ?> <div class="day"> Chưa đánh giá</div> <?php } ?>
						    </div>
				        </div>
				        <div class="comment-post"><?php echo $row['content']; ?> </div>
			        </div>
		        </div> <?php } ?>

          <!-- </div> -->
        </div>
      </div>
  </div>
          <?php
            } else {
              include "./err_restaurant.php";
              exit(0);
            }

          ?>
  <script type="text/javascript" src="js/comment.js"></script>
  <script type="text/javascript">
    followButtonTrigger(<?php echo $to_follow?>, <?php echo $stall_id ?>);
    var favorite_array =  { <?php 
      foreach ($items_id as $indx => $value) {
        echo "{$indx} : $value, ";
      } ?>}
    likeButtonsTrigger(favorite_array);
  </script>
  
       <!-- footer-->
          <?php include "../footer/footer.php" ?>

 <!-- end of footer -->
    </body>
  </html>
