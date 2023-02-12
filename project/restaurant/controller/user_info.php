<!-- 
    Query user's info
-->
<?php 
$db_connection = pg_connect("host=localhost dbname=postgres user=postgres password=postgres");
$query_user = "SELECT * FROM public.users WHERE username = $1";
$result = pg_prepare($db_connection, "query_user", $query_user);

if (isset($_SESSION['dangnhap'])){
    $user = pg_execute($db_connection,"query_user", array($_SESSION['username']));
    if (pg_num_rows($user) == 0) die();
    $user_row = pg_fetch_array($user);
    $_SESSION['favorite_list'] = json_decode('[' . substr($user_row['favorite_list'], 1, -1) . ']');
    $_SESSION['follow_stall'] = json_decode('[' . substr($user_row['follow_stall'], 1, -1) . ']');
}
?>