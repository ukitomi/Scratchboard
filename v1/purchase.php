<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Gallery</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> 
    
    <script src='./functions.js'> </script> 
    </head>
<body>        
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Imgurl</a>
                <ul class="nav navbar-nav navbar-left">
                   <li><a href="display.php">View All Collections</a></li>
               </ul>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right" id="user">
                <script>
                    loggedIn();
                </script>
                </ul>
            </div>
        </div>
    </nav>

    <?php
        include("logged.php");

        if (isset($_POST['purchase'])) {
            // get the credit for buyer
            $buyer_credit = $conn->prepare("SELECT credit FROM customer where id = ?");
            $buyer_credit->bind_param("i", $_SESSION['user_id']);
            if (!$buyer_credit->execute()) {
                echo "<script language='javascript'>
                window.alert('Unable to identicate your identity. Please try to re-login');
                window.location.href='index.html';
                </script>";
            }
            else {
                $buyer_result = $buyer_credit->get_result();
                $buyer_row = mysqli_fetch_array($buyer_result, MYSQLI_ASSOC);
                // if buyer's credit is less than 0, unable to purchase
                if ($buyer_row['credit'] < 0 || $buyer_row['credit'] < $_POST['price']) {
                    echo "<script language='javascript'>
                    window.alert('You don't have enough credits to do this transaction');
                    window.location.href='index.html';
                    </script>";
                }
            }
            $buyer_result;
            $buyer_row;

            // get the credit for seller
            $seller_credit = $conn->prepare("SELECT credit FROM customer where id = ?");
            $seller_credit->bind_param("i", $_POST['customer_id']);
            if (!$seller_credit->execute()) {
                echo "<script language='javascript'>
                window.alert('Unable to identicate the seller. Please try purchase another image');
                window.location.href='index.html';
                </script>";
            }
            else {
                $seller_result = $seller_credit->get_result();
                $seller_row = mysqli_fetch_array($seller_result, MYSQLI_ASSOC);
                echo $seller_row['credit'];
            }           
            $seller_result;
            $seller_row;

            // get the credit needed for this image 
            $credit = $_POST['price'];

            // subtract the credit from buyer, add the credit for seller, update db
            $new_buyer_credit = $buyer_row['credit'] - $credit;
            $new_seller_credit = $seller_row['credit'] + $credit;

            $buyer_update = $conn->prepare("UPDATE customer SET credit = ? WHERE id = ?");
            $buyer_update->bind_param("ii", $new_buyer_credit, $_SESSION['user_id']);

            $seller_update = $conn->prepare("UPDATE customer SET credit = ? WHERE id = ?");
            $seller_update->bind_param("ii", $new_seller_credit, $_POST['customer_id']);
            
            // update the purchase time for the image
            $purchase_update = $conn->prepare("UPDATE image SET purchased = ? WHERE id = ?");
            $new_purchased = $_POST['purchased_times'] + 1;
            $purchase_update->bind_param("ii", $new_purchased, $_POST['image_id']);

            $transaction_update = $conn->prepare("INSERT INTO transaction (user_id, image_id, date, price) VALUES (?, ?, now(), ?)");
            $transaction_update->bind_param("iii", $_SESSION['user_id'], $_POST['image_id'], $_POST['price']);

            $user_gallery_update = $conn->prepare("INSERT INTO usergallery (user_id, image_id, image_status) VALUES (?, ?, ?)");
            $status = "purchased";
            $user_gallery_update->bind_param("iis", $_SESSION['user_id'], $_POST['image_id'], $status);
            if ($buyer_update->execute() && $seller_update->execute() && $purchase_update->execute() && $transaction_update->execute() && $user_gallery_update->execute()) {
                echo "<script language='javascript'>
                window.alert('Purchase Successful! Check your gallery');
                window.location.href='index.html';
                </script>";
            }
            else {
                echo "<script language='javascript'>
                window.alert('Purchase unsuccessful, please retry');
                window.location.href='index.html';
                </script>";
            }


        }
    ?>

    </body>
</html>