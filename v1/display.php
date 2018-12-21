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
    <div class="container">
            <div class='form-inline'>
                    <select class='form-control' id='menu_search' onchange='showImages()'>
                        <option value=''>Search by</option>
                        <option value='0'>Search by Latest</option>
                        <option value='1'>Search by Image Name</option>
                        <option value='2'>Search by Category</option>
                        <option value='3'>Search by Most Popular</option>
                        <option value='4'>Search by Least Popular</option>
                        <option value='5'>Search by Most Credit Needs</option>
                        <option value='6'>Search by Least Credit Needs</option>
                    </select>
                    <input class='form-control' type='text' id='menu_search_input' size='50' onchange='showImages()'>
                <br>
                <br>
            </div>
            <div id="showimage">Loading images ...</div>
     </div>
</body>
</html>