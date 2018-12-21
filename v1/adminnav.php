<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Gallery</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> 
</head>
<body>
    <script src="./functions.js"></script>
    <?php
        include("db.php");
        $method = $_REQUEST['method'];
        $target_dir = "./uploads/";
        
        // search transaction by id or customer 
        if ($method == "Search") {
            echo "
            <form>
            <div class='form-inline'>
                <select class='form-control' id='option1' onchange='search()'>
                    <option value=''>Search by</option>
                    <option value='1'>Search by image id to find all customers</option>
                    <option value='2'>Search by customers to find all images</option>
                    <option value='3'>Search by most popular</option>
                    <option value='4'>Search by least popular</option>
                    <option value='5'>Search by most expensive</option>
                    <option value='6'>Search by least expensive</option>
                </select>
                <input class='form-control' type='text' id='option2' onchange='search()' placeholder='Enter a number here' size='50'>
                <br>
                <div id='listings'>info will be listed here...</div>
            </div>
            </form>";
        }
        // manage all images, edit and remove
        else if ($method == "Manage Images") {
            $stmt = $conn->prepare("SELECT * FROM image");
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                echo "
                <div class='table-responsive'>
                    <table class='table'>
                        <tr>
                            <th>image</th>
                            <th>image_id</th>
                            <th>image name</th>
                            <th>category</th> 
                            <th>author_id</th> 
                            <th>resolution</th>  
                            <th>size</th>
                            <th>purchased</th>    
                            <th>credit required</th>
                            <th>operation</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td><img src='".$target_dir.$row['filename']."' width='42' height='42'></td>
                        <td>".$row['id']."</td>
                        <td>".$row['name']."</td>
                        <td>".$row['category']."</td>
                        <td>".$row['author']."</td>
                        <td>".$row['resolution']."</td>
                        <td>".$row['size']."</td>
                        <td>".$row['purchased']."</td>
                        <td>".$row['price']."</td>
                        <td>
                        <a href='updateimage.php?id=".$row['id']."' class='btn btn-default btn-xs btn-warning'>Edit</a>
                        <a href='delete.php?method=".$method."&q=".$row['id']."' class='btn btn-default btn-xs btn-danger'>Delete</a>
                        </td>
                    </tr>
                    ";
                }
                echo "</table></div>";
            }
            else {
                echo "No images post in the server yet.";
            }
        }
        // manage all customers, edit or remove
        else if ($method == "Manage Customers") {
            $stmt = $conn->prepare("SELECT * FROM customer WHERE id > 1");
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                echo "
                <div class='table-responsive'>
                    <table class='table'>
                        <tr>
                            <th>customer_id</th>
                            <th>username</th>
                            <th>firstname</th>
                            <th>lastname</th> 
                            <th>email</th> 
                            <th>credit available</th>  
                            <th>operation</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>".$row['id']."</td>
                        <td>".$row['username']."</td>
                        <td>".$row['firstname']."</td>
                        <td>".$row['lastname']."</td>
                        <td>".$row['email']."</td>
                        <td>".$row['credit']."</td>
                        <td>
                        <a href='delete.php?method=".$method."&q=".$row['id']."' class='btn btn-default btn-xs btn-danger'>Delete</a>
                        </td>
                    </tr>
                    ";
                }
                echo "</table></div>";
            }
            else {
                echo "No customers registered on the website yet.";
            }

        }
        // manage all transactions, edit or remove
        else if ($method == "Manage Transactions") {
            $stmt = $conn->prepare("SELECT * FROM transaction");
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                echo "
                <div class='table-responsive'>
                    <table class='table'>
                        <tr>
                            <th>customer_id</th>
                            <th>image_id</th>
                            <th>date</th>
                            <th>credit needed for this purchase</th> 
                            <th>operation</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>".$row['user_id']."</td>
                        <td>".$row['image_id']."</td>
                        <td>".$row['date']."</td>
                        <td>".$row['price']."</td>
                        <td>
                        <a href='delete.php?method=".$method."&q=".$row['user_id']."' class='btn btn-default btn-xs btn-danger'>Delete</a>
                        </td>
                    </tr>
                    ";
                }
                echo "</table></div>";
            }
            else {
                echo "No transactions have made on the website yet.";
            }
        }
    ?>
    
</body>
</html>