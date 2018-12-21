<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image Gallery</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">       
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
                    <script src="functions.js">
                        loggedIn();
                    </script>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <form action="update.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="new-image-name">Image Name</label>
                    <input type="text" name="new-image-name" class="form-control" id="new-image-name" placeholder="leave blank if omitted">
                </div>
                <div class="form-group">
                    <label for="new-category">Category</label>
                    <input type="text" name="new-category" class="form-control" id="new-category" placeholder="leave blank if omitted">
                </div>
                <input type="hidden" name="image-id" value="<?php echo $_GET['id']?>">
                <button type="submit" class="btn btn-default" name="update-image">Update</button>
            </form>
        </div>
    </body>
</html>

