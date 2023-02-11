<?php
     session_start();
     include "../connect_database/connect_db.php";
function isBadWord($text)
{

//First we list the bad words in array
$badwords = array('truck','fuck','cút','đm','còn cái nịt','web chán v','shit','có con cặc');
//Then we perform the bad word check
foreach($badwords as $badwords)
{
if(stristr($text,$badwords))
{
return true;
}
}
return false;
}
    $comment = isset($_POST['comment']) ? $_POST['comment'] : ''; // lấy comment
    $danhgia = isset($_POST['danhgia']) ? $_POST['danhgia'] : ''; // lấy dánh giá
    $ok = true;
    $messages = array();

    if ( !isset($comment) || empty($comment) ) {
        $ok = false;
        $messages[] = 'bạn chưa feedback!';
    }
    else{ 
        $ok = false;
        $text = $_POST['comment'];
        if(isBadWord($text))
        {
             $messages[] = 'Feedback có badwords! Không thể Submit';
        }
        else
        {
            $ok = true;
            $messages[] = 'Successful login!';
            //cái này sẽ insert vào bảng feedback có dánh giá
            $username =$_SESSION['username'];
            $name = $_SESSION['dangnhap'];
            $avatar =$_SESSION['img'];
            if($danhgia=='0'){
            $sql = "INSERT INTO public.feedback (username, comment, name, avatar) VALUES ('$username', '$text', '$name','$avatar')";
        }else{
            $sql = "INSERT INTO public.feedback (username, comment, name,avatar, star) VALUES('$username', '$text', '$name','$avatar','$danhgia')";
        }
             $result = pg_query($db_connection, $sql) ;
        } 
    }
    echo json_encode(
        array(
            'ok' => $ok,
            'messages' => $messages
        )
    );

?>