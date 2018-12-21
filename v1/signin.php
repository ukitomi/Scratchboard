<?php
    include("db.php");
    session_start();

    if (isset($_POST['signin'])) {
        // username and password sent from form 
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn ,$_POST['password']); 
        // get the id parameter from URL
        $stmt = $conn->prepare("SELECT id, password, username FROM customer where email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $hash = $row['password'];
        $user_id = $row['id'];
        $username = $row['username'];
        $count = mysqli_num_rows($result);
        echo $count;
        if ($count == 1) {
            echo "inside";
            if (password_verify($password, $hash)) {
                $_SESSION['login_user'] = $email;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                header('Location: index.html');
                exit;
            }
            else {
                echo "<script language='javascript'>
                window.alert('Login unsuccessful. Incorrect password. Please retry');
                window.location.href='index.html';
                </script>";
            }
        }
        else {
            echo "<script language='javascript'>
            window.alert('Login unsuccessful. Unable to identify user');
            window.location.href='index.html';
            </script>";
        }
    }
?>