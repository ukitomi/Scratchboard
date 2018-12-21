<html lang="en">
    <body>
    <?php
    include("session.php");

    // if not log in
    if (!checkSession()) {
        echo "<li><a>Welcome, Guest.</a></li>
        <li><a href='signup.html'>Sign Up</a></li>
        <li><a href='signin.html'>Sign In</a></li>
        ";
    }
    else {
        // admin page 
        if ($user_id == 1) {
            echo "<li><a href='usergallery.php'>Welcome, ".$_SESSION['username']."</a></li>
            <li><a href='adminboard.php'>Admin Board</a></li>
            <li><a href='signout.php'>Sign Out</a></li>
            ";
        }
        // normal users
        else {
            echo "<li><a href='usergallery.php'>Welcome, ".$_SESSION['username']."</a></li>
            <li><a href='newimage.html'>Post new image</a></li>
            <li><a href='signout.php'>Sign Out</a></li>
            ";
        }
    }  
    ?>
    </body>
</html>