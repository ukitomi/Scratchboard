<?php
include("db.php");

$target_dir = "./uploads/";
$sql = "SELECT * FROM image";
$result = mysqli_query($conn, $sql);
var_dump($_POST);
if(isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $firstname = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);
    $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
    $city = mysqli_real_escape_string($conn, $_REQUEST['city']);
    $state = $_POST['stateselect'];
    $country = $_POST['countryselect'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO customer (username, firstname, lastname, email, password, created_at, city, state, country) VALUES (?, ?, ?, ?, ?, now(), ?, ?, ?)");
    $stmt->bind_param("ssssssss", $username, $firstname, $lastname, $email, $hash, $city, $state, $country);

    if ($stmt->execute()) {
        header('Location: index.html');
        exit;
    }
    else {
        echo "Operation failed." . $mysqli->error;
        // TODO
        echo "Please go back to previous page";
    }

}

?>