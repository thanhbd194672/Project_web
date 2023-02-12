
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="css/style.css">
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
 <?php include "../topbar/topbar.php" ?>
 <?php 
      include "../connect_database/connect_db.php";  
          $item_per_page =!empty($_GET['per_page'])?$_GET['per_page']:6;
          $current_page =!empty($_GET['page'])?$_GET['page']:1;
          $offset = ($current_page-1) * $item_per_page;
      //chưa có bảng feedback nên thử user
      $query = "SELECT * FROM public.feedback limit ".$item_per_page." offset ".$offset ;
      $query1 = "SELECT * FROM public.feedback";
	  $result = pg_query($db_connection, $query) ;
      $result1 = pg_query($db_connection, $query1) ;
      $result1 =pg_num_rows($result1);
      $totalpagesaleoff = ceil($result1 / $item_per_page);

 ?>

<body class="commentpost">
	<div class="comment-session">
		<?php while($row = pg_fetch_array($result)){?>
		<div class="post-comment">
			<div class="list">
				<div class="user">
					<div class="image"><img src="<?php echo $row['avatar']; ?>" alt="image"></div>
						<div class="user-meta">
							<div class="name"><?php echo $row['name']; ?></div>
							<?php if(isset($row['star'])) {?>
							<div class="day"> Đánh giá web: <?php echo $row['star']; ?> <i class = "fas fa-star" style="color: orange;"></i></div>
						<?php }else{ ?>
							<div class="day"> Chưa đánh giá web</div>
						<?php } ?>
						</div>
				</div>
				
				<div class="comment-post"><?php echo $row['comment']; ?> </div>
			</div>
		</div>
	<?php } ?>
		<?php if(isset($_SESSION['dangnhap'])&&$_SESSION['dangnhap'] != '$admin'){ ?>
		<div class="comment-box">
			<ul id="form-messages"></ul>
			<div class="user">
				<div class="image"><img src="<?php echo $_SESSION['img'] ?>" alt=""></div>
				<div class="name"><?php echo $_SESSION['dangnhap'] ?></div>
			</div>
			<form method="post">
				<textarea name="comment" cols="30" rows="10" placeholder="Your Feedback" id="commentcheck" spellcheck="false"></textarea>
                 <span style="color: black;">Đánh giá web: </span>
                 <select id="danhgia">
                    <option value="0"> </option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <span style="color: orange;"><i class = "fas fa-star"></i> </span>
				 <button type="submit" id="btn-submit">Feedback</button>
			</form>
<script>
        const form = {
            comment: document.getElementById('commentcheck'),
            danhgia: document.getElementById('danhgia'),
            submit: document.getElementById('btn-submit'),
            messages: document.getElementById('form-messages')
        };

        form.submit.addEventListener('click', () => {
            const request = new XMLHttpRequest();
            request.onload = () => {
                let responseObject = null;

                try {
                    responseObject = JSON.parse(request.responseText);
                } catch (e) {
                    console.error('Could not parse JSON!');
                }

                if (responseObject) {
                    handleResponse(responseObject);
                }
            };

            const requestData = `comment=${form.comment.value}&danhgia=${form.danhgia.value}`;

            request.open('post', 'check.php');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(requestData);
        });

        function handleResponse (responseObject) {
            if (responseObject.ok) {
                location.href = 'feedback.php';

            } else {
                while (form.messages.firstChild) {
                    form.messages.removeChild(form.messages.firstChild);
                }
                responseObject.messages.forEach((message) => {
                    alert(message);             
                });  
            }
        }
    </script>
		</div>

	<?php } ?>
    <?php include "pagination.php" ?>
	</div>
	 <?php include "../footer/footer.php" ?>
</body>
 
</html>