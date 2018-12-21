<?php
    include("db.php");

    $method = $_REQUEST['method'];
    $id = $_REQUEST['id'];
    $target_dir = "./uploads/";

    // search by id to find all customers
    if ($method == "1") {
        $stmt = $conn->prepare("SELECT user_id, date FROM transaction where image_id = ? ORDER BY user_id ASC");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo "
            <div class='table-responsive'>
                <table class='table'>
                    <tr>
                        <th>user_id</th>
                        <th>purchased date</th> 
                    </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "
                    <tr>
                        <td>".$row['user_id']."</td>
                        <td>".$row['date']."</td>
                    </tr>
            ";
        }
        echo "</table></div>";
    }
    // search by customers to find all images purchased
    else if ($method == "2") {
        $stmt = $conn->prepare("SELECT image_id, date FROM transaction where user_id = ? ORDER BY image_id ASC");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo "
            <div class='table-responsive'>
                <table class='table'>
                    <tr>
                        <th>image</th>
                        <th>image_id</th>
                        <th>purchased date</th> 
                    </tr>";
        while ($row = $result->fetch_assoc()) {
            $image = $conn->prepare("SELECT filename FROM image where id = ?");
            $image->bind_param("i", $row['image_id']);
            $image->execute();
            $image_result = $image->get_result();
            $row2 = $image_result->fetch_assoc();
            echo "
                    <tr>
                        <td><img src='".$target_dir.$row2['filename']."' width='42' height='42'></td>
                        <td>".$row['image_id']."</td>
                        <td>".$row['date']."</td>
                    </tr>
            ";
        }
        echo "</table></div>";
    }
    // search by most popular
    else if ($method == "3") {
        $stmt = $conn->prepare("SELECT * FROM image ORDER BY purchased DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        echo "
        <div class='table-responsive'>
            <table class='table'>
                <tr>
                    <th>image</th>
                    <th>image_id</th>
                    <th>purchased times</th> 
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "
                    <tr>
                        <td><img src='".$target_dir.$row['filename']."' width='42' height='42'></td>
                        <td>".$row['id']."</td>
                        <td>".$row['purchased']."</td>
                    </tr>
            ";
        }
        echo "</table></div>";
    }
    // search by least popular
    else if ($method == "4") {
        $stmt = $conn->prepare("SELECT * FROM image ORDER BY purchased ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        echo "
        <div class='table-responsive'>
            <table class='table'>
                <tr>
                    <th>image</th>
                    <th>image_id</th>
                    <th>purchased times</th> 
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "
                    <tr>
                        <td><img src='".$target_dir.$row['filename']."' width='42' height='42'></td>
                        <td>".$row['id']."</td>
                        <td>".$row['purchased']."</td>
                    </tr>
            ";
        }
        echo "</table></div>";
    }
    // search by most expensive
    else if ($method == "5") {
        $stmt = $conn->prepare("SELECT * FROM image ORDER BY price DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        echo "
        <div class='table-responsive'>
            <table class='table'>
                <tr>
                    <th>image</th>
                    <th>image_id</th>
                    <th>credit needed</th> 
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "
                    <tr>
                        <td><img src='".$target_dir.$row['filename']."' width='42' height='42'></td>
                        <td>".$row['id']."</td>
                        <td>".$row['price']."</td>
                    </tr>
            ";
        }
        echo "</table></div>";
    }
    // search by least expensive
    else if ($method == "6") {
        $stmt = $conn->prepare("SELECT * FROM image ORDER BY price ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        echo "
        <div class='table-responsive'>
            <table class='table'>
                <tr>
                    <th>image</th>
                    <th>image_id</th>
                    <th>credit needed</th> 
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "
                    <tr>
                        <td><img src='".$target_dir.$row['filename']."' width='42' height='42'></td>
                        <td>".$row['id']."</td>
                        <td>".$row['price']."</td>
                    </tr>
            ";
        }
        echo "</table></div>";
    }
?>