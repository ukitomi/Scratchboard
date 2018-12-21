<?php
    include("db.php");
    include("session.php");
    var_dump($_POST);
    
    if (isset($_POST['update-image'])) {
        $id = $_POST['image-id'];
        if ($_POST['new-image-name'] != "" && $_POST['new-category'] != "") {
            $new_image_name = mysqli_real_escape_string($conn, $_POST['new-image-name']);
            $new_image_category = mysqli_real_escape_string($conn, $_POST['new-category']);
            $update = $conn->prepare("UPDATE image set name = ? , category = ? WHERE id = ?");
            $update->bind_param("ssi", $new_image_name, $new_image_category, $id);
            if ($update->execute()) {
                // if admin
                if ($_SESSION['user_id'] == 1) {
                    echo "
                    <script language='javascript'>
                        window.alert('Update successful.');
                        window.location.href='adminboard.php';
                    </script>
                    ";  
                }
                else {
                    echo "
                    <script language='javascript'>
                        window.alert('Update successful.');
                        window.location.href='usergallery.php';
                    </script>
                    ";
                }
            }
        }
        else if ($_POST['new-image-name'] != "") {
            $new_image_name = mysqli_real_escape_string($conn, $_REQUEST['new-image-name']);
            $update = $conn->prepare("UPDATE image set name = ? WHERE id = ?");
            $update->bind_param("ssi", $new_image_name, $id);
            if ($update->execute()) {
                // if admin
                if ($_SESSION['user_id'] == 1) {
                    echo "
                    <script language='javascript'>
                        window.alert('Update successful.');
                        window.location.href='adminboard.php';
                    </script>
                    ";  
                }
                else {
                    echo "
                    <script language='javascript'>
                        window.alert('Update successful.');
                        window.location.href='usergallery.php';
                    </script>
                    ";
                }
            }
        }
        else if ($_POST['new-category'] != "") {
            $new_image_category = mysqli_real_escape_string($conn, $_REQUEST['new-category']);
            $update = $conn->prepare("UPDATE image set category = ? WHERE id = ?");
            $update->bind_param("ssi", $new_image_category, $id);
            if ($update->execute()) {
                // if admin
                if ($_SESSION['user_id'] == 1) {
                    echo "
                    <script language='javascript'>
                        window.alert('Update successful.');
                        window.location.href='adminboard.php';
                    </script>
                    ";  
                }
                else {
                    echo "
                    <script language='javascript'>
                        window.alert('Update successful.');
                        window.location.href='usergallery.php';
                    </script>
                    ";
                }
            }
        }
        else {
            echo "
            <script language='javascript'>
                window.alert('No action is taken.');
                window.location.href='usergallery.php';
            </script>
            ";
        }        
    }

?>