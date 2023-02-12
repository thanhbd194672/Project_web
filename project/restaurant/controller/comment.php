<?php 
session_start();


function isBadWord($text)
{
    //First we list the bad words in array
    $badwords = array('truck','fuck','cút','đm','còn cái nịt','web chán v','shit','có con cặc');
    //Then we perform the bad word check
    foreach($badwords as $badwords){
        if(stristr($text, $badwords)) return true;
    }
    return false;
}

$db_connection = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");

$query_follow = "UPDATE users SET follow_stall = array_append(follow_stall, $1) WHERE username = $2";
$query_unfollow = "UPDATE users SET follow_stall = array_remove(follow_stall, $1) WHERE username = $2";
$query_like = "UPDATE users SET favorite_list = array_append(favorite_list, $1) WHERE username = $2";
$query_unlike = "UPDATE users SET favorite_list = array_remove(favorite_list, $1) WHERE username = $2";
$query_comment = "INSERT INTO comment (username, id_stall, content, star, time, like_cmt) VALUES($1, $2, $3, $4, to_timestamp($5, 'YYYY/MM/DD HH24:MI:SS'), $6)";

$result0 = pg_prepare($db_connection, "query_follow", $query_follow);
$result1 = pg_prepare($db_connection, "query_unfollow", $query_unfollow);
$result2 = pg_prepare($db_connection, "query_like", $query_like);
$result3 = pg_prepare($db_connection, "query_unlike", $query_unlike);
$result4 = pg_prepare($db_connection, "insert_comment", $query_comment);

$action = $_REQUEST["action"];
$value = $_REQUEST["value"];
if(!isset($_SESSION['dangnhap'])){
    echo "fail";
    die();
}

if ($action == "follow") {
    $stall_id = $_REQUEST["stall_id"];
    if($value == 1) {
        $follow = pg_execute($db_connection, "query_follow", array($stall_id, $_SESSION['username']));
        $status = pg_result_status($follow);
        if ($status != PGSQL_COMMAND_OK) echo "fail";
    } else {
        $query_unfollow = pg_execute($db_connection, "query_unfollow", array($stall_id, $_SESSION['username']));
        $status = pg_result_status($query_unfollow);
        if ($status != PGSQL_COMMAND_OK) echo "fail";
    }
    echo "success";
}
if ($action == "like") {
    $item_id = $_REQUEST["item_id"];
    if($value == 1) {
        $like = pg_execute($db_connection, "query_like", array($item_id, $_SESSION['username']));
        $status = pg_result_status($like);
        if ($status != PGSQL_COMMAND_OK) echo "fail";
    } else {
        $query_unlike = pg_execute($db_connection, "query_unlike", array($item_id, $_SESSION['username']));
        $status = pg_result_status($query_unlike);
        if ($status != PGSQL_COMMAND_OK) echo "fail";
    }
    echo "success";

}
if ($action == "comment") {
    $stall_id = $_REQUEST["stall_id"];
    $star = $_REQUEST['star'];
    if (isBadWord($value)) {
        echo "fail";
        die();
    }
    $dt = new DateTime();
    $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
    $current_time = $dt->format('Y/m/d H:i:s');
    $like = pg_execute($db_connection, "insert_comment", array($_SESSION['username'], $stall_id, $value, $star, $current_time ,0));
    $status = pg_result_status($like);
    if ($status != PGSQL_COMMAND_OK) echo "fail";
    echo "success";
}

?>