<?php
include("db.php");
session_start();

// if not log in
if (!isset($_SESSION['login_user'])) {
    header("Location: signin.html");
}
// if admin
else if ($_SESSION['user_id'] == 1) {
    header("Location: adminboard.php");
}
// if user, log in session
else {
    $user_check = $_SESSION['login_user'];
    $ses_sql = mysqli_query($conn, "select email from customer where email = '$user_check' ");
    $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
    $login_session = $row['email'];
}

?>