<?php
    include("db.php");
    include("session.php");
    
    $method = $_GET["method"];
    $str = $_GET["str"];
    $target_dir = "./uploads/";

    // search by latest
    if ($method == "0") {
        $stmt = $conn->prepare("SELECT * FROM image");
        $stmt->execute();
        $result = $stmt->get_result();
        showResults($result);
    }
    // Search by Image Name
    else if ($method == "1") {
        // we care about the field
        $stmt = $conn->prepare("SELECT * FROM image where name = ?");
        $stmt->bind_param("s", $str);
        $stmt->execute();
        $result = $stmt->get_result();
        showResults($result);
    }
    // Search by Category
    else if ($method == "2") {
        $stmt = $conn->prepare("SELECT * FROM image where category = ?");
        $stmt->bind_param("s", $str);
        $stmt->execute();
        $result = $stmt->get_result();
        showResults($result);
    }
    // Search by Most Popular
    else if ($method == "3") {
        $stmt = $conn->prepare("SELECT * FROM image ORDER BY purchased DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        showResults($result);
    }
    // Search by Least Popular
    else if ($method == "4") {
        $stmt = $conn->prepare("SELECT * FROM image ORDER BY purchased ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        showResults($result);
    }
    // Search by most credit needed
    else if ($method == "5") {
        $stmt = $conn->prepare("SELECT * FROM image ORDER BY price DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        showResults($result);
    }
    // Search by least credit needed
    else if ($method == "6") {
        $stmt = $conn->prepare("SELECT * FROM image ORDER BY price ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        showResults($result);
    }

    function showResults($result) {
        $target_dir = "./uploads/";
        echo "
        <div class='container'>
            <div class='row text-center' style='display:flex; flex-wrap: wrap;'>";
            while ($row2 = $result->fetch_assoc()) {
                ob_start();
                watermark($row2['filename'], $row2['image_type']);
                $image = ob_get_contents();
                ob_end_clean();
                echo "<div class='col-md-3 col-sm-4'>
                            <div class='thumbnail'>
                                <img src='data:image/;base64," . base64_encode($image) . "'/>
                                <div class='caption'>
                                    <h4>".$row2['name']."</h4>
                                </div>  
                                <p>
                                <form action='showinfo.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='image_id' value='".$row2['id']."'>
                                    <button name='showinfo' class='btn btn-primary'>More Info</button>
                                </form>
                                </p>
                            </div>
                        </div>";
                    }
        echo "</div> </div>";
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