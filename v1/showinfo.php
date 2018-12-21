<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image Gallery</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> 
        <script src='./functions.js'>
        </script> 
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
        <div class="container">
            <?php
                include("logged.php");
                include("db.php");
                if (isset($_POST['showinfo'])) {
                    $id = $_POST['image_id'];
                    $target_dir = "./uploads/";
                    // get the id parameter from URL
                    $stmt = $conn->prepare("SELECT * FROM image where id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_assoc()) {
                        ob_start();
                        watermark($row['filename'], $row['image_type']);
                        $image = ob_get_contents();
                        ob_end_clean();
                        echo "
                        
                        <div class='container'>
                            <div class='col-md-6 col-sm-3 thumbnail'>
                                <img src='data:image/;base64," . base64_encode($image) . "'/>
                            </div>
                            <div class='col-md-6 col-sm-3'>
                                <form class='form-horizontal' action='purchase.php' method='POST' enctype='multipart/form-data'>
                                    <div class='form-group'>
                                        <label class='col-sm-2 control-label'>Image name:</label>
                                        <div class='col-sm-10'>
                                            <h4>".$row['name']."</h4>
                                            <input type='hidden' name='image_id' value=".$row['id'].">
                                            <input type='hidden' name='price' value=".$row['price'].">
                                            <input type='hidden' name='customer_id' value=".$row['author'].">
                                            <input type='hidden' name='purchased_times' value=".$row['purchased'].">
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-sm-2 control-label'>Category</label>
                                        <div class='col-sm-10'>
                                            <h4>".$row['category']."</h4>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-sm-2 control-label'>Resolution</label>
                                            <div class='col-sm-10'>
                                                <h4>".$row['resolution']."</h4>
                                            </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-sm-2 control-label'>Size</label>
                                            <div class='col-sm-10'>
                                                <h4>".$row['size']."bytes</h4>
                                            </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-sm-2 control-label'>Purchased Times</label>
                                            <div class='col-sm-10'>
                                                <h4>".$row['purchased']." times</h4>
                                            </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-sm-2 control-label'>Credit Required</label>
                                            <div class='col-sm-10'>
                                                <h4>".$row['price']." credit</h4>
                                            </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='col-sm-offset-2 col-sm-10'>
                                            <button name='purchase' type='submit' class='btn btn-default btn-success'>Purchase</button>
                                        </div>
                                    </div>";
                                    // if the user is the image's author
                                    if ($row['author'] == $_SESSION['user_id']) {
                                        echo "
                                        <div class='form-group'>
                                            <div class='col-sm-offset-2 col-sm-10'>
                                                <a href='updateimage.php?id=".$id."' class='btn btn-info'>Update</a>
                                            </div>
                                        </div>
                                        ";
                                        echo "
                                        <div class='form-group'>
                                            <div class='col-sm-offset-2 col-sm-10'>
                                                <a href='delete.php?method=User Delete&q=".$id."' class='btn btn-warning'>Delete</a>
                                            </div>
                                        </div>
                                        ";
                                    }
                                    // download if the image exists in the user's gallery
                                    $exist_image = $conn->prepare("SELECT * FROM usergallery where image_id = ?");
                                    $exist_image->bind_param("i", $id);
                                    $exist_image->execute();
                                    $exist_image_result = $exist_image->get_result();
                                    // this will return user that own or purchased this image
                                    while ($exist_image_row = $exist_image_result->fetch_assoc()) {
                                        if ($exist_image_row['user_id'] == $_SESSION['user_id']) {
                                            echo "
                                            <div class='form-group'>
                                                <div class='col-sm-offset-2 col-sm-10'>
                                                    <a href='".$target_dir.$row['filename']."' class='btn btn-danger' download>Download</a>
                                                </div>
                                            </div>
                                            ";
                                        }
                                    }
                                    
                                    echo "
                                </form>
                            </div>
                        </div>
                        ";
                    }
                }
                else {
                    echo "<script language='javascript'>
                    window.alert('Unable to read image');
                    window.location.href='index.html';
                    </script>";
                }
                
                function watermark($image, $type) {
                    $target_dir = "./uploads/";
                    $stamp = imagecreatefrompng($target_dir.'watermark.png');
                    $im;
                    if ($type == "image/jpeg") {
                        $im = imagecreatefromjpeg($target_dir.$image);
                        // Reference
                        // http://php.net/manual/en/image.examples-watermark.php
                        // Set the margins for the stamp and get the height/width of the stamp image
                        $marge_right = 1;
                        $marge_bottom = 1;
                        $sx = imagesx($stamp);
                        $sy = imagesy($stamp);
            
                        // Copy the stamp image onto our photo using the margin offsets and the photo 
                        // width to calculate positioning of the stamp. 
                        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
                    }
                    else if ($type == "image/png") {
                        // Reference
                        // https://stackoverflow.com/questions/26164591/php-imagecopy-and-imagecopymerge-dont-work-with-two-png
                        // image blending with two png
                        $im = imagecreatefrompng($target_dir.$image);
                        imagealphablending($im, true);
                        imagealphablending($stamp, true);
                        imagesavealpha($im, true);
                        imagesavealpha($stamp, true);
                        imagecopy ($im, $stamp, 5, imagesy($im) - (imagesy($stamp)+5), 0, 0,imagesx($stamp),imagesy($stamp));
                        imagealphablending($im, true);
                        imagesavealpha($im, true);
                    }
            
                    // Output and free memory
                    // header('Content-type: image/png');
                    imagepng($im);
                    imagedestroy($im);
                    imagedestroy($stamp);
                }
            ?>
        </div>
    </body>
</html>

