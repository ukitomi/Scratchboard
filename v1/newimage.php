<?php
// reference: https://www.w3schools.com/php/php_file_upload.asp
include("db.php");
include("session.php");

$target_dir = "/Applications/XAMPP/xamppfiles/htdocs/finalproject/uploads/";

$uploadOk = 1;
if(isset($_POST['newimage'])) {
    $file = $_FILES['fileToUpload']['name'];
    $target_file = $target_dir . basename($file);

    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script language='javascript'>
            window.alert('Upload unsuccessful. This is not an image.');
            window.location.href='index.html';
        </script>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<script language='javascript'>
            window.alert('Upload unsuccessful. This has already been uploaded.');
            window.location.href='index.html';
        </script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "<script language='javascript'>
            window.alert('Upload unsuccessful. only JPG, JPEG, PNG & GIF files are allowed.');
            window.location.href='index.html';
            </script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script language='javascript'>
        window.alert('Your file was not uploaded. Please retry.');
        window.location.href='index.html';
        </script>";
    // if everything is ok, try to upload file and upload to the database
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // escape user inputs for security
            $name = mysqli_real_escape_string($conn, $_REQUEST['imagename']);
            $category = mysqli_real_escape_string($conn, $_REQUEST['category']);
            $resolution = $check[0]."x".$check[1];
            $type = $check['mime'];
            $size = $_FILES['fileToUpload']['size'];
            $filename = basename($file);
            $price = mysqli_real_escape_string($conn, $_REQUEST['price']);
            $stmt = $conn->prepare("INSERT INTO image (name, author, category, resolution, image_type, size, filename, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssisi", $name, $_SESSION['user_id'], $category, $resolution, $type, $size, $filename, $price);
    
            // grant user one credit for uploading one
            // if someone buys the image, the author gets the corresponding credit
            $stmt2 = $conn->prepare("SELECT credit FROM customer where id = ?");
            $stmt2->bind_param("i", $_SESSION['user_id']);
            $stmt2->execute();
            if ($stmt2->execute()) {
                $result2 = $stmt2->get_result();
                $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
                $newCredit = $row2['credit'] + 1;
                $stmt3 = $conn->prepare("UPDATE customer SET credit = ? WHERE id = ?");
                $stmt3->bind_param("ii", $newCredit, $_SESSION['user_id']);
                $stmt3->execute();

                if ($stmt->execute() && $stmt3->execute()) {
                    $new_image_id_selection = $conn->prepare("SELECT id FROM image WHERE name = ? AND author =? AND category = ? AND filename = ? AND size = ?");
                    $new_image_id_selection->bind_param("sissi", $name, $_SESSION['user_id'], $category, $filename, $size);
                    $new_image_id_selection->execute();
                    $new_image_id = $new_image_id_selection->get_result();
                    $row4 = mysqli_fetch_array($new_image_id, MYSQLI_ASSOC);
                    $new_id = $row4['id'];
                    // insert new imgaes into user gallery
                    $stmt4 = $conn->prepare("INSERT INTO usergallery (user_id, image_id, image_status) VALUES (?, ?, ?)");
                    $status_name = "owned";
                    $stmt4->bind_param("iis", $_SESSION['user_id'], $new_id, $status_name);
                    $stmt4->execute();

                    echo "<script language='javascript'>
                    window.alert('Upload Successful!');
                    window.location.href='index.html';
                    </script>";
                    exit;
                }
                else {
                    echo "<script language='javascript'>
                    window.alert('Upload unsuccessful. Please retry!');
                    window.location.href='index.html';
                    </script>";
                }
            }
        } else {
            echo "<script language='javascript'>
            window.alert('Upload unsuccessful. Please check the fields of the image.');
            window.location.href='index.html';
            </script>";
        }
    }
}

?>