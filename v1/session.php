<?php
    include("db.php");
    session_start();

    if (!isset($_SESSION['login_user'])) {
        //header("Location: signin.html");
        echo "<script language='javascript'>
        window.alert('Not able to locate user');
        </script>";
    }
    else {
        $user_check = $_SESSION['login_user'];
        $ses_sql = mysqli_query($conn, "select email, id, username from customer where email = '$user_check'");
        $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
        $login_session = $row['email'];
        $username = $row['username'];
        $user_id = $row['id'];
    }

    function checkSession() {
        if(!isset($_SESSION['login_user'])){
            return false;
        }
        else {
          return true;
        }
    }
?>