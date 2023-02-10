<?php
header('Content-Type: text/html; charset=utf-8');
// Kết nối cơ sở dữ liệu
include "connect_database/connect_db"
// Dùng isset để kiểm tra Form
if(isset($_POST['dangky']))
{
	$usernamedk = trim($_POST['username']);
	$passwordk = trim($_POST['password']);
	$ten_tkdk = trim($_POST['ten_tk']);
	$sdtdk = trim($_POST['sdt']);
	$confirm =trim($_POST['confirm_password']);
 if($passwordk!=$confirm){
echo '<script language="javascript">alert("Mật khẩu không trùng!"); window.location="register.php";</script>';
die ();
}


// Kiểm tra username hoặc ten_tk có bị trùng hay không
	$query = "SELECT * FROM public.users WHERE username = '$usernamedk' OR name = '$ten_tkdk' ";

// Thực thi câu truy vấn
	$result = pg_query($db_connection, $query) ;

// Nếu kết quả trả về lớn hơn 1 thì nghĩa là username hoặc ten_tk đã tồn tại trong CSDL
	if (pg_num_rows($result) > 0)
	{
		echo '<script language="javascript">alert("Bị trùng tên hoặc chưa nhập tên!"); window.location="register.php";</script>';

// Dừng chương trình
		die ();
	}

	else {
		$avatar_auto='../images/avatar.jpg';
		$sql = "INSERT INTO public.users (username, password, name, telephone_num,avatar) VALUES ('$usernamedk', '$passwordk', '$ten_tkdk', '$sdtdk','$avatar_auto')";
		$resultdangky = pg_query($db_connection, $sql) ;
		// var_dump($sql);
		
		echo '<script language="javascript">alert("Đăng ký thành công!");</script>';
          echo ' <meta http-equiv="refresh" content="0;url=../login/login.php">';

	}
}
?>