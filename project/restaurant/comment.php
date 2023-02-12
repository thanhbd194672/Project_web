
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="css/comment.css">
</head>

<body class="commentpost">
	<div class="comment-session" style="display:none">
		<?php if(isset($_SESSION['dangnhap'])){ ?>
		<div class="comment-box">
			<ul id="form-messages"></ul>
			<div class="user">
				<div class="image"><img src="<?php echo $_SESSION['img'] ?>" alt=""></div>
				<div class="name"><?php echo $_SESSION['dangnhap'] ?></div>
			</div>
			<form method="post">
				<textarea name="comment" cols="30" rows="10" placeholder="Your Feedback" id="commentcheck" spellcheck="false"></textarea>
                 <span style="color: black;">Đánh giá nhà hàng: </span>
                 <select id="danhgia" require>
                    <option value="0"> </option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5" selected>5</option>
                </select>
                <span style="color: orange;"><i class = "fas fa-star"></i> </span>
				 <button type="submit" id="btn-submit">Comment</button>
			</form>
<script>
        const form = {
            comment: document.getElementById('commentcheck'),
            danhgia: document.getElementById('danhgia'),
            submit: document.getElementById('btn-submit'),
            messages: document.getElementById('form-messages')
        };

        form.submit.addEventListener('click', (event) => {
            event.preventDefault();
            const request = new XMLHttpRequest();
            request.onload = () => {
                if (request.readyState == 4 && request.status == 200 && request.responseText == "success") {
                    location.href = 'restaurant.php?stall=<?php echo $_REQUEST["stall"];?>';
                } else {
                    alert("Bad comment!");
                }
            };
            const requestData = `action=comment&stall_id=<?php echo $_REQUEST["stall"];?>&value=${form.comment.value}&star=${form.danhgia.value}`;
            request.open('post', 'controller/comment.php');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(requestData);
        });

</script>
		</div>
	<?php } ?>
	</div>
</body>
 
</html>