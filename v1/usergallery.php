<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Image Gallery</title>
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
      <script src="./functions.js"> </script>
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
      <div class='container'>
            <?php
            include("db.php");
            include("session.php");

            $get_user = $conn->prepare("SELECT * FROM customer WHERE id = ?");
            $get_user->bind_param("i", $_SESSION['user_id']);
            $get_user->execute();
            $result = $get_user->get_result();
            $row = $result->fetch_assoc();

            $owned_image = $conn->prepare("SELECT * FROM usergallery WHERE user_id = ? AND image_status = ?");
            $owned = "owned";
            $owned_image->bind_param("is", $_SESSION['user_id'], $owned);
            $owned_image->execute();
            $user_owned_image = $owned_image->get_result();

            $purchased_image = $conn->prepare("SELECT * FROM usergallery WHERE user_id = ? AND image_status = ?");
            $purchased = "purchased";
            $purchased_image->bind_param("is", $_SESSION['user_id'], $purchased);
            $purchased_image->execute();
            $user_purchased_image = $purchased_image->get_result();
            
            // every image id that you get, show them below
            echo "
            <div class='page-header'>
            <h1><strong>".$row['username']."'s Gallery </strong><span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>
            <small><span class='glyphicon glyphicon-copyright-mark' aria-hidden='true'></span>
                Credits Available: ".$row['credit']."</small></h1></div>
            <h4>".$row['username']." from ".$row['city'] . ", " . $row['state'] . ", " .$row['country'] ."</h4>
            <h5> have been a member on Imgurl since ".$row['created_at']."</h5>
            <div class='page-header'>
            <h1>Owned Images</h1></div>
            <div class='row text-center' style='display:flex; flex-wrap: wrap;'>";
            while ($row2 = $user_owned_image->fetch_assoc()) {
                $get_image = $conn->prepare("SELECT * FROM image WHERE id = ?");
                $get_image->bind_param("i", $row2['image_id']);
                $get_image->execute();
                $get_image_result = $get_image->get_result();
                $target_dir = "./uploads/";
                $row3 = $get_image_result->fetch_assoc();
                echo "<div class='col-md-3 col-sm-4'>
                            <div class='thumbnail'>
                                <img src='".$target_dir.$row3['filename']."'>
                                <div class='caption'>
                                    <h4>".$row3['name']."</h4>
                                </div>  
                                <p>
                                <form action='showinfo.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='image_id' value='".$row3['id']."'>
                                    <button name='showinfo' class='btn btn-primary'>More Info</button>
                                </form>
                                </p>
                            </div>
                        </div>";
            }
            echo "</div>
            <div class='page-header'>
            <h1>Purchased Images</h1></div>
            <div class='row text-center' style='display:flex; flex-wrap: wrap;'>";
            while ($row2 = $user_purchased_image->fetch_assoc()) {
                $get_image = $conn->prepare("SELECT * FROM image WHERE id = ?");
                $get_image->bind_param("i", $row2['image_id']);
                $get_image->execute();
                $get_image_result = $get_image->get_result();
                $target_dir = "./uploads/";
                $row3 = $get_image_result->fetch_assoc();
                echo "<div class='col-md-3 col-sm-4'>
                            <div class='thumbnail'>
                                <img src='".$target_dir.$row3['filename']."'>
                                <div class='caption'>
                                    <h4>".$row3['name']."</h4>
                                </div>  
                                <p>
                                <form action='showinfo.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='image_id' value='".$row3['id']."'>
                                    <button name='showinfo' class='btn btn-primary'>More Info</button>
                                </form>
                                </p>
                            </div>
                        </div>";

            }
            echo "</div>";
            ?>
          </div>
      </div>
    </body>