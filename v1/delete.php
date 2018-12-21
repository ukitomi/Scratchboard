<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Gallery</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
        include("db.php");

        $method = $_REQUEST['method'];
        $id = $_REQUEST['q'];
        $target_dir = "./uploads/";

        // admin manage images delete function
        if ($method == "Manage Images") {
            // delete the image from image table
            $stmt = $conn->prepare("DELETE FROM image where id = ?");
            $stmt->bind_param("i", $id);
            // delete the image from local directory
            $stmt2 = $conn->prepare("SELECT filename FROM image where id = ?");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $result = $stmt2->get_result();
            $row = $result->fetch_assoc();
            unlink($target_dir . $row['filename']);
            // delete the image from usergallery as well
            $stmt3 = $conn->prepare("DELETE FROM usergallery where image_id = ?");
            $stmt3->bind_param("i", $id);
            if ($stmt->execute() && $stmt3->execute()) {
                // // update user credits, person who own the image 
                // // -1 for uploading
                // // -purchased times * credit needed for images
                // $image_info = $conn->prepare("SELECT purchased, price, and author FROM image WHERE id = ?");
                // $image_info->bind_param("i", $id);
                // $image_info->execute();
                // $image_info_result = $image_info->get_result();
                // $credit_deduct = 1 + $image_info_result['purchased'] * $image_info_result['price'];
                // $author_info = $conn->prepare("SELECT * FROM customer WHERE id = ?");
                // $author_info->bind_param("i", $image_info_result['author']);
                // $author_info->execute();
                // $author_info_result = $author_info->get_result();
                // $current_credit = $author_info_result['credit'];
                // $new_credit = $current_credit - $credit_deduct;
                // $author_new_credit = $conn->prepare("UPDATE customer SET credit = ? WHERE id = ?");
                // $author_new_credit->bind_param("ii", $new_credit, $image_info_result['author']);
                // $author_new_credit->execute();

                // // update user credits, person who purchased the image before
                // // + credits back based on price 
                // $all_seller = $conn->prepare("SELECT user_id, price FROM transaction WHERE image_id = ?");
                // $all_seller->bind_param("i", $id);
                // $all_seller->execute();
                // $all_seller_result = $all_seller->get_result();
                // while ($each_buyer_id = $all_seller_result->fetch_assoc()) {
                //     // get user_id's credit from customer table
                //     $buyer_info = $conn->prepare("SELECT credit FROM customer WHERE id = ?");
                //     $buyer_info->bind_param("i", $each_buyer_id['user_id']);
                //     $buyer_info->execute();
                //     $buyer_info_result = $buyer_info->get_result();
                //     $old_credit = $buyer_info_result['credit'];
                //     $new_credit = $old_credit - $each_buyer_id['price'];
                //     $update_buyer_credit = $conn->prepare("UPDATE customer SET credit = ? WHERE id = ?");
                //     $update_buyer_credit->bind-param("ii", $new_credit, $each_buyer_id['user_id']);
                //     $update_buyer_credit->execute();

                // }
                header("Location: adminboard.php");
                exit;
            }
            else {           
            echo "
                <script language='javascript'>
                    window.alert('delete unsuccessful. Please retry');
                    window.location.href='adminboard.php';
                </script>
                ";
            }
        }
        // admin manage customer delete function
        else if ($method == "Manage Customers") {
            $stmt = $conn->prepare("DELETE FROM customer where id = ?");
            $stmt2 = $conn->prepare("DELETE FROM usergallery where user_id = ?");
            $stmt->bind_param("i", $id);
            $stmt2->bind_param("i", $id);
            if ($stmt->execute() && $stmt2->execute()) {
                header("Location: adminboard.php");
                exit;
            }
            else {           
            echo "
                <script language='javascript'>
                    window.alert('delete unsuccessful. Please retry);
                    window.location.href='adminboard.php';
                </script>
                ";
            }
        }
        // admin manage transactions delete function
        else if ($method == "Manage Transactions") {
            $stmt = $conn->prepare("DELETE FROM transaction where user_id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                header("Location: adminboard.php");
                exit;
            }
            else {           
            echo "
                <script language='javascript'>
                    window.alert('delete unsuccessful. Please retry);
                    window.location.href='adminboard.php';
                </script>
                ";
            }
        }
        // user delete of an image function
        else if ($method == "User Delete") {
            // normal deletion from the user
            $stmt = $conn->prepare("DELETE FROM image where id = ?");
            $stmt2= $conn->prepare("DELETE FROM usergallery where image_id = ?");
            $stmt->bind_param("i", $id);
            $stmt2->bind_param("i", $id);
            if ($stmt->execute() && $stmt2->execute()) {
                echo "
                <script language='javascript'>
                    window.alert('Delete successful!');
                    window.location.href='index.html';
                </script>
                ";
            }
            else {           
            echo "
                <script language='javascript'>
                    window.alert('delete unsuccessful. Please retry);
                    window.location.href='adminboard.php';
                </script>
                ";
            }
        }
    ?>
</body>
</html>